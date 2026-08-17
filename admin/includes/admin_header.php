<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - بصيرة</title>
    <meta name="theme-color" content="#1a0a2e">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #0d1117 0%, #1a0a2e 50%, #16213e 100%);
            background-attachment: fixed;
            min-height: 100vh;
            color: rgba(255,255,255,0.90);
            overflow-x: hidden;
            position: relative;
        }

        /* Orbs */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            animation: orbFloat 12s ease-in-out infinite alternate;
            z-index: 0;
        }
        body::before {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(255,138,0,0.15) 0%, transparent 70%);
            top: -120px; right: -100px;
        }
        body::after {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(120,50,200,0.12) 0%, transparent 70%);
            bottom: -100px; left: -80px;
            animation-delay: -6s;
        }

        @keyframes orbFloat {
            0%   { transform: translate(0, 0) scale(1); }
            100% { transform: translate(25px, -25px) scale(1.08); }
        }

        /* Layout */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-left: 1px solid rgba(255,255,255,0.10);
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.5rem 0.75rem 1.5rem;
            color: #FF8A00;
            font-size: 1.4rem;
            font-weight: 900;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 1rem;
        }

        .sidebar-brand span { color: rgba(255,255,255,0.9); }

        .sidebar-section {
            font-size: 0.72rem;
            font-weight: 700;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 0.5rem 0.75rem;
            margin-top: 0.75rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.7rem 0.85rem;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 4px;
            transition: all 0.25s ease;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .sidebar-link svg { width: 18px; height: 18px; flex-shrink: 0; }

        .sidebar-link:hover {
            background: rgba(255,138,0,0.12);
            color: #FF8A00;
            border: 1px solid rgba(255,138,0,0.2);
            padding-right: 1.1rem;
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, rgba(255,138,0,0.25), rgba(255,80,30,0.15));
            color: #FF8A00;
            border: 1px solid rgba(255,138,0,0.3);
            box-shadow: 0 4px 15px rgba(255,138,0,0.15);
        }

        .sidebar-link.text-danger { color: rgba(239,68,68,0.75) !important; }
        .sidebar-link.text-danger:hover { background: rgba(239,68,68,0.12); color: #ef4444 !important; border-color: rgba(239,68,68,0.2); }

        .sidebar-spacer { flex: 1; }

        /* Main Content */
        .admin-main {
            flex: 1;
            padding: 2rem;
            overflow-x: hidden;
        }

        /* Cards */
        .card {
            background: rgba(255,255,255,0.07) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.12) !important;
            border-radius: 18px;
            color: rgba(255,255,255,0.90);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.4), 0 0 25px rgba(255,138,0,0.12);
            border-color: rgba(255,138,0,0.25) !important;
        }

        h2, h3, h4, h5, h6 { color: rgba(255,255,255,0.95); }
        .text-muted { color: rgba(255,255,255,0.5) !important; }
        .text-primary { color: #FF8A00 !important; }
        .text-dark { color: rgba(255,255,255,0.9) !important; }

        .bg-primary { background: linear-gradient(135deg, #FF8A00, #FF5F1F) !important; }

        .btn-primary {
            background: linear-gradient(135deg, #FF8A00, #FF5F1F);
            border: none;
            border-radius: 10px;
            font-weight: 700;
            color: #fff;
            box-shadow: 0 4px 15px rgba(255,138,0,0.3);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255,138,0,0.45);
            color: #fff;
        }

        .form-control, .form-select {
            background: rgba(255,255,255,0.08) !important;
            border: 1px solid rgba(255,255,255,0.15) !important;
            color: rgba(255,255,255,0.9) !important;
            border-radius: 10px;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255,255,255,0.12) !important;
            border-color: rgba(255,138,0,0.5) !important;
            box-shadow: 0 0 0 3px rgba(255,138,0,0.15) !important;
            color: rgba(255,255,255,0.9) !important;
        }

        .form-control::placeholder { color: rgba(255,255,255,0.3) !important; }

        .table > :not(caption) > * > * {
            background: transparent;
            border-color: rgba(255,255,255,0.07);
            color: rgba(255,255,255,0.85);
        }

        .table-hover > tbody > tr:hover > * {
            background: rgba(255,138,0,0.07);
        }

        .badge.bg-primary { background: linear-gradient(135deg,#FF8A00,#FF5F1F) !important; }

        ::selection { background: rgba(255,138,0,0.3); color: #fff; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); }
        ::-webkit-scrollbar-thumb { background: rgba(255,138,0,0.4); border-radius: 3px; }

        /* ── Light (Day) Mode ───────────────────────────────────── */
        [data-theme="light"] body {
            background: linear-gradient(135deg, #f8f3ff 0%, #fff7ed 50%, #f0f7ff 100%);
            color: #1a1a2e;
        }
        [data-theme="light"] body::before {
            background: radial-gradient(circle, rgba(255,138,0,0.10) 0%, transparent 70%);
        }
        [data-theme="light"] body::after {
            background: radial-gradient(circle, rgba(139,92,246,0.07) 0%, transparent 70%);
        }
        [data-theme="light"] .sidebar {
            background: rgba(255,255,255,0.75);
            border-left-color: rgba(0,0,0,0.08);
        }
        [data-theme="light"] .sidebar-brand { color: var(--bs-primary, #FF8A00); }
        [data-theme="light"] .sidebar-brand span { color: #1a1a2e; }
        [data-theme="light"] .sidebar-section { color: rgba(0,0,0,0.35); }
        [data-theme="light"] .sidebar-link { color: #4a4a6a; }
        [data-theme="light"] .sidebar-link:hover {
            background: rgba(255,138,0,0.08);
            color: #FF8A00;
            border-color: rgba(255,138,0,0.15);
        }
        [data-theme="light"] .sidebar-link.active {
            background: linear-gradient(135deg, rgba(255,138,0,0.15), rgba(255,80,30,0.08));
            color: #FF8A00;
            border-color: rgba(255,138,0,0.20);
        }
        [data-theme="light"] .card {
            background: rgba(255,255,255,0.75) !important;
            border: 1px solid rgba(0,0,0,0.08) !important;
            color: #1a1a2e;
        }
        [data-theme="light"] h2,[data-theme="light"] h3,[data-theme="light"] h4,
        [data-theme="light"] h5,[data-theme="light"] h6 { color: #1a1a2e; }
        [data-theme="light"] .text-muted { color: #6c6c8a !important; }
        [data-theme="light"] .form-control, [data-theme="light"] .form-select {
            background: rgba(255,255,255,0.85) !important;
            border: 1px solid rgba(0,0,0,0.12) !important;
            color: #1a1a2e !important;
        }
        [data-theme="light"] .form-control::placeholder { color: rgba(0,0,0,0.30) !important; }
        [data-theme="light"] .table > :not(caption) > * > * {
            border-color: rgba(0,0,0,0.06);
            color: #1a1a2e;
        }
    </style>
    <script>
        /* Apply saved theme ASAP to avoid flash of wrong theme */
        (function() {
            var t = localStorage.getItem('theme');
            if (!t) {
                t = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
</head>
<body>
<div class="admin-wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="<?= BASE_URL ?>admin/dashboard" class="sidebar-brand">
            <img src="<?= BASE_URL ?>logo.png" alt="بصيرة" style="height: 36px; width: auto; border-radius: 8px;">
            <span>بصيرة</span>
        </a>

        <div class="nav flex-column">
            <div class="sidebar-section">القائمة الرئيسية</div>
            <a href="<?= BASE_URL ?>admin/dashboard" class="sidebar-link <?= $admin_route=='dashboard'?'active':'' ?>">
                <i data-lucide="layout-dashboard"></i> الرئيسية
            </a>
            <a href="<?= BASE_URL ?>admin/articles" class="sidebar-link <?= $admin_route=='articles'?'active':'' ?>">
                <i data-lucide="file-text"></i> المقالات والقصص
            </a>
            <a href="<?= BASE_URL ?>admin/hadith" class="sidebar-link <?= $admin_route=='hadith'?'active':'' ?>">
                <i data-lucide="message-circle"></i> الأحاديث
            </a>
            <a href="<?= BASE_URL ?>admin/azkar" class="sidebar-link <?= $admin_route=='azkar'?'active':'' ?>">
                <i data-lucide="sun"></i> الأذكار والأدعية
            </a>

            <div class="sidebar-section">النظام</div>
            <a href="<?= BASE_URL ?>admin/settings" class="sidebar-link <?= $admin_route=='settings'?'active':'' ?>">
                <i data-lucide="settings"></i> الإعدادات
            </a>
            <a href="<?= BASE_URL ?>" class="sidebar-link" target="_blank">
                <i data-lucide="external-link"></i> عرض الموقع
            </a>

            <div class="sidebar-spacer"></div>

            <a href="<?= BASE_URL ?>admin/logout" class="sidebar-link text-danger mt-3">
                <i data-lucide="log-out"></i> تسجيل الخروج
            </a>
        </div>
    </div>
    <!-- Main Content -->
    <div class="admin-main">
