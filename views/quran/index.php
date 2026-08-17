<?php $page_title = 'القرآن الكريم'; ?>

<section class="py-5 bg-light-primary mb-4 position-relative overflow-hidden">
    <div class="hero-bg-pattern position-absolute w-100 h-100 top-0 start-0 opacity-25"></div>
    <div class="container text-center position-relative z-1">
        <h1 class="display-4 fw-bold text-primary mb-3">القرآن الكريم</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">تلاوة، تفسير، واستماع لكامل سور القرآن الكريم بأصوات نخبة القراء</p>
    </div>
</section>

<section class="py-4">
    <div class="container">

        <!-- Controls & Filters -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <div class="row g-3 align-items-center">
                <!-- Search input -->
                <div class="col-lg-4 col-md-6">
                    <div class="position-relative">
                        <i data-lucide="search" class="position-absolute top-50 translate-middle-y text-muted" style="right: 16px; pointer-events:none;"></i>
                        <input type="text" id="surahSearch" class="form-control form-control-lg pe-5 bg-light border-0" placeholder="ابحث عن سورة (مثال: البقرة، الكهف)..." style="padding-right: 48px;">
                    </div>
                </div>

                <!-- Reciter selector -->
                <div class="col-lg-3 col-md-6">
                    <select id="readerSelect" class="form-select form-select-lg bg-light border-0">
                        <option value="ar.alafasy">مشاري راشد العفاسي</option>
                        <option value="ar.abdulbasitmurattal">عبد الباسط عبد الصمد (مرتل)</option>
                        <option value="ar.husary">محمود خليل الحصري</option>
                        <option value="ar.minshawi">محمد صديق المنشاوي (مرتل)</option>
                        <option value="ar.sudais">عبد الرحمن السديس</option>
                        <option value="ar.maher">ماهر المعيقلي</option>
                        <option value="ar.ghamdi">سعد الغامدي</option>
                        <option value="ar.dosari">ياسر الدوسري</option>
                        <option value="ar.shatri">أبو بكر الشاطري</option>
                        <option value="ar.ajamy">أحمد بن علي العجمي</option>
                    </select>
                </div>

                <!-- Revelation Filter -->
                <div class="col-lg-3 col-md-6">
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="revelationFilter" id="filterAll" value="all" checked>
                        <label class="btn btn-outline-primary rounded-start-pill" for="filterAll">الكل</label>
                        <input type="radio" class="btn-check" name="revelationFilter" id="filterMeccan" value="Meccan">
                        <label class="btn btn-outline-primary" for="filterMeccan">مكية</label>
                        <input type="radio" class="btn-check" name="revelationFilter" id="filterMedinan" value="Medinan">
                        <label class="btn btn-outline-primary rounded-end-pill" for="filterMedinan">مدنية</label>
                    </div>
                </div>

                <!-- Jump to Surah -->
                <div class="col-lg-2 col-md-6">
                    <select id="quickJumpSelect" class="form-select form-select-lg bg-light border-0" onchange="if(this.value) window.location.href='<?= BASE_URL ?>quran/surah?id='+this.value">
                        <option value="">انتقال لسورة...</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Skeleton Loader -->
        <div class="row g-4" id="skeletonLoader">
            <?php for($i=0; $i<9; $i++): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card p-4 border-0 shadow-sm rounded-4 placeholder-glow" style="min-height: 140px;">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="placeholder rounded-circle bg-secondary" style="width:48px; height:48px; flex-shrink:0;"></span>
                        <div class="flex-grow-1">
                            <span class="placeholder col-7 mb-2 d-block rounded" style="height:18px;"></span>
                            <span class="placeholder col-4 d-block rounded" style="height:14px;"></span>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="placeholder col-6 rounded-pill" style="height:38px;"></span>
                        <span class="placeholder col-6 rounded-pill" style="height:38px;"></span>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>

        <!-- Error State -->
        <div id="errorState" class="d-none text-center py-5">
            <div class="mb-4" style="font-size: 4rem;">😔</div>
            <h4 class="text-danger fw-bold mb-2">تعذّر تحميل السور</h4>
            <p class="text-muted mb-4">تحقق من اتصالك بالإنترنت وأعد المحاولة</p>
            <button class="btn btn-primary px-5 rounded-pill" onclick="loadSurahs()">
                <i data-lucide="refresh-cw" class="me-2"></i> إعادة المحاولة
            </button>
        </div>

        <!-- Surahs Grid -->
        <div class="row g-3 g-md-4" id="surahsGrid" style="display:none;"></div>

        <!-- Pagination Controls -->
        <div class="d-flex justify-content-center align-items-center gap-3 mt-5" id="surahsPagination" style="display:none;">
            <button class="btn btn-outline-primary rounded-pill px-4" id="prevSurahBtn" onclick="changeSurahPage(-1)">
                <i data-lucide="chevron-right" class="me-1"></i> السابق
            </button>
            <span class="text-muted fw-bold" id="surahPageIndicator">صفحة 1 من 6</span>
            <button class="btn btn-outline-primary rounded-pill px-4" id="nextSurahBtn" onclick="changeSurahPage(1)">
                التالي <i data-lucide="chevron-left" class="ms-1"></i>
            </button>
        </div>

        <!-- No Results -->
        <div id="noResults" class="d-none text-center py-5">
            <div class="mb-4" style="font-size: 4rem;">🔍</div>
            <h4 class="text-muted fw-bold">لا توجد نتائج مطابقة</h4>
        </div>

    </div>
