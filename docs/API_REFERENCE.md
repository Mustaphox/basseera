# 🔌 مراجع واجهات البرمجة (API Reference)

توفر منصة **بصيرة** واجهات برمجية مدمجة وسريعة للاستخدام المباشر أو عبر AJAX.

---

## 1. البحث الإسلامي الشامل (Universal Search API)

### `GET /api/quran_search.php`

نقطة نهاية للبحث الذكي في السور، الآيات القرآنية، الأحاديث النبوية، والأذكار والأدعية.

#### المعاملات (Parameters):
| المعامل | النوع | إجباري | الوصف |
| :--- | :--- | :--- | :--- |
| `q` | `string` | نعم | نص البحث أو اسم السورة أو رقمها (مثال: `الكهف` أو `الرحمن` أو `18`) |

#### نموذج الاستجابة (Example JSON Response):
```json
{
  "success": true,
  "query": "الكهف",
  "total_count": 1,
  "surahs": [
    {
      "number": 18,
      "name": "سُورَةُ الكَهۡفِ",
      "englishName": "Al-Kahf",
      "englishNameTranslation": "The Cave",
      "revelationType": "مكية",
      "numberOfAyahs": 110
    }
  ],
  "ayahs": [],
  "hadiths": [],
  "azkar": []
}
```

---

## 2. قائمة سور القرآن الكريم (Quran Surahs API)

### `GET /api/quran_surahs.php`

إرجاع مصفوفة تضم كافة السور الـ 114 مع أسمائها، أرقامها، نوع التنزيل، وعدد الآيات مع دعم الكاش المحلي.

#### نموذج الاستجابة (Example JSON Response):
```json
{
  "code": 200,
  "status": "OK",
  "data": [
    {
      "number": 1,
      "name": "سُورَةُ الفَاتِحَةِ",
      "englishName": "Al-Faatiha",
      "englishNameTranslation": "The Opening",
      "numberOfAyahs": 7,
      "revelationType": "Meccan"
    }
  ]
}
```

---

## 3. الواجهات الخارجية المعتمدة (External Integrated APIs)

| الخدمة | المزود | الاستخدام |
| :--- | :--- | :--- |
| **AlQuran Cloud API** | `api.alquran.cloud` | نصوص وتراجم وتفسير الآيات القرآنية |
| **MP3Quran CDN** | `server8.mp3quran.net` / `server*.mp3quran.net` | البث الصوتي المباشر لتلاوات السور كاملة لأكثر من 10 قراء |
| **AlAdhan Prayer API** | `api.aladhan.com` | حساب مواقيت الصلاة، التقويم الهجري، وأسماء الله الحسنى |
| **Hadith API** | `hadis-api-id.vercel.app` | أمهات كتب الحديث (البخاري، مسلم، الترمذي، النسائي...) |
| **Azkar JSON API** | NawafAlqari Repository | أذكار الصباح والمساء وأدعية حصن المسلم |
