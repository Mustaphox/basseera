<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - بصيرة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #fff; border-left: 1px solid #eee; }
        .sidebar-link { display: flex; align-items: center; gap: 10px; padding: 12px 20px; color: #555; text-decoration: none; border-radius: 8px; margin-bottom: 5px; transition: 0.2s; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(255,138,0,0.1); color: #FF8A00; font-weight: 600; }
        .text-primary { color: #FF8A00 !important; }
        .bg-primary { background-color: #FF8A00 !important; }
        .btn-primary { background-color: #FF8A00; border-color: #FF8A00; }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar p-3" style="width: 280px;">
        <a href="<?= BASE_URL ?>admin/dashboard" class="d-flex align-items-center mb-4 text-decoration-none text-primary fs-3 fw-bold ps-3">
            <img src="<?= BASE_URL ?>logo.png" alt="بصيرة" style="height: 40px; width: auto;" class="me-2"> بصيرة
        </a>
        <div class="nav flex-column">
            <a href="<?= BASE_URL ?>admin/dashboard" class="sidebar-link <?= $admin_route=='dashboard'?'active':'' ?>"><i data-lucide="layout-dashboard"></i> الرئيسية</a>
            <a href="<?= BASE_URL ?>admin/articles" class="sidebar-link <?= $admin_route=='articles'?'active':'' ?>"><i data-lucide="file-text"></i> المقالات والقصص</a>
            <a href="<?= BASE_URL ?>admin/hadith" class="sidebar-link <?= $admin_route=='hadith'?'active':'' ?>"><i data-lucide="message-circle"></i> الأحاديث</a>
            <a href="<?= BASE_URL ?>admin/azkar" class="sidebar-link <?= $admin_route=='azkar'?'active':'' ?>"><i data-lucide="sun"></i> الأذكار والأدعية</a>
            <a href="<?= BASE_URL ?>admin/settings" class="sidebar-link <?= $admin_route=='settings'?'active':'' ?>"><i data-lucide="settings"></i> الإعدادات</a>
            <a href="<?= BASE_URL ?>admin/logout" class="sidebar-link text-danger mt-4"><i data-lucide="log-out"></i> تسجيل الخروج</a>
        </div>
    </div>
    <!-- Main Content -->
    <div class="flex-grow-1 p-4">
