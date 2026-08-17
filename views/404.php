<?php $page_title = 'الصفحة غير موجودة'; ?>

<section class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="container text-center">
        
        <div data-aos="zoom-in">
            <!-- 404 Illustration -->
            <svg class="mb-4 text-primary" width="200" height="200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="filter: drop-shadow(0 0 20px rgba(255,138,0,0.4));">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M16 16s-1.5-2-4-2-4 2-4 2"></path>
                <line x1="9" y1="9" x2="9.01" y2="9"></line>
                <line x1="15" y1="9" x2="15.01" y2="9"></line>
            </svg>
            
            <h1 class="display-1 fw-bold mb-2" style="background: linear-gradient(135deg,#fff 0%,#FF8A00 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">404</h1>
            <h2 class="h3 mb-4 text-muted">عذراً، الصفحة التي تبحث عنها غير موجودة</h2>
            <p class="text-muted mb-5 mx-auto" style="max-width: 500px;">
                ربما تم نقل الصفحة أو حذفها، أو أنك قمت بكتابة الرابط بشكل خاطئ.
            </p>
            
            <a href="<?= BASE_URL ?>" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                <i data-lucide="home" class="me-2"></i> العودة للرئيسية
            </a>
        </div>
        
    </div>
</section>

