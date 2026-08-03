<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - بصيرة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .btn-primary { background-color: #FF8A00; border-color: #FF8A00; }
        .btn-primary:hover { background-color: #e67a00; border-color: #e67a00; }
        .text-primary { color: #FF8A00 !important; }
    </style>
</head>
<body>

<div class="card border-0 shadow-sm rounded-4 p-4 p-md-5" style="width: 100%; max-width: 450px;">
    <div class="text-center mb-4">
        <div class="mb-3"><img src="<?= BASE_URL ?>logo.png" alt="بصيرة" style="height: 60px; width: auto;"></div>
        <h2 class="fw-bold">تسجيل الدخول</h2>
        <p class="text-muted">لوحة تحكم منصة بصيرة</p>
    </div>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-danger rounded-3"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>admin/login">
        <div class="mb-3">
            <label class="form-label text-muted">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control form-control-lg bg-light border-0" required>
        </div>
        <div class="mb-4">
            <label class="form-label text-muted">كلمة المرور</label>
            <input type="password" name="password" class="form-control form-control-lg bg-light border-0" required>
        </div>
        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold">دخول</button>
    </form>
    
    <div class="text-center mt-4 text-muted small">
        &copy; <?= date('Y') ?> بصيرة
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>
</body>
</html>
