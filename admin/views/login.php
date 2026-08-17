<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - بصيرة</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated orbs */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            animation: orbFloat 10s ease-in-out infinite alternate;
        }

        body::before {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(255,138,0,0.20) 0%, transparent 70%);
            top: -150px; right: -100px;
        }

        body::after {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(120,50,200,0.18) 0%, transparent 70%);
            bottom: -100px; left: -100px;
            animation-delay: -5s;
        }

        @keyframes orbFloat {
            0%   { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, -30px) scale(1.1); }
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 460px;
            padding: 1rem;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            box-shadow: 0 8px 40px rgba(0,0,0,0.4), 0 0 60px rgba(255,138,0,0.08);
        }

        .logo-ring {
            width: 80px; height: 80px;
            border-radius: 50%;
            border: 2px solid rgba(255,138,0,0.4);
            background: rgba(255,138,0,0.10);
            backdrop-filter: blur(10px);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 30px rgba(255,138,0,0.25);
        }

        h2 { color: #fff; font-weight: 700; }
        .text-muted-glass { color: rgba(255,255,255,0.55) !important; }

        .form-control {
            background: rgba(255,255,255,0.08) !important;
            border: 1px solid rgba(255,255,255,0.15) !important;
            border-radius: 12px;
            color: #fff !important;
            padding: 0.8rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.12) !important;
            border-color: rgba(255,138,0,0.5) !important;
            box-shadow: 0 0 0 3px rgba(255,138,0,0.15), 0 0 20px rgba(255,138,0,0.1) !important;
            color: #fff !important;
            outline: none;
        }

        .form-control::placeholder { color: rgba(255,255,255,0.35) !important; }

        .form-label { color: rgba(255,255,255,0.65); font-weight: 600; }

        .btn-primary {
            background: linear-gradient(135deg, #FF8A00, #FF5F1F);
            border: none;
            border-radius: 12px;
            padding: 0.8rem 1.5rem;
            font-size: 1.05rem;
            font-weight: 700;
            color: #fff;
            box-shadow: 0 4px 20px rgba(255,138,0,0.35);
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #FFa030, #FF7030);
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(255,138,0,0.5);
        }

        .alert-danger {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5;
            border-radius: 12px;
        }

        .divider {
            height: 1px;
            background: rgba(255,255,255,0.10);
            margin: 1.5rem 0;
        }

        .footer-text {
            color: rgba(255,255,255,0.35);
            font-size: 0.85rem;
        }

        ::selection { background: rgba(255,138,0,0.3); color: #fff; }

        /* Light Mode */
        [data-theme="light"] body {
            background: linear-gradient(135deg, #f8f3ff 0%, #fff7ed 50%, #f0f7ff 100%);
        }
        [data-theme="light"] body::before {
            background: radial-gradient(circle, rgba(255,138,0,0.12) 0%, transparent 70%);
        }
        [data-theme="light"] body::after {
            background: radial-gradient(circle, rgba(139,92,246,0.08) 0%, transparent 70%);
        }
        [data-theme="light"] .glass-card {
            background: rgba(255,255,255,0.75);
            border-color: rgba(0,0,0,0.10);
            box-shadow: 0 8px 40px rgba(0,0,0,0.10), 0 0 60px rgba(255,138,0,0.05);
        }
        [data-theme="light"] h2 { color: #1a1a2e; }
        [data-theme="light"] .text-muted-glass { color: #4a4a6a !important; }
        [data-theme="light"] .divider { background: rgba(0,0,0,0.08); }
        [data-theme="light"] .form-control {
            background: rgba(255,255,255,0.85) !important;
            border-color: rgba(0,0,0,0.12) !important;
            color: #1a1a2e !important;
        }
        [data-theme="light"] .form-control::placeholder { color: rgba(0,0,0,0.30) !important; }
        [data-theme="light"] .form-label { color: #4a4a6a; }
        [data-theme="light"] .footer-text { color: rgba(0,0,0,0.35); }
        [data-theme="light"] ::selection { color: #fff; }
    </style>
    <script>
        (function() {
            var t = localStorage.getItem('theme');
            if (!t) t = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
</head>
<body>

<div class="login-wrapper">
    <div class="glass-card">

        <div class="text-center mb-4">
            <div class="logo-ring mx-auto mb-3">
                <img src="<?= BASE_URL ?>logo.png" alt="بصيرة" style="height: 50px; width: auto; border-radius: 50%;">
            </div>
            <h2 class="fw-bold mb-1">تسجيل الدخول</h2>
            <p class="text-muted-glass mb-0">لوحة تحكم منصة بصيرة</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger rounded-3 mb-3"><?= $error ?></div>
        <?php endif; ?>

        <div class="divider"></div>

        <form method="POST" action="<?= BASE_URL ?>admin/login">
            <div class="mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
            </div>
            <div class="mb-4">
                <label class="form-label">كلمة المرور</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 rounded-pill">
                دخول إلى لوحة التحكم
            </button>
        </form>

        <div class="divider"></div>

        <div class="text-center footer-text">
            &copy; <?= date('Y') ?> بصيرة — جميع الحقوق محفوظة
        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>
</body>
</html>
