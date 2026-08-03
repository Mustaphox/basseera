<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/QuranApiService.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if (empty($q)) {
    echo json_encode(['success' => false, 'error' => 'لم يتم إدخال نص للبحث.']);
    exit;
}

$quranApi = new QuranApiService();

// Try to determine if user is searching by Arabic text (use Arabic-simple edition)
// or by English/surah name
$edition = 'quran-simple'; // default for Arabic

// Run search
$response = $quranApi->search($q, $edition);

// If Arabic search fails, try English
if (!$response['success'] || (isset($response['data']['matches']) && empty($response['data']['matches']))) {
    $response_en = $quranApi->search($q, 'en.asad');
    if ($response_en['success'] && !empty($response_en['data']['matches'])) {
        $response = $response_en;
    }
}

echo json_encode($response);
