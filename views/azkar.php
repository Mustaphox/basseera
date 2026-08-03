<?php $page_title = 'الأذكار'; ?>

<section class="py-5 bg-light-primary border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary mb-3">الأذكار</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            ألا بذكر الله تطمئن القلوب
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        
        <!-- Categories Grid -->
        <div class="row g-4 mb-5">
            <?php 
            $azkar_cats = [
                ['name' => 'أذكار الصباح', 'icon' => 'sunrise', 'color' => '#FF8A00'],
                ['name' => 'أذكار المساء', 'icon' => 'sunset', 'color' => '#8B5CF6'],
                ['name' => 'أذكار النوم', 'icon' => 'moon', 'color' => '#3B82F6'],
                ['name' => 'أذكار الصلاة', 'icon' => 'activity', 'color' => '#10B981'],
                ['name' => 'أذكار السفر', 'icon' => 'plane', 'color' => '#F59E0B'],
                ['name' => 'أذكار المطر', 'icon' => 'cloud-rain', 'color' => '#06B6D4'],
                ['name' => 'أذكار المسجد', 'icon' => 'home', 'color' => '#6366F1'],
                ['name' => 'أذكار الطعام', 'icon' => 'coffee', 'color' => '#EF4444']
            ];
            foreach($azkar_cats as $index => $cat):
            ?>
            <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= $index * 50 ?>">
                <div class="card h-100 border-0 shadow-sm rounded-4 cursor-pointer hover-lift" onclick="loadAzkar('<?= $cat['name'] ?>')" style="cursor: pointer;">
                    <div class="card-body d-flex align-items-center gap-3 p-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px; background-color: <?= $cat['color'] ?>;">
                            <i data-lucide="<?= $cat['icon'] ?>"></i>
                        </div>
                        <h4 class="h5 mb-0 fw-bold"><?= $cat['name'] ?></h4>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Zikr Content Area -->
        <div id="zikrContentArea" style="display: none;">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h3 class="fw-bold mb-0 text-primary" id="currentZikrCat">أذكار الصباح</h3>
                <button class="btn btn-outline-secondary rounded-pill px-4" onclick="document.getElementById('zikrContentArea').style.display='none';">
                    العودة للتصنيفات <i data-lucide="chevron-left" class="ms-1"></i>
                </button>
            </div>
            
            <div class="row justify-content-center" id="zikrList">
                <!-- Mock Zikr Item -->
                <div class="col-lg-10 mb-4 zikr-item-container">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 zikr-card position-relative overflow-hidden">
                        <div class="progress position-absolute top-0 start-0 w-100 bg-light" style="height: 4px;">
                            <div class="progress-bar bg-primary zikr-progress" role="progressbar" style="width: 0%"></div>
                        </div>
                        
                        <p class="fs-4 fw-bold lh-lg text-dark text-center mb-4" style="font-family: 'Amiri', 'Cairo', serif;">
                            "اللَّهُمَّ بِكَ أَصْبَحْنَا، وَبِكَ أَمْسَيْنَا، وَبِكَ نَحْيَا، وَبِكَ نَمُوتُ، وَإِلَيْكَ النُّشُورُ"
                        </p>
                        
                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-4 border-top">
                            <div class="text-muted small">
                                المرجع: الترمذي
                            </div>
                            
                            <div class="d-flex align-items-center gap-3 mt-3 mt-md-0">
                                <button class="icon-btn bg-light text-primary" title="مشاركة">
                                    <i data-lucide="share-2"></i>
                                </button>
                                
                                <button class="btn btn-primary rounded-pill d-flex align-items-center gap-3 px-4 zikr-counter-btn" data-target="1" data-current="0">
                                    <span class="fs-5 fw-bold counter-text">0 / 1</span>
                                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;">
                                        <i data-lucide="plus" style="width:16px;height:16px;"></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-10 mb-4 zikr-item-container">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 zikr-card position-relative overflow-hidden">
                        <div class="progress position-absolute top-0 start-0 w-100 bg-light" style="height: 4px;">
                            <div class="progress-bar bg-primary zikr-progress" role="progressbar" style="width: 0%"></div>
                        </div>
                        
                        <p class="fs-4 fw-bold lh-lg text-dark text-center mb-4" style="font-family: 'Amiri', 'Cairo', serif;">
                            "سُبْحَانَ اللهِ وَبِحَمْدِهِ"
                        </p>
                        
                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-4 border-top">
                            <div class="text-muted small">
                                فضله: حطت خطاياه وإن كانت مثل زبد البحر
                            </div>
                            
                            <div class="d-flex align-items-center gap-3 mt-3 mt-md-0">
                                <button class="icon-btn bg-light text-primary" title="مشاركة">
                                    <i data-lucide="share-2"></i>
                                </button>
                                
                                <button class="btn btn-primary rounded-pill d-flex align-items-center gap-3 px-4 zikr-counter-btn" data-target="100" data-current="0">
                                    <span class="fs-5 fw-bold counter-text">0 / 100</span>
                                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;">
                                        <i data-lucide="plus" style="width:16px;height:16px;"></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<style>
.hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}
.zikr-card.completed {
    opacity: 0.6;
    background-color: #f8f9fa;
}
</style>

<script>
function loadAzkar(categoryName) {
    document.getElementById('currentZikrCat').textContent = categoryName;
    document.getElementById('zikrContentArea').style.display = 'block';
    
    // Reset all counters
    document.querySelectorAll('.zikr-item-container').forEach(container => {
        const btn = container.querySelector('.zikr-counter-btn');
        const progress = container.querySelector('.zikr-progress');
        const text = container.querySelector('.counter-text');
        const card = container.querySelector('.zikr-card');
        
        btn.dataset.current = 0;
        btn.disabled = false;
        progress.style.width = '0%';
        text.textContent = `0 / \${btn.dataset.target}`;
        card.classList.remove('completed');
    });

    // Scroll to content
    document.getElementById('zikrContentArea').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.zikr-counter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let current = parseInt(this.dataset.current);
            const target = parseInt(this.dataset.target);
            
            if (current < target) {
                current++;
                this.dataset.current = current;
                
                const container = this.closest('.zikr-card');
                const progress = container.querySelector('.zikr-progress');
                const text = container.querySelector('.counter-text');
                
                // Update UI
                text.textContent = `\${current} / \${target}`;
                progress.style.width = `\${(current / target) * 100}%`;
                
                // Vibrate if supported
                if (navigator.vibrate) navigator.vibrate(50);
                
                if (current === target) {
                    this.disabled = true;
                    container.classList.add('completed');
                    if (navigator.vibrate) navigator.vibrate([100, 50, 100]); // Success vibration
                }
            }
        });
    });
});
</script>