</section>

<style>
.surah-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
}
.surah-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 35px rgba(255,138,0,0.2) !important;
    border-color: rgba(255,138,0,0.45) !important;
    background: linear-gradient(135deg, rgba(255,138,0,0.12), rgba(255,80,30,0.06)) !important;
}
.surah-num-badge {
    width: 46px; height: 46px; flex-shrink: 0;
    background: linear-gradient(135deg, rgba(255,138,0,0.25), rgba(255,80,30,0.15));
    border: 1px solid rgba(255,138,0,0.35);
    color: #FF8A00;
    font-size: 1.05rem; font-weight: 700;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
}
.revelation-badge {
    font-size: 0.75rem; font-weight: 600;
    padding: 3px 10px; border-radius: 20px;
}
</style>

<script>
var allSurahs = [];
var filteredSurahs = [];
var currentSurahPage = 1;
var surahPageSize = 21;

function loadSurahs() {
    document.getElementById('skeletonLoader').style.display = '';
    document.getElementById('errorState').classList.add('d-none');
    document.getElementById('surahsGrid').style.display = 'none';
    document.getElementById('surahsPagination').style.display = 'none';

    fetch('https://api.alquran.cloud/v1/surah')
        .then(function(res) { return res.json(); })
        .then(function(json) {
            if (json.code !== 200 || !json.data) throw new Error('API Error');
            allSurahs = json.data;
            document.getElementById('skeletonLoader').style.display = 'none';
            document.getElementById('surahsGrid').style.display = '';
            
            // Populate quick jump dropdown
            var jumpSelect = document.getElementById('quickJumpSelect');
            allSurahs.forEach(function(s) {
                var opt = document.createElement('option');
                opt.value = s.number;
                opt.textContent = s.number + '. ' + s.name;
                jumpSelect.appendChild(opt);
            });

            applyFilters();
        })
        .catch(function() {
            document.getElementById('skeletonLoader').style.display = 'none';
            document.getElementById('errorState').classList.remove('d-none');
        });
}

function applyFilters() {
    var query = document.getElementById('surahSearch').value.trim().toLowerCase();
    var typeFilter = document.querySelector('input[name="revelationFilter"]:checked').value;

    filteredSurahs = allSurahs.filter(function(s) {
        var matchSearch = s.name.includes(query) ||
                          s.englishName.toLowerCase().includes(query) ||
                          s.englishNameTranslation.toLowerCase().includes(query) ||
                          String(s.number) === query;
        var matchType = typeFilter === 'all' || s.revelationType === typeFilter;
        return matchSearch && matchType;
    });

    currentSurahPage = 1;
    renderSurahs();
}

