<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Define a base URL that works both in a subdirectory locally and in htdocs.
$is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
$protocol = $is_https ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$script_directory = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
$base_path = rtrim($script_directory, '/');
$base_url = $protocol . '://' . $host . ($base_path === '' ? '/' : $base_path . '/');
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
