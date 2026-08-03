<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/QuranApiService.php';

$quranApi = new QuranApiService();
$response = $quranApi->getSurahs();

echo json_encode($response);
