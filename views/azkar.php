<?php $page_title = 'الأذكار اليومية'; ?>

<!-- Header -->
<section class="py-5 bg-light-primary border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary mb-3">حصن المسلم والأذكار اليومية</h1>
        <p class="lead text-muted mx-auto mb-4" style="max-width: 600px;">
            ﴿أَلَا بِذِكْرِ اللَّهِ تَطْمَئِنُّ الْقُلُوبُ﴾
        </p>

        <!-- Quick Category Select Bar -->
        <div class="d-flex flex-wrap justify-content-center gap-2" id="azkarCategoriesNav">
            <?php 
            $azkar_cats = [
                ['name' => 'أذكار الصباح', 'icon' => 'sunrise'],
                ['name' => 'أذكار المساء', 'icon' => 'sunset'],
                ['name' => 'أذكار النوم', 'icon' => 'moon'],
                ['name' => 'أذكار بعد الصلاة', 'icon' => 'activity'],
                ['name' => 'أذكار الاستيقاظ', 'icon' => 'sun'],
                ['name' => 'أذكار المسجد', 'icon' => 'home'],
                ['name' => 'أذكار الوضوء', 'icon' => 'droplet'],
                ['name' => 'أذكار الطعام', 'icon' => 'coffee']
            ];
            foreach($azkar_cats as $i => $cat):
            ?>
            <button class="btn <?= $i===0?'btn-primary':'btn-outline-primary' ?> rounded-pill px-3 py-2 cat-btn" onclick="selectAzkarCat('<?= $cat['name'] ?>', this)">
                <i data-lucide="<?= $cat['icon'] ?>" style="width:16px;height:16px;" class="me-1"></i> <?= $cat['name'] ?>
            </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-5">
    <div class="container">
        
        <!-- Header Info -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-wrap gap-2">
            <h3 class="fw-bold mb-0 text-primary" id="currentZikrTitle">أذكار الصباح</h3>
            <div class="d-flex gap-2 align-items-center">
                <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="resetCurrentZikrCounts()">
                    <i data-lucide="rotate-ccw" style="width:14px;height:14px;" class="me-1"></i> إعادة ضبط العداد
                </button>
            </div>
        </div>

        <!-- Loader -->
        <div class="text-center py-5" id="azkarLoader">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-3 text-muted fw-bold">جاري تحميل الأذكار...</p>
        </div>

        <!-- List -->
        <div class="row g-4 justify-content-center" id="azkarCardsList" style="display:none;"></div>

    </div>
</section>

<style>
.zikr-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease, opacity 0.25s ease;
    border-right: 4px solid var(--bs-primary) !important;
}
.zikr-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(255,138,0,0.18) !important;
}
.zikr-card.completed {
    opacity: 0.65;
    border-right-color: #22C55E !important;
}
.zikr-text {
    font-family: 'Amiri', 'Cairo', serif;
    font-size: 1.5rem;
    line-height: 2.3;
    text-align: justify;
}
.counter-btn {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    font-size: 1.25rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 15px rgba(255,138,0,0.35);
}
.counter-btn:active {
    transform: scale(0.92);
}
.counter-btn.done {
    background: #22C55E !important;
    box-shadow: 0 4px 15px rgba(34,197,94,0.35) !important;
}
</style>

<script>
var azkarDatabase = {};
var currentCat = 'أذكار الصباح';
var countsMap = {};

function selectAzkarCat(catName, btn) {
    document.querySelectorAll('.cat-btn').forEach(function(b) {
        b.className = 'btn btn-outline-primary rounded-pill px-3 py-2 cat-btn';
    });
    btn.className = 'btn btn-primary rounded-pill px-3 py-2 cat-btn';
    currentCat = catName;
    document.getElementById('currentZikrTitle').textContent = catName;
    renderCurrentCategory();
}

function loadAzkarData() {
    var loader = document.getElementById('azkarLoader');
    var list = document.getElementById('azkarCardsList');
    loader.style.display = 'block';
    list.style.display = 'none';

    fetch('https://raw.githubusercontent.com/nawafalqari/azkar-api/56df51279ab6eb86dc2f6202c7de26c8948331c1/azkar.json')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            loader.style.display = 'none';
            list.style.display = 'flex';
            azkarDatabase = data;
            renderCurrentCategory();
        })
        .catch(function() {
            loader.innerHTML = '<div class="alert alert-danger rounded-4 border-0 p-4 text-center">تعذر تحميل الأذكار. يرجى التأكد من الاتصال بالإنترنت.</div>';
        });
}

