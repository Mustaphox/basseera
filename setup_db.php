<?php
/**
 * سكريبت لتثبيت جداول قاعدة البيانات تلقائياً على الاستضافة
 * يرجى تشغيل هذا الملف مرة واحدة عبر المتصفح: your-domain.com/setup_db.php
 */

$db_host = 'sql104.infinityfree.com';
$db_user = 'if0_42341492';
$db_pass = 'HRnkoA62e1';
$db_name = 'if0_42341492_bassira';

try {
    // الاتصال بقاعدة البيانات على الاستضافة
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    echo "<div style='font-family:Tahoma,sans-serif; direction:rtl; max-width:600px; margin:50px auto; padding:20px; border-radius:12px; background:#f0fdf4; border:1px solid #86efac; text-align:center;'>";
    echo "<h3 style='color:#166534;'>✅ تم الاتصال بقاعدة البيانات بنجاح</h3>";

    // قراءة ملف الـ SQL
    $sql_file = __DIR__ . '/database/schema.sql';
    if (!file_exists($sql_file)) {
        die("<h3 style='color:red;'>خطأ: ملف database/schema.sql غير موجود!</h3></div>");
    }

    $sql = file_get_contents($sql_file);
    
    // تنفيذ الأوامر وإنشاء الجداول
    $pdo->exec($sql);

    echo "<h2 style='color:#15803d;'>🎉 تم تثبيت جميع الجداول والبيانات بنجاح!</h2>";
    echo "<p style='color:#374151;'>يمكنك الآن استخدام الموقع ولوحة التحكم.</p>";
    echo "<p style='color:#6b7280; font-size:14px;'>بيانات الدخول للوحة التحكم الافتراضية:<br>البريد: <b>admin@basseera.com</b> | كلمة المرور: <b>password</b></p>";
    echo "<a href='index.php' style='display:inline-block; margin-top:15px; padding:12px 30px; background:#FF8A00; color:white; font-weight:bold; text-decoration:none; border-radius:30px;'>الانتقال إلى الرئيسية</a>";
    echo "</div>";
    
} catch(PDOException $e) {
    echo "<div style='font-family:Tahoma,sans-serif; direction:rtl; max-width:600px; margin:50px auto; padding:20px; border-radius:12px; background:#fef2f2; border:1px solid #fca5a5; text-align:center;'>";
    echo "<h3 style='color:#991b1b;'>❌ حدث خطأ في الاتصال بقاعدة البيانات:</h3>";
    echo "<p style='direction:ltr; color:#b91c1c; font-family:monospace;'>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
} catch(Exception $e) {
    echo "<div style='font-family:Tahoma,sans-serif; direction:rtl; max-width:600px; margin:50px auto; padding:20px; border-radius:12px; background:#fef2f2; border:1px solid #fca5a5; text-align:center;'>";
    echo "<h3 style='color:#991b1b;'>❌ حدث خطأ:</h3>";
    echo "<p style='color:#b91c1c;'>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
}
?>
