<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/QuranApiService.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if (empty($q)) {
    echo json_encode(['success' => false, 'error' => 'يرجى إدخال كلمة للبحث']);
    exit;
}

$quranApi = new QuranApiService();

// Arabic text normalizer helper
function normalizeArabic($text) {
    $text = preg_replace('/[\x{064B}-\x{065F}\x{0670}\x{06D6}-\x{06ED}]/u', '', $text); // Strip Tashkeel
    $text = preg_replace('/[إأآا]/u', 'ا', $text);
    $text = str_replace(['ة'], 'ه', $text);
    $text = str_replace(['ى'], 'ي', $text);
    $text = str_replace(['سورة', 'سورة '], '', $text);
    return trim(mb_strtolower($text, 'UTF-8'));
}

$normQ = normalizeArabic($q);

// 1. Search Surahs Metadata
$surahsMatches = [];
$surahsResp = $quranApi->getSurahs();
if ($surahsResp['success'] && !empty($surahsResp['data'])) {
    foreach ($surahsResp['data'] as $s) {
        $normName = normalizeArabic($s['name']);
        $normEnName = mb_strtolower($s['englishName'], 'UTF-8');
        $normEnTrans = mb_strtolower($s['englishNameTranslation'], 'UTF-8');
        $sNum = (string)$s['number'];

        if (
            strpos($normName, $normQ) !== false ||
            strpos($normEnName, $normQ) !== false ||
            strpos($normEnTrans, $normQ) !== false ||
            $sNum === $normQ
        ) {
            $surahsMatches[] = [
                'number' => $s['number'],
                'name' => $s['name'],
                'englishName' => $s['englishName'],
                'englishNameTranslation' => $s['englishNameTranslation'],
                'revelationType' => $s['revelationType'] === 'Meccan' ? 'مكية' : 'مدنية',
                'numberOfAyahs' => $s['numberOfAyahs']
            ];
        }
    }
}

// 2. Search Quran Ayahs
$ayahsMatches = [];
$ayahSearchResp = $quranApi->search($q, 'quran-simple');
if ($ayahSearchResp['success'] && isset($ayahSearchResp['data']['matches'])) {
    foreach ($ayahSearchResp['data']['matches'] as $m) {
        $ayahsMatches[] = [
            'number' => $m['number'],
            'numberInSurah' => $m['numberInSurah'],
            'text' => $m['text'],
            'surah' => [
                'number' => $m['surah']['number'],
                'name' => str_replace('سُورَةُ ', '', $m['surah']['name']),
                'englishName' => $m['surah']['englishName']
            ]
        ];
    }
}

// 3. Search Hadiths from Database (if available)
$hadithsMatches = [];
try {
    $stmt = $pdo->prepare("SELECT text_arabic, narrator, reference, grade FROM hadiths WHERE text_arabic LIKE ? OR narrator LIKE ? LIMIT 15");
    $stmt->execute(["%$q%", "%$q%"]);
    while ($row = $stmt->fetch()) {
        $hadithsMatches[] = [
            'text' => $row->text_arabic,
            'narrator' => $row->narrator,
            'reference' => $row->reference,
            'grade' => $row->grade
        ];
    }
} catch (Exception $e) {}

// 4. Search Azkar & Duaas from Database (if available)
$azkarMatches = [];
try {
    $stmt = $pdo->prepare("SELECT text_arabic, reference, count FROM azkar WHERE text_arabic LIKE ? LIMIT 10");
    $stmt->execute(["%$q%"]);
    while ($row = $stmt->fetch()) {
        $azkarMatches[] = [
            'text' => $row->text_arabic,
            'reference' => $row->reference,
            'count' => $row->count,
            'type' => 'ذكر'
        ];
    }

    $stmt2 = $pdo->prepare("SELECT text_arabic, reference FROM duas WHERE text_arabic LIKE ? LIMIT 10");
    $stmt2->execute(["%$q%"]);
    while ($row = $stmt2->fetch()) {
        $azkarMatches[] = [
            'text' => $row->text_arabic,
            'reference' => $row->reference,
            'count' => 1,
            'type' => 'دعاء'
        ];
    }
} catch (Exception $e) {}

$totalCount = count($surahsMatches) + count($ayahsMatches) + count($hadithsMatches) + count($azkarMatches);

echo json_encode([
    'success' => true,
    'query' => $q,
    'total_count' => $totalCount,
    'surahs' => $surahsMatches,
    'ayahs' => $ayahsMatches,
    'hadiths' => $hadithsMatches,
    'azkar' => $azkarMatches
], JSON_UNESCAPED_UNICODE);
