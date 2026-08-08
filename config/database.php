<?php
/**
 * Database connection settings.
 *
 * Production credentials belong in database.local.php, which is intentionally
 * ignored by Git. Environment variables take precedence when available.
 */
$local_config = __DIR__ . '/database.local.php';
if (is_file($local_config)) {
    require $local_config;
}

$db_host = getenv('DB_HOST') ?: ($db_host ?? 'localhost');
$db_user = getenv('DB_USER') ?: ($db_user ?? 'root');
$db_pass = getenv('DB_PASS') ?: ($db_pass ?? '');
$db_name = getenv('DB_NAME') ?: ($db_name ?? 'basseera');

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set default fetch mode to object
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch(PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    http_response_code(500);
    exit('تعذر الاتصال بقاعدة البيانات. يرجى المحاولة لاحقاً.');
}

// Helper function to get settings
function get_setting($pdo, $key, $default = '') {
    $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    $result = $stmt->fetch();
    if (!$result || $result->setting_value === null) {
        return $default;
    }

    $value = trim($result->setting_value);

    // Some previous imports stored Arabic text as question marks. Do not let
    // those corrupted values override the valid Arabic fallback in the UI.
    if (in_array($key, ['site_name', 'site_description'], true)) {
        $content = preg_replace('/[?\s\p{P}]+/u', '', $value);
        if ($content === '') {
            return $default;
        }
    }

    return $value;
}
?>
