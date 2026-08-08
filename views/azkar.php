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
                <div class="text-center py-5" id="azkarLoader" style="display:none;">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-3 text-muted">جاري تحميل الأذكار...</p>
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
let azkarData = {};

function loadAzkar(categoryName) {
    document.getElementById('currentZikrCat').textContent = categoryName;
    document.getElementById('zikrContentArea').style.display = 'block';
    const list = document.getElementById('zikrList');
    list.innerHTML = '';
    
    if (Object.keys(azkarData).length === 0) {
        list.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-3 text-muted">جاري تحميل الأذكار...</p></div>';
        fetch('https://raw.githubusercontent.com/nawafalqari/azkar-api/56df51279ab6eb86dc2f6202c7de26c8948331c1/azkar.json')
            .then(res => res.json())
            .then(data => {
                azkarData = data;
                displayCategory(categoryName);
            }).catch(() => {
                list.innerHTML = '<div class="text-center py-5 text-danger">حدث خطأ أثناء تحميل الأذكار</div>';
            });
    } else {
        displayCategory(categoryName);
    }
    
    document.getElementById('zikrContentArea').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function displayCategory(categoryName) {
    const list = document.getElementById('zikrList');
    list.innerHTML = '';
    let categoryKey = Object.keys(azkarData).find(k => k.includes(categoryName) || categoryName.includes(k));
    
    if (!categoryKey && categoryName === 'أذكار الصباح') categoryKey = 'أذكار الصباح';
    if (!categoryKey && categoryName === 'أذكار المساء') categoryKey = 'أذكار المساء';
    
    if (categoryKey && azkarData[categoryKey]) {
        azkarData[categoryKey].forEach((zikr, index) => {
            const html = `
                <div class="col-lg-10 mb-4 zikr-item-container" data-aos="fade-up">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 zikr-card position-relative overflow-hidden">
                        <div class="progress position-absolute top-0 start-0 w-100 bg-light" style="height: 4px;">
                            <div class="progress-bar bg-primary zikr-progress" role="progressbar" style="width: 0%"></div>
                        </div>
                        <p class="fs-4 fw-bold lh-lg text-dark text-center mb-4" style="font-family: 'Amiri', 'Cairo', serif;">
                            "${zikr.content}"
                        </p>
                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-4 border-top">
                            <div class="text-muted small">
                                ${zikr.description || zikr.reference || ''}
                            </div>
                            <div class="d-flex align-items-center gap-3 mt-3 mt-md-0">
                                <button class="btn btn-primary rounded-pill d-flex align-items-center gap-3 px-4 zikr-counter-btn" data-target="${zikr.count || 1}" data-current="0">
                                    <span class="fs-5 fw-bold counter-text">0 / ${zikr.count || 1}</span>
                                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;">
                                        <i data-lucide="plus" style="width:16px;height:16px;"></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;
            list.insertAdjacentHTML('beforeend', html);
        });
        
        // Remove backslash for template literals below
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
                    text.textContent = `${current} / ${target}`;
                    progress.style.width = `${(current / target) * 100}%`;
                    if (navigator.vibrate) navigator.vibrate(50);
                    if (current === target) {
                        this.disabled = true;
                        container.classList.add('completed');
                        if (navigator.vibrate) navigator.vibrate([100, 50, 100]);
                    }
                }
            });
        });
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    } else {
        list.innerHTML = '<div class="text-center py-5 text-muted">لا توجد أذكار مسجلة في هذا التصنيف حالياً</div>';
    }
}
</script>
