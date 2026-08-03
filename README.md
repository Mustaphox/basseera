<div align="center">

<img src="logo.png" alt="بصيرة" width="120" />

# بصيرة — Baseera

**منصة إسلامية متكاملة** | A Complete Islamic Web Platform

[![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3_RTL-7952B3?style=flat-square&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)
[![Developer](https://img.shields.io/badge/Dev-mustoxdev-FF8A00?style=flat-square&logo=whatsapp)](https://wa.me/213665309431)

> منصة ويب إسلامية متكاملة تجمع القرآن الكريم، السيرة النبوية، الأحاديث، الأذكار، الأدعية، مواقيت الصلاة وأكثر — مبنية بـ PHP خالص دون أطر عمل ثقيلة.

[🌐 Demo](http://localhost/basseera) · [🐛 Report Bug](https://github.com/Mustaphox/basseera/issues) · [💡 Request Feature](https://github.com/Mustaphox/basseera/issues)

</div>

---

## 📸 لقطات الشاشة

> قريباً — سيتم إضافة لقطات للصفحات الرئيسية

---

## ✨ الميزات الحالية

### 📖 القرآن الكريم
- [x] عرض جميع 114 سورة مع بطاقات احترافية
- [x] بحث فوري وفلاتر (مكية / مدنية)
- [x] قراءة كاملة للسور بنص قرآني أصيل (`quran-uthmani`)
- [x] مشغل صوتي متقدم مع 5 قراء مشهورين
- [x] التحكم في السرعة، التكرار، التشغيل التلقائي للسورة التالية
- [x] عرض الجزء، الصفحة، الركوع، السجدة لكل آية
- [x] نسخ ومشاركة الآيات
- [x] حفظ العلامات المرجعية في `localStorage`
- [x] مواصلة القراءة من آخر مكان
- [x] إعدادات القراءة (حجم الخط، وضع ليلي)
- [x] البحث في نصوص الآيات

### 🕌 مواقيت الصلاة
- [x] تحديد الموقع تلقائياً عبر GPS
- [x] بحث يدوي عن المدينة عند رفض الإذن
- [x] عداد تنازلي حي للصلاة القادمة
- [x] 7 طرق حساب (أم القرى، الرابطة، مصر، كراتشي...)
- [x] جدول شهري كامل مع التاريخ الهجري والميلادي
- [x] تمييز يوم اليوم وبطاقة الصلاة القادمة

### 📿 الأذكار والأدعية
- [x] أذكار الصباح والمساء مع عداد تسبيح تفاعلي
- [x] 18+ دعاء مصنف (قرآنية، نبوية، الأنبياء، جوامع)
- [x] حفظ المفضلة في `localStorage`
- [x] نسخ ومشاركة الأدعية

### 📚 السيرة والمحتوى الإسلامي
- [x] مشغل فيديو يوتيوب تفاعلي مع قائمة تشغيل السيرة النبوية
- [x] جلب عناوين الحلقات الحقيقية عبر YouTube oEmbed API
- [x] قصص الأنبياء والصحابة الكرام
- [x] الأحاديث النبوية
- [x] أسماء الله الحسنى الـ99 مع شرح المعنى

### 🗓️ الأدوات الإسلامية
- [x] التقويم الهجري التفاعلي (Aladhan API)
- [x] بوصلة القبلة (Geolocation)
- [x] البحث الشامل في القرآن

### 🎨 التصميم والتقنية
- [x] تصميم RTL عربي بالكامل
- [x] وضع ليلي (Dark Mode)
- [x] تصميم متجاوب (Desktop / Tablet / Mobile)
- [x] انيميشن AOS + Lucide Icons
- [x] خط Cairo من Google Fonts

### 🛡️ لوحة التحكم (Admin Panel)
- [x] تسجيل دخول آمن بكلمة مرور مشفرة (`password_hash`)
- [x] لوحة إحصاءات
- [x] بنية CRUD جاهزة للمحتوى

---

## 🗺️ خارطة الطريق — الميزات القادمة

### الإصدار 1.3 — تحسين المحتوى
- [ ] **تفسير الآيات** — ربط التفسير الميسر / السعدي من Quran API
- [ ] **ترجمة الآيات** — عرض الترجمة الإنجليزية والفرنسية بجانب النص
- [ ] **تجويد الآيات** — تلوين النص بحسب أحكام التجويد
- [ ] **طباعة سورة** — نسخة قابلة للطباعة بدون هيدر/فوتر

### الإصدار 1.4 — المستخدمون والحسابات
- [ ] **نظام التسجيل/تسجيل الدخول** للمستخدمين
- [ ] **مزامنة العلامات المرجعية** على الخادم (ليست `localStorage` فقط)
- [ ] **التقدم في قراءة القرآن** — تتبع السور المقروءة
- [ ] **خطة ختم القرآن** — تحديد جدول زمني وتتبعه

### الإصدار 1.5 — التفاعل الاجتماعي
- [ ] **تعليقات على المقالات** مع نظام إشراف
- [ ] **مشاركة آية اليوم** كصورة (Canvas API)
- [ ] **ويدجت ساعة صلاة** قابل للتضمين في مواقع أخرى

### الإصدار 2.0 — التطبيق المتقدم
- [ ] **PWA (Progressive Web App)** — تثبيت كتطبيق على الجوال
- [ ] **إشعارات الصلاة** عبر Push Notifications
- [ ] **استماع offline** — حفظ السور للاستماع بدون إنترنت
- [ ] **Khitmah (ختمة جماعية)** — مشاركة ختمة مع أصدقاء
- [ ] **إحصاءات القارئ** — عدد الآيات المقروءة / المسموعة

### الإصدار 2.1 — لوحة التحكم المتقدمة
- [ ] **CRUD كامل** للمقالات، الأحاديث، الأذكار، الأدعية
- [ ] **إدارة الوسائط** — رفع صور للمقالات
- [ ] **تحليلات الزوار** — إحصاءات الزيارات
- [ ] **إعدادات السيو** — تخصيص العنوان والوصف
- [ ] **نسخ احتياطي** للقاعدة من لوحة التحكم

---

## 🏗️ بنية المشروع

```
basseera/
├── 📁 admin/                    # لوحة التحكم
│   ├── index.php                # مُوجِّه الإدارة
│   ├── 📁 includes/
│   │   └── admin_header.php     # تخطيط الإدارة
│   └── 📁 views/
│       ├── dashboard.php
│       └── login.php
│
├── 📁 api/                      # نقاط النهاية الداخلية
│   ├── quran_surahs.php
│   └── quran_search.php
│
├── 📁 assets/
│   ├── 📁 css/
│   │   └── style.css            # نظام التصميم الكامل
│   └── 📁 js/
│       ├── main.js              # AOS، Lucide، Dark Mode
│       └── quran.js             # مشغل الصوت، localStorage
│
├── 📁 config/
│   └── database.php             # اتصال PDO
│
├── 📁 database/
│   └── schema.sql               # مخطط قاعدة البيانات
│
├── 📁 docs/
│   └── CHANGELOG.md             # سجل التطوير التفصيلي
│
├── 📁 includes/
│   ├── header.php               # الهيدر العام + SEO
│   ├── footer.php               # الفوتر + حقوق
│   ├── functions.php            # دوال مساعدة
│   └── QuranApiService.php      # طبقة API القرآن
│
├── 📁 views/                    # صفحات الموقع
│   ├── home.php
│   ├── quran/
│   │   ├── index.php
│   │   └── surah.php
│   ├── seerah.php
│   ├── hadith.php
│   ├── azkar.php
│   ├── duaa.php
│   ├── prayer-times.php
│   ├── qibla.php
│   ├── hijri.php
│   ├── prophets.php
│   ├── sahaba.php
│   ├── asma-allah.php
│   ├── search.php
│   ├── contact.php
│   └── 404.php
│
├── .htaccess                    # توجيه Clean URLs
├── index.php                    # المُوجِّه الرئيسي
├── logo.png                     # شعار الموقع
├── setup_db.php                 # إعداد قاعدة البيانات
└── README.md
```

---

## ⚡ التثبيت السريع

### المتطلبات
- PHP >= 8.0
- MySQL >= 5.7
- Apache مع `mod_rewrite` مفعّل (XAMPP / WAMP / Laragon)
- اتصال بالإنترنت (لجلب بيانات القرآن من API)

### خطوات التثبيت

```bash
# 1. استنساخ المستودع داخل مجلد htdocs
git clone https://github.com/Mustaphox/basseera.git
cd basseera

# 2. تأكد أن Apache و MySQL يعملان من XAMPP

# 3. افتح المتصفح واذهب إلى:
http://localhost/basseera/setup_db.php
# هذا الملف سيُنشئ قاعدة البيانات وجميع الجداول تلقائياً

# 4. احذف setup_db.php بعد الإعداد لأسباب أمنية
```

### بيانات الدخول للإدارة
| الحقل | القيمة |
|-------|--------|
| البريد | `admin@basseera.com` |
| كلمة المرور | `password` |

> ⚠️ **مهم:** غيّر كلمة المرور فور تثبيت الموقع من لوحة التحكم.

---

## 🔌 واجهات API المستخدمة

| الخدمة | الغرض | الرابط |
|--------|--------|--------|
| AlQuran Cloud | نصوص وصوتيات القرآن | [api.alquran.cloud](https://alquran.cloud/api) |
| Aladhan | مواقيت الصلاة، التقويم الهجري | [api.aladhan.com](https://aladhan.com/prayer-times-api) |
| BigDataCloud | الجيوكودينج العكسي (اسم المدينة) | [bigdatacloud.net](https://www.bigdatacloud.com) |
| YouTube oEmbed | عناوين فيديوهات السيرة | [youtube.com/oembed](https://developers.google.com/youtube/v3) |

---

## 🛠️ التقنيات المستخدمة

| التقنية | الغرض |
|---------|--------|
| **PHP 8** | المعالجة الخلفية والتوجيه |
| **MySQL** | قاعدة البيانات (المستخدمون، الإعدادات، المحتوى) |
| **Bootstrap 5 RTL** | الإطار التصميمي |
| **Vanilla JavaScript** | التفاعل والـ API calls |
| **AOS.js** | انيميشن عند التمرير |
| **Lucide Icons** | أيقونات عصرية |
| **Cairo (Google Fonts)** | الخط العربي الرئيسي |
| **Amiri (Google Fonts)** | خط النص القرآني |

---

## 🔐 الأمان

- كلمات المرور مشفرة بـ `password_hash()` / `password_verify()`
- جميع المدخلات تمر عبر `htmlspecialchars()` و `filter_var()`
- حماية من SQL Injection عبر PDO Prepared Statements
- حماية الـ Admin Panel بجلسات `$_SESSION`

---

## 🤝 المساهمة

المساهمات مرحب بها! لإضافة ميزة أو إصلاح خطأ:

1. Fork المستودع
2. أنشئ فرع جديد: `git checkout -b feature/اسم-الميزة`
3. Commit تغييراتك: `git commit -m 'feat: أضف ميزة كذا'`
4. Push: `git push origin feature/اسم-الميزة`
5. افتح Pull Request

---

## 📄 الرخصة

هذا المشروع مرخص بموجب رخصة [MIT](LICENSE).

---

<div align="center">

صُنع بـ ❤️ لخدمة المحتوى الإسلامي الرقمي

**تطوير:** [mustoxdev](https://wa.me/213665309431) · **المستودع:** [Mustaphox/basseera](https://github.com/Mustaphox/basseera)

</div>
