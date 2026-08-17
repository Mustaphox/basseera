# 🚀 دليل نشر وتثبيت منصة بصيرة (Deployment Guide)

يوضح هذا الدليل كيفية نشر منصة **بصيرة (Basseera)** على بيئات الاستضافة المختلفة (الاستضافات المشتركة، cPanel، خوادم VPS/Nginx/Apache، واستضافة InfinityFree).

---

## 📋 المتطلبات الأساسية (Requirements)

- **PHP**: 7.4 أو 8.0 أو 8.1 أو 8.2+
- **MySQL**: 5.7+ أو **MariaDB**: 10.3+
- **امتدادات PHP المطلوبة (Extensions)**:
  - `pdo_mysql`
  - `curl`
  - `json`
  - `mbstring`
  - `openssl`
- **خادم الويب**: Apache (مع تفعيل `mod_rewrite` و `mod_deflate` و `mod_expires`) أو Nginx.

---

## 🌐 1. النشر على الاستضافات المشتركة / cPanel / InfinityFree

### الخطوة 1: رفع الملفات
قم برفع الملفات التالية إلى المجلد الرئيسي للموقع (`public_html` أو `htdocs`):
```text
📁 admin/
📁 api/
📁 assets/
📁 config/
📁 database/
📁 includes/
📁 views/
📄 .htaccess
📄 index.php
📄 setup_db.php
📄 logo.png
📄 robots.txt
📄 sitemap.xml
```

> **ملاحظة**: تجنب رفع مجلد `.git` وملفات `.gitignore` أو ملفات الاختبار المؤقتة.

### الخطوة 2: إنشاء قاعدة البيانات وضبط الاتصال
1. أنشئ قاعدة بيانات جديدة ومستخدم في لوحة تحكم الاستضافة.
2. افتح ملف `config/database.php` أو أنشئ ملف `config/database.local.php` وضع بيانات الاتصال:
```php
<?php
$db_host = 'YOUR_DB_HOST';     // مثال: localhost أو sql104.infinityfree.com
$db_user = 'YOUR_DB_USERNAME'; // اسم مستخدم قاعدة البيانات
$db_pass = 'YOUR_DB_PASSWORD'; // كلمة المرور
$db_name = 'YOUR_DB_NAME';     // اسم قاعدة البيانات
```

### الخطوة 3: تثبيت الجداول والبيانات
لديك خياران:
- **الخيار الأول (الأسرع)**: افتح في متصفحك الرابط `https://your-domain.com/setup_db.php` ليتم إنشاء جميع الجداول والمستخدم الافتراضي تلقائياً.
- **الخيار الثاني**: ادخل إلى **phpMyAdmin**، اختر قاعدة البيانات، واضغط على **Import (استيراد)** ثم اختر ملف `database/schema.sql`.

---

## 🖥️ 2. النشر على خادم محلي (XAMPP / WampServer / Laragon)

1. استنسخ المشروع داخل مجلد `htdocs`:
   ```bash
   cd c:/xampp/htdocs
   git clone https://github.com/Mustaphox/basseera.git
   ```
2. تأكد من تشغيل خدمتي **Apache** و **MySQL** في لوحة تحكم XAMPP.
3. افتح في المتصفح:
   `http://localhost/basseera/setup_db.php`
4. توجه إلى الرئيسية:
   `http://localhost/basseera/`

---

## 🛡️ بيانات الدخول للوحة التحكم الافتراضية

- **الرابط**: `https://your-domain.com/admin`
- **البريد الإلكتروني**: `admin@basseera.com`
- **كلمة المرور الافتراضية**: `password`

> ⚠️ **أمان**: يرجى تغيير كلمة المرور مباشرة بعد تسجيل الدخول الأول، أو مسح ملف `setup_db.php` بعد اكتمال التثبيت.
