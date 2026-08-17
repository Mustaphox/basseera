<?php
/**
 * Database connection settings.
 *
 * Configured for production hosting (InfinityFree).
 * Environment variables or database.local.php can override if needed.
 */
$local_config = __DIR__ . '/database.local.php';
if (is_file($local_config)) {
    require $local_config;
}

$db_host = getenv('DB_HOST') ?: ($db_host ?? 'sql104.infinityfree.com');
$db_user = getenv('DB_USER') ?: ($db_user ?? 'if0_42341492');
$db_pass = getenv('DB_PASS') ?: ($db_pass ?? 'HRnkoA62e1');
$db_name = getenv('DB_NAME') ?: ($db_name ?? 'if0_42341492_bassira');

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch(PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    http_response_code(500);
    exit('تعذر الاتصال بقاعدة البيانات. يرجى التأكد من استيراد الجداول وإعدادات الاتصال.');
}

// Optimized helper function with static query caching
function get_setting($pdo, $key, $default = '') {
    static $settings_cache = null;

    if ($settings_cache === null) {
        $settings_cache = [];
        try {
            $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
            while ($row = $stmt->fetch()) {
                $settings_cache[$row->setting_key] = $row->setting_value;
            }
        } catch(Exception $e) {
            // fallback to empty cache if table fails
        }
    }

    if (!array_key_exists($key, $settings_cache) || $settings_cache[$key] === null) {
        return $default;
    }

    $value = trim($settings_cache[$key]);

    if (in_array($key, ['site_name', 'site_description'], true)) {
        $content = preg_replace('/[?\s\p{P}]+/u', '', $value);
        if ($content === '') {
            return $default;
        }
    }

    return $value;
}
?>
