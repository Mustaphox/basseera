-- Run this once in phpMyAdmin if the site name or description appears as ???.
SET NAMES utf8mb4;

UPDATE settings
SET setting_value = 'بصيرة'
WHERE setting_key = 'site_name';

UPDATE settings
SET setting_value = 'منصة إسلامية متكاملة تضم القرآن الكريم، الأحاديث، السيرة النبوية، الأذكار، الأدعية، ومحتوى إسلاميًا موثوقًا.'
WHERE setting_key = 'site_description';
