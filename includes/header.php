<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $site_name   = e(get_setting($pdo, 'site_name', 'بصيرة'));
    $site_desc   = e(get_setting($pdo, 'site_description', 'منصة إسلامية متكاملة تضم القرآن الكريم، الأحاديث، السيرة النبوية، الأذكار، الأدعية، ومحتوى إسلاميًا موثوقًا.'));
    $full_title  = isset($page_title) ? e($page_title) . ' | ' . $site_name : $site_name;
    ?>
    <title><?= $full_title ?></title>
    <meta name="description" content="<?= $site_desc ?>">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#FF8A00">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= $full_title ?>">
    <meta property="og:description" content="<?= $site_desc ?>">
    <meta property="og:image" content="<?= BASE_URL ?>logo.png">
    <meta property="og:locale" content="ar_SA">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>logo.png">
    <link rel="apple-touch-icon" href="<?= BASE_URL ?>logo.png">

    <!-- Google Fonts: Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">

    <!-- AOS Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?= BASE_URL ?>">
            <img src="<?= BASE_URL ?>logo.png" alt="بصيرة" style="height: 40px; width: auto;">
            بصيرة
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= active_class('home') ?>" href="<?= BASE_URL ?>">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= active_class('quran') ?>" href="<?= BASE_URL ?>quran">القرآن الكريم</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= active_class('seerah') ?>" href="<?= BASE_URL ?>seerah">السيرة النبوية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= active_class('hadith') ?>" href="<?= BASE_URL ?>hadith">الأحاديث</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= active_class('azkar') ?>" href="<?= BASE_URL ?>azkar">الأذكار</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= active_class('duaa') ?>" href="<?= BASE_URL ?>duaa">الأدعية</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        المزيد
                    </a>
                    <ul class="dropdown-menu border-0 shadow-sm">
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>prophets">قصص الأنبياء</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>sahaba">الصحابة</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>asma-allah">أسماء الله الحسنى</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>hijri">التقويم الهجري</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>prayer-times">مواقيت الصلاة</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>qibla">اتجاه القبلة</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>articles">المقالات</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>contact">تواصل معنا</a></li>
                    </ul>
                </li>
            </ul>
            
            <div class="d-flex align-items-center gap-2">
                <button class="icon-btn" aria-label="Search" onclick="window.location.href='<?= BASE_URL ?>search'">
                    <i data-lucide="search"></i>
                </button>
                <button class="icon-btn" id="theme-toggle" aria-label="Toggle Dark Mode">
                    <i data-lucide="moon"></i>
                </button>
            </div>
        </div>
    </div>
</nav>
<main class="min-vh-100">
