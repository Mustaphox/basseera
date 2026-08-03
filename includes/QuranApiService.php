<?php
/**
 * QuranApiService
 * Handles all communications with the AlQuran Cloud API.
 * Ensures no Quran data is saved to MySQL, fetching live data on every request.
 */
class QuranApiService {
    
    private $base_url = 'https://api.alquran.cloud/v1/';
    private $timeout = 10; // seconds
    
    /**
     * Perform a cURL request to the API
     */
    private function request($endpoint) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base_url . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        // Disable SSL verification for local dev if needed, but best kept true in prod
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        if ($error || $http_code !== 200) {
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
        
        return [
            'success' => true,
            'data' => $data['data']
        ];
    }

    /**
     * Get all 114 Surahs (Metadata only)
     */
    public function getSurahs() {
        return $this->request('surah');
    }

    /**
     * Get a specific Surah with Ayahs
     * @param int $id Surah number (1-114)
     * @param string $edition Edition identifier (e.g., quran-uthmani)
     */
    public function getSurah($id, $edition = 'quran-uthmani') {
        return $this->request("surah/{$id}/{$edition}");
    }

    /**
     * Get audio for a specific Surah
     * @param int $id Surah number
     * @param string $reciter Reciter identifier (e.g., ar.alafasy)
     */
    public function getSurahAudio($id, $reciter = 'ar.alafasy') {
        return $this->request("surah/{$id}/{$reciter}");
    }

    /**
     * Get a specific Ayah by its absolute number (1-6236)
     */
    public function getAyah($number, $edition = 'quran-uthmani') {
        return $this->request("ayah/{$number}/{$edition}");
    }

    /**
     * Get multiple editions for a specific Ayah (e.g., Arabic, Translation, Audio)
     */
    public function getAyahEditions($number, $editions = 'quran-uthmani,en.asad,ar.alafasy') {
        return $this->request("ayah/{$number}/editions/{$editions}");
    }

    /**
     * Search the Quran
     * @param string $query Text to search
     * @param string $edition Search edition (e.g., quran-simple for Arabic text search)
     */
    public function search($query, $edition = 'quran-simple') {
        $encoded_query = urlencode($query);
        return $this->request("search/{$encoded_query}/all/{$edition}");
    }

    /**
     * Get random Ayah
     */
    public function getRandomAyah() {
        $random = rand(1, 6236);
        return $this->getAyah($random);
    }
}
