<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Define base URL for assets
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$base_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . "/basseera/";
define('BASE_URL', $base_url);

// Get URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url_parts = explode('/', $url);

$page = $url_parts[0];

// ─── Routing ──────────────────────────────────────────────────────────────────

// Admin routing — handled separately (no header/footer wrappers)
if ($page === 'admin') {
    require_once 'admin/index.php';
    exit;
}

// Quran sub-routing (quran/surah)
if ($page === 'quran') {
    require_once 'includes/QuranApiService.php';
    require_once 'includes/header.php';
    if (isset($url_parts[1]) && $url_parts[1] === 'surah') {
        require_once 'views/quran/surah.php';
    } else {
        require_once 'views/quran/index.php';
    }
    require_once 'includes/footer.php';
    exit;
}

// Standard pages
$allowed_pages = [
    'home', 'seerah', 'hadith', 'azkar', 'duaa',
    'prayer-times', 'qibla', 'hijri', 'prophets',
    'sahaba', 'asma-allah', 'search', 'contact'
];

if (in_array($page, $allowed_pages)) {
    $view = "views/{$page}.php";
    require_once 'includes/header.php';
    if (file_exists($view)) {
        require_once $view;
    } else {
        require_once 'views/404.php';
    }
    require_once 'includes/footer.php';
} else {
    require_once 'includes/header.php';
    require_once 'views/404.php';
    require_once 'includes/footer.php';
}
