<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">الرئيسية</h2>
    <div class="d-flex align-items-center gap-2">
        <span class="text-muted">مرحباً، <?= e($_SESSION['admin_name'] ?? 'المدير') ?></span>
        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
            <?= mb_substr($_SESSION['admin_name'] ?? 'م', 0, 1) ?>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
            <i data-lucide="file-text" class="text-primary mb-2 mx-auto" width="32" height="32"></i>
            <h3 class="fw-bold mb-1">0</h3>
            <span class="text-muted">المقالات</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
            <i data-lucide="message-circle" class="text-primary mb-2 mx-auto" width="32" height="32"></i>
            <h3 class="fw-bold mb-1">0</h3>
            <span class="text-muted">الأحاديث</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
            <i data-lucide="sun" class="text-primary mb-2 mx-auto" width="32" height="32"></i>
            <h3 class="fw-bold mb-1">0</h3>
            <span class="text-muted">الأذكار</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
            <i data-lucide="heart" class="text-primary mb-2 mx-auto" width="32" height="32"></i>
            <h3 class="fw-bold mb-1">0</h3>
            <span class="text-muted">الأدعية</span>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">
    <h5 class="fw-bold mb-4">أحدث النشاطات</h5>
    <div class="text-center text-muted py-5">
        لا توجد نشاطات حديثة.
    </div>
</div>