function renderCurrentCategory() {
    var list = document.getElementById('azkarCardsList');
    list.innerHTML = '';

    var items = azkarDatabase[currentCat] || [];
    if (items.length === 0) {
        list.innerHTML = '<div class="col-12 text-center py-5 text-muted"><h4>لا توجد أذكار في هذا القسم</h4></div>';
        return;
    }

    items.forEach(function(z, idx) {
        var key = currentCat + '_' + idx;
        var targetCount = parseInt(z.count) || 1;
        if (countsMap[key] === undefined) countsMap[key] = targetCount;
        var remaining = countsMap[key];
        var isDone = remaining <= 0;

        var col = document.createElement('div');
        col.className = 'col-lg-6';
        col.innerHTML = 
            '<div class="card h-100 border-0 shadow-sm rounded-4 p-4 zikr-card ' + (isDone ? 'completed' : '') + '" id="card_' + key + '">' +
                '<div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">' +
                    '<span class="badge bg-warning bg-opacity-25 text-warning fw-bold px-3 py-1 rounded-pill">ذكر ' + (idx + 1) + '</span>' +
                    '<button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="copyZikr(this, `' + escapeQuotes(z.content || z.text) + '`)">' +
                        '<i data-lucide="copy" style="width:14px;height:14px;" class="me-1"></i> نسخ' +
                    '</button>' +
                '</div>' +
                '<p class="zikr-text mb-4">' + (z.content || z.text) + '</p>' +
                (z.description ? '<div class="alert alert-light p-3 small mb-4 rounded-3 text-muted"><i data-lucide="info" style="width:14px;height:14px;" class="me-1 text-primary"></i> ' + z.description + '</div>' : '') +
                '<div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">' +
                    '<span class="text-muted small">' + (z.reference ? 'المرجع: ' + z.reference : 'التكرار: ' + targetCount) + '</span>' +
                    '<button class="btn btn-primary counter-btn ' + (isDone ? 'done' : '') + '" id="btn_' + key + '" onclick="decrementZikr(\'' + key + '\', ' + targetCount + ')">' +
                        (isDone ? '<i data-lucide="check" style="width:24px;height:24px;"></i>' : remaining) +
                    '</button>' +
                '</div>' +
            '</div>';
        list.appendChild(col);
    });

    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function decrementZikr(key, targetCount) {
    if (countsMap[key] > 0) {
        countsMap[key]--;
        var btn = document.getElementById('btn_' + key);
        var card = document.getElementById('card_' + key);
        if (countsMap[key] <= 0) {
            btn.className = 'btn btn-primary counter-btn done';
            btn.innerHTML = '<i data-lucide="check" style="width:24px;height:24px;"></i>';
            card.classList.add('completed');
            if (typeof lucide !== 'undefined') lucide.createIcons();
        } else {
            btn.textContent = countsMap[key];
        }
    }
}

function resetCurrentZikrCounts() {
    var items = azkarDatabase[currentCat] || [];
    items.forEach(function(z, idx) {
        var key = currentCat + '_' + idx;
        countsMap[key] = parseInt(z.count) || 1;
    });
    renderCurrentCategory();
}

function copyZikr(btn, text) {
    navigator.clipboard.writeText(text).then(function() {
        btn.innerHTML = '<i data-lucide="check" style="width:14px;height:14px;" class="me-1"></i> تم النسخ';
        if (typeof lucide !== 'undefined') lucide.createIcons();
        setTimeout(function() {
            btn.innerHTML = '<i data-lucide="copy" style="width:14px;height:14px;" class="me-1"></i> نسخ';
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }, 2000);
    });
}

function escapeQuotes(str) {
    if (!str) return '';
    return str.replace(/`/g, "'").replace(/"/g, '&quot;');
}

document.addEventListener('DOMContentLoaded', function() {
    loadAzkarData();
});
</script>
