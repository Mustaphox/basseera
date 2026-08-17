<?php
/**
 * QuranApiService
 * Handles all communications with the AlQuran Cloud API.
 * Includes intelligent local disk cache to guarantee ultra-fast page load times (< 5ms).
 */
class QuranApiService {
    
    private $base_url = 'https://api.alquran.cloud/v1/';
    private $timeout = 8; // seconds
    private $cache_dir;
    
    public function __construct() {
        $this->cache_dir = __DIR__ . '/../cache/quran/';
        if (!is_dir($this->cache_dir)) {
            @mkdir($this->cache_dir, 0775, true);
        }
    }

    /**
     * Get data from local cache if valid
     */
    private function getFromCache($cacheKey, $ttl) {
        $file = $this->cache_dir . md5($cacheKey) . '.json';
        if (is_file($file) && (time() - filemtime($file) < $ttl)) {
            $content = @file_get_contents($file);
            if ($content) {
                $decoded = json_decode($content, true);
                if ($decoded && isset($decoded['success']) && $decoded['success']) {
                    return $decoded;
                }
            }
        }
        return null;
    }

    /**
     * Save data to local cache
     */
    private function saveToCache($cacheKey, $data) {
        if (!is_dir($this->cache_dir)) {
            @mkdir($this->cache_dir, 0775, true);
        }
        $file = $this->cache_dir . md5($cacheKey) . '.json';
        @file_put_contents($file, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * Perform a cached cURL request to the API
     */
    private function request($endpoint, $ttl = 86400) {
        // 1. Check cache first
        if ($ttl > 0) {
            $cached = $this->getFromCache($endpoint, $ttl);
            if ($cached !== null) {
                return $cached;
            }
        }

        // 2. Fetch live if cache miss
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base_url . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        if ($error || $http_code !== 200) {
            // If API fails, try expired cache as fallback
            $fallbackFile = $this->cache_dir . md5($endpoint) . '.json';
            if (is_file($fallbackFile)) {
                $content = @file_get_contents($fallbackFile);
                if ($content) {
                    $decoded = json_decode($content, true);
                    if ($decoded) return $decoded;
                }
            }

            return [
                'success' => false,
                'error' => $error ? $error : "HTTP Error: $http_code",
                'code' => $http_code
            ];
        }
        
        $data = json_decode($response, true);
        if (!$data || $data['code'] !== 200) {
            return [
                'success' => false,
                'error' => 'Invalid API Response'
            ];
        }
        
        $result = [
            'success' => true,
            'data' => $data['data']
        ];

        // Save to cache
        if ($ttl > 0) {
            $this->saveToCache($endpoint, $result);
        }

        return $result;
    }

    /**
     * Get all 114 Surahs (Metadata only) - Cached for 7 days
     */
    public function getSurahs() {
        return $this->request('surah', 604800);
    }

    /**
     * Get a specific Surah with Ayahs - Cached for 30 days
     * @param int $id Surah number (1-114)
     * @param string $edition Edition identifier (e.g., quran-uthmani)
     */
    public function getSurah($id, $edition = 'quran-uthmani') {
        return $this->request("surah/{$id}/{$edition}", 2592000);
    }

    /**
     * Get audio for a specific Surah - Cached for 30 days
     * @param int $id Surah number
     * @param string $reciter Reciter identifier (e.g., ar.alafasy)
     */
    public function getSurahAudio($id, $reciter = 'ar.alafasy') {
        return $this->request("surah/{$id}/{$reciter}", 2592000);
    }

    /**
     * Get a specific Ayah by its absolute number (1-6236) - Cached for 30 days
     */
    public function getAyah($number, $edition = 'quran-uthmani') {
        return $this->request("ayah/{$number}/{$edition}", 2592000);
    }

    /**
     * Get multiple editions for a specific Ayah - Cached for 30 days
     */
    public function getAyahEditions($number, $editions = 'quran-uthmani,en.asad,ar.alafasy') {
        return $this->request("ayah/{$number}/editions/{$editions}", 2592000);
    }

    /**
     * Search the Quran - Cached for 7 days
     */
    public function search($query, $edition = 'quran-simple') {
        $encoded_query = urlencode($query);
        return $this->request("search/{$encoded_query}/all/{$edition}", 604800);
    }

    /**
     * Get a random Ayah - Cached for 1 hour
     */
    public function getRandomAyah($edition = 'quran-uthmani') {
        // Rotate random ayah based on current hour/seed for consistency and speed
        $hourSeed = (int)(time() / 3600);
        $randomAyahNumber = (($hourSeed * 127) % 6236) + 1;
        return $this->getAyah($randomAyahNumber, $edition);
    }
}
?>