function renderSurahs() {
    var grid = document.getElementById('surahsGrid');
    var noRes = document.getElementById('noResults');
    var pag = document.getElementById('surahsPagination');

    if (filteredSurahs.length === 0) {
        grid.innerHTML = '';
        noRes.classList.remove('d-none');
        pag.style.display = 'none';
        return;
    }
    noRes.classList.add('d-none');

    var totalPages = Math.ceil(filteredSurahs.length / surahPageSize);
    var start = (currentSurahPage - 1) * surahPageSize;
    var end = Math.min(start + surahPageSize, filteredSurahs.length);
    var pageItems = filteredSurahs.slice(start, end);

    var html = '';
    pageItems.forEach(function(surah) {
        var typeAr = surah.revelationType === 'Meccan' ? 'مكية' : 'مدنية';
        var badgeClass = surah.revelationType === 'Meccan' ? 'meccan-badge' : 'medinan-badge';

        html += '<div class="col-xl-4 col-md-6">' +
            '<div class="card h-100 p-4 border-0 shadow-sm rounded-4 surah-card">' +
                '<div class="d-flex justify-content-between align-items-center mb-3">' +
                    '<div class="d-flex align-items-center gap-3">' +
                        '<div class="surah-num-badge">' + surah.number + '</div>' +
                        '<div>' +
                            '<h3 class="h5 mb-1 fw-bold" style="font-family: \'Amiri\', serif;">' + surah.name + '</h3>' +
                            '<small class="text-muted d-block">' + surah.englishName + '</small>' +
                        '</div>' +
                    '</div>' +
                    '<div class="text-end">' +
                        '<span class="revelation-badge ' + badgeClass + ' d-block mb-1">' + typeAr + '</span>' +
                        '<small class="text-muted">' + surah.numberOfAyahs + ' آية</small>' +
                    '</div>' +
                '</div>' +
                '<div class="d-flex gap-2 mt-auto pt-2">' +
                    '<a href="<?= BASE_URL ?>quran/surah?id=' + surah.number + '" class="btn btn-primary flex-grow-1 rounded-pill fw-bold">' +
                        '<i data-lucide="book-open" style="width:15px;height:15px;" class="me-1"></i> اقرأ' +
                    '</a>' +
                    '<button onclick="playSurah(' + surah.number + ')" class="btn btn-outline-primary flex-grow-1 rounded-pill fw-bold">' +
                        '<i data-lucide="headphones" style="width:15px;height:15px;" class="me-1"></i> استمع' +
                    '</button>' +
                '</div>' +
            '</div>' +
        '</div>';
    });

    grid.innerHTML = html;

    if (totalPages > 1) {
        pag.style.display = 'flex';
        document.getElementById('surahPageIndicator').textContent = 'صفحة ' + currentSurahPage + ' من ' + totalPages;
        document.getElementById('prevSurahBtn').disabled = currentSurahPage <= 1;
        document.getElementById('nextSurahBtn').disabled = currentSurahPage >= totalPages;
    } else {
        pag.style.display = 'none';
    }

    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function changeSurahPage(delta) {
    currentSurahPage += delta;
    renderSurahs();
    window.scrollTo({ top: 350, behavior: 'smooth' });
}

function playSurah(id) {
    var reader = document.getElementById('readerSelect').value;
    window.location.href = '<?= BASE_URL ?>quran/surah?id=' + id + '&listen=true&reader=' + encodeURIComponent(reader) + '&mode=full';
}

document.getElementById('surahSearch').addEventListener('input', applyFilters);
document.querySelectorAll('input[name="revelationFilter"]').forEach(function(r) {
    r.addEventListener('change', applyFilters);
});

loadSurahs();
</script>
