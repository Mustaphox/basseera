<?php
/**
 * سكريبت لإنشاء قاعدة البيانات والجداول تلقائياً
 * يرجى تشغيل هذا الملف مرة واحدة فقط
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'basseera';

try {
    // 1. الاتصال بدون تحديد قاعدة البيانات لإنشائها
    $pdo = new PDO("mysql:host=$db_host;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h3>جاري الاتصال بخادم MySQL... نجاح</h3>";

    // 2. إنشاء قاعدة البيانات
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<h3>تم إنشاء قاعدة البيانات '$db_name' بنجاح (أو هي موجودة مسبقاً)</h3>";

    // 3. اختيار قاعدة البيانات
    $pdo->exec("USE `$db_name`");

    // 4. قراءة ملف الـ SQL
    $sql_file = __DIR__ . '/database/schema.sql';
    if (!file_exists($sql_file)) {
        die("<h3 style='color:red;'>خطأ: ملف database/schema.sql غير موجود!</h3>");
    }

    $sql = file_get_contents($sql_file);
    
    // 5. تنفيذ الأوامر
    // تفعيل تعدد الاستعلامات (Multi-statements are supported by default in PDO MySQL)
    $pdo->exec($sql);

    echo "<h2 style='color:green;'>تم إنشاء جميع الجداول والبيانات الأساسية بنجاح! 🎉</h2>";
    echo "<a href='index.php' style='display:inline-block; padding:10px 20px; background:#FF8A00; color:white; text-decoration:none; border-radius:5px;'>الذهاب إلى الرئيسية</a>";
    
} catch(PDOException $e) {
    echo "<h3 style='color:red;'>حدث خطأ في قاعدة البيانات: " . $e->getMessage() . "</h3>";
} catch(Exception $e) {
    echo "<h3 style='color:red;'>حدث خطأ: " . $e->getMessage() . "</h3>";
}
?>
