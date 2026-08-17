<?php 
$page_title = 'البحث الشامل'; 
$q = isset($_GET['q']) ? htmlspecialchars(trim($_GET['q']), ENT_QUOTES, 'UTF-8') : '';
?>

<!-- Search Hero Header -->
<section class="py-5 bg-light-primary border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary mb-3">البحث الإسلامي الشامل</h1>
        <p class="lead text-muted mx-auto mb-4" style="max-width: 600px;">
            ابحث في سور وآيات القرآن الكريم، الأحاديث النبوية، والأذكار والأدعية
        </p>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <form action="<?= BASE_URL ?>search" method="GET" class="position-relative shadow-sm rounded-pill" onsubmit="event.preventDefault(); triggerSearch();">
                    <button type="submit" class="position-absolute top-50 translate-middle-y border-0 bg-transparent text-primary" style="left: 18px; cursor:pointer;" title="بحث">
                        <i data-lucide="search" style="width:24px;height:24px;"></i>
                    </button>
                    <input type="text" name="q" id="searchInput" value="<?= $q ?>" class="form-control form-control-lg rounded-pill border-0 shadow-sm" placeholder="ابحث باسم سورة، آية، أو كلمة (مثال: الكهف، الرحمن، الصبر)..." style="padding: 16px 20px 16px 55px;">
                </form>

                <!-- Quick Suggestion Tags -->
                <div class="d-flex gap-2 justify-content-center mt-3 flex-wrap">
                    <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill search-suggestion" onclick="quickSearch('الفاتحة')">الفاتحة</span>
                    <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill search-suggestion" onclick="quickSearch('البقرة')">البقرة</span>
                    <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill search-suggestion" onclick="quickSearch('الكهف')">الكهف</span>
                    <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill search-suggestion" onclick="quickSearch('يس')">يس</span>
                    <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill search-suggestion" onclick="quickSearch('الملك')">الملك</span>
                    <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill search-suggestion" onclick="quickSearch('الصبر')">الصبر</span>
                    <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill search-suggestion" onclick="quickSearch('الجنة')">الجنة</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Body Section -->
<section class="py-5">
    <div class="container">

        <!-- Loading State -->
        <div id="searchLoader" class="text-center py-5 d-none">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-3 text-muted fw-bold">جاري البحث في قاعدة البيانات والقرآن الكريم...</p>
        </div>

        <!-- Filter Tabs (Hidden initially until results load) -->
        <div id="filterTabsContainer" class="d-none mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-3 border-bottom">
                <div class="btn-group p-1 rounded-pill bg-light border" role="group">
                    <button type="button" class="btn btn-sm rounded-pill px-3 fw-bold btn-primary" id="tabAll" onclick="switchTab('all')">
                        الكل (<span id="countAll">0</span>)
                    </button>
                    <button type="button" class="btn btn-sm rounded-pill px-3 fw-bold btn-light text-muted" id="tabSurahs" onclick="switchTab('surahs')">
                        السور (<span id="countSurahs">0</span>)
                    </button>
                    <button type="button" class="btn btn-sm rounded-pill px-3 fw-bold btn-light text-muted" id="tabAyahs" onclick="switchTab('ayahs')">
                        الآيات (<span id="countAyahs">0</span>)
                    </button>
                    <button type="button" class="btn btn-sm rounded-pill px-3 fw-bold btn-light text-muted" id="tabHadiths" onclick="switchTab('hadiths')">
                        الأحاديث والأذكار (<span id="countOther">0</span>)
                    </button>
                </div>
                <div class="text-muted small">
                    نتائج البحث عن: <strong class="text-primary" id="currentQueryLabel"></strong>
                </div>
            </div>
        </div>

        <!-- Results Containers -->
        <div id="searchResults">
            <?php if(!$q): ?>
            <div class="text-center py-5" data-aos="fade-up">
                <div class="mb-4 text-primary opacity-75" style="font-size: 4.5rem;">🔍</div>
                <h3 class="fw-bold mb-2">ابدأ البحث في بصيرة</h3>
                <p class="text-muted mx-auto" style="max-width: 500px;">
                    اكتب اسم أي سورة أو كلمة ترغب في البحث عنها في آيات القرآن الكريم أو الأحاديث النبوية
                </p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Surahs Results Section -->
        <div id="surahsSection" class="mb-5 d-none">
            <h4 class="fw-bold text-primary mb-3"><i data-lucide="book-open" class="me-2"></i>السور المطابقة</h4>
            <div class="row g-3" id="surahsGrid"></div>
        </div>

        <!-- Ayahs Results Section with Pagination -->
        <div id="ayahsSection" class="mb-5 d-none">
            <h4 class="fw-bold text-primary mb-3"><i data-lucide="align-right" class="me-2"></i>الآيات القرآنية</h4>
            <div id="ayahsList"></div>
            <!-- Pagination -->
            <div id="ayahPagination" class="d-flex justify-content-center gap-2 mt-4 d-none"></div>
        </div>

        <!-- Hadiths & Other Section -->
        <div id="otherSection" class="mb-5 d-none">
            <h4 class="fw-bold text-primary mb-3"><i data-lucide="message-circle" class="me-2"></i>الأحاديث والأذكار</h4>
            <div id="otherList"></div>
        </div>

    </div>
</section>

<style>
.ayah-result-card {
    border-right: 4px solid var(--bs-primary) !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.ayah-result-card:hover {
    transform: translateX(-4px);
    box-shadow: 0 8px 25px rgba(255,138,0,0.15) !important;
}
.search-suggestion { 
    cursor: pointer; 
    transition: all 0.2s; 
}
.search-suggestion:hover { 
    background: var(--bs-primary) !important; 
    color: white !important; 
}
.quran-match-text { 
    font-family: 'Amiri', 'Cairo', serif; 
    font-size: 1.5rem; 
    line-height: 2.2; 
}
.quran-match-text mark { 
    background: rgba(255,138,0,0.25); 
    color: var(--bs-primary); 
    padding: 0 6px; 
    border-radius: 4px; 
    font-weight: 700;
}
</style>

<script>
var searchData = { surahs: [], ayahs: [], hadiths: [], azkar: [] };
var currentTab = 'all';
var ayahPage = 1;
var ayahPageSize = 10;
var currentQuery = '';

function quickSearch(word) {
    document.getElementById('searchInput').value = word;
    triggerSearch();
}

function triggerSearch() {
    var query = document.getElementById('searchInput').value.trim();
    if (!query) return;
    runSearch(query);
}

function runSearch(query) {
    currentQuery = query;
    var loader = document.getElementById('searchLoader');
    var tabs = document.getElementById('filterTabsContainer');
    var searchResults = document.getElementById('searchResults');
    
    loader.classList.remove('d-none');
    searchResults.innerHTML = '';
    hideAllSections();

    fetch('<?= BASE_URL ?>api/quran_search.php?q=' + encodeURIComponent(query))
        .then(function(res) { return res.json(); })
        .then(function(data) {
            loader.classList.add('d-none');

            if (!data.success || data.total_count === 0) {
                tabs.classList.add('d-none');
                searchResults.innerHTML = 
                    '<div class="text-center py-5">' +
                        '<div class="mb-4 text-muted" style="font-size: 4rem;">🔍</div>' +
                        '<h4 class="fw-bold mb-2">لا توجد نتائج مطابقة لـ "' + escapeHtml(query) + '"</h4>' +
                        '<p class="text-muted">تأكد من صحة الكلمة أو جرب كلمات بحث أخرى (مثل: الفاتحة، النور، الرحمة)</p>' +
                    '</div>';
                return;
            }

            searchData = data;
            document.getElementById('currentQueryLabel').textContent = query;
            document.getElementById('countAll').textContent = data.total_count;
            document.getElementById('countSurahs').textContent = data.surahs.length;
            document.getElementById('countAyahs').textContent = data.ayahs.length;
            document.getElementById('countOther').textContent = data.hadiths.length + data.azkar.length;

            tabs.classList.remove('d-none');
            switchTab('all');
        })
        .catch(function(err) {
            loader.classList.add('d-none');
            searchResults.innerHTML = '<div class="alert alert-danger rounded-4 border-0 p-4 text-center">تعذر الاتصال بالخادم. يرجى المحاولة لاحقاً.</div>';
        });
}

function switchTab(tab) {
    currentTab = tab;
    
    // Update active tab buttons
    ['all', 'surahs', 'ayahs', 'hadiths'].forEach(function(t) {
        var btn = document.getElementById('tab' + t.charAt(0).toUpperCase() + t.slice(1));
        if (btn) {
            if (t === tab) {
                btn.className = 'btn btn-sm rounded-pill px-3 fw-bold btn-primary';
            } else {
                btn.className = 'btn btn-sm rounded-pill px-3 fw-bold btn-light text-muted';
            }
        }
    });

    hideAllSections();

    if (tab === 'all') {
        if (searchData.surahs.length > 0) renderSurahs();
        if (searchData.ayahs.length > 0) renderAyahs(1);
        if (searchData.hadiths.length > 0 || searchData.azkar.length > 0) renderOther();
    } else if (tab === 'surahs') {
        renderSurahs();
    } else if (tab === 'ayahs') {
        renderAyahs(1);
    } else if (tab === 'hadiths') {
        renderOther();
    }
}

function hideAllSections() {
    document.getElementById('surahsSection').classList.add('d-none');
    document.getElementById('ayahsSection').classList.add('d-none');
    document.getElementById('otherSection').classList.add('d-none');
}

function renderSurahs() {
    var sec = document.getElementById('surahsSection');
    var grid = document.getElementById('surahsGrid');
    grid.innerHTML = '';

    searchData.surahs.forEach(function(s) {
        var card = 
            '<div class="col-md-6 col-lg-4">' +
                '<div class="card h-100 p-4 border-0 shadow-sm rounded-4">' +
                    '<div class="d-flex justify-content-between align-items-center mb-3">' +
                        '<div class="d-flex align-items-center gap-3">' +
                            '<div class="badge bg-primary text-white rounded-circle p-2 fs-6" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">' + s.number + '</div>' +
                            '<div>' +
                                '<h5 class="fw-bold mb-0" style="font-family:\'Amiri\',serif;">' + s.name + '</h5>' +
                                '<small class="text-muted">' + s.englishName + '</small>' +
                            '</div>' +
                        '</div>' +
                        '<span class="badge bg-light text-muted px-3 py-1 rounded-pill">' + s.revelationType + ' &bull; ' + s.numberOfAyahs + ' آية</span>' +
                    '</div>' +
                    '<div class="d-flex gap-2 mt-2">' +
                        '<a href="<?= BASE_URL ?>quran/surah?id=' + s.number + '" class="btn btn-sm btn-primary flex-grow-1 rounded-pill">' +
                            '<i data-lucide="book-open" style="width:14px;height:14px;" class="me-1"></i> قراءة' +
                        '</a>' +
                        '<a href="<?= BASE_URL ?>quran/surah?id=' + s.number + '&listen=true" class="btn btn-sm btn-outline-primary flex-grow-1 rounded-pill">' +
                            '<i data-lucide="headphones" style="width:14px;height:14px;" class="me-1"></i> استماع' +
                        '</a>' +
                    '</div>' +
                '</div>' +
            '</div>';
        grid.insertAdjacentHTML('beforeend', card);
    });

    sec.classList.remove('d-none');
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function renderAyahs(page) {
    ayahPage = page;
    var sec = document.getElementById('ayahsSection');
    var list = document.getElementById('ayahsList');
    var pag = document.getElementById('ayahPagination');
    list.innerHTML = '';

    var total = searchData.ayahs.length;
    var start = (page - 1) * ayahPageSize;
    var end = Math.min(start + ayahPageSize, total);
    var pagedAyahs = searchData.ayahs.slice(start, end);

    pagedAyahs.forEach(function(a) {
        var highlighted = highlightMatch(a.text, currentQuery);
        var card = 
            '<div class="card border-0 shadow-sm rounded-4 mb-3 p-4 ayah-result-card">' +
                '<div class="d-flex justify-content-between align-items-center mb-3">' +
                    '<div class="d-flex align-items-center gap-2">' +
                        '<span class="badge bg-warning bg-opacity-25 text-warning fw-bold px-3 py-2 rounded-pill">سورة ' + a.surah.name + '</span>' +
                        '<span class="badge bg-light text-muted px-3 py-2 rounded-pill">الآية ' + a.numberInSurah + '</span>' +
                    '</div>' +
                    '<a href="<?= BASE_URL ?>quran/surah?id=' + a.surah.number + '#ayah-' + (a.numberInSurah - 1) + '" class="btn btn-sm btn-outline-primary rounded-pill px-3">' +
                        '<i data-lucide="arrow-left" style="width:14px;height:14px;" class="me-1"></i> عرض في السورة' +
                    '</a>' +
                '</div>' +
                '<p class="quran-match-text mb-0">' + highlighted + '</p>' +
            '</div>';
        list.insertAdjacentHTML('beforeend', card);
    });

    // Render Pagination buttons if total > ayahPageSize
    if (total > ayahPageSize) {
        var totalPages = Math.ceil(total / ayahPageSize);
        var pagHtml = '';
        if (page > 1) {
            pagHtml += '<button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="renderAyahs(' + (page - 1) + ')">السابق</button>';
        }
        pagHtml += '<span class="align-self-center px-3 text-muted small">صفحة ' + page + ' من ' + totalPages + '</span>';
        if (page < totalPages) {
            pagHtml += '<button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="renderAyahs(' + (page + 1) + ')">التالي</button>';
        }
        pag.innerHTML = pagHtml;
        pag.classList.remove('d-none');
    } else {
        pag.classList.add('d-none');
    }

    sec.classList.remove('d-none');
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function renderOther() {
    var sec = document.getElementById('otherSection');
    var list = document.getElementById('otherList');
    list.innerHTML = '';

    searchData.hadiths.forEach(function(h) {
        var card = 
            '<div class="card border-0 shadow-sm rounded-4 mb-3 p-4">' +
                '<div class="d-flex justify-content-between align-items-center mb-2">' +
                    '<span class="badge bg-success bg-opacity-25 text-success px-3 py-1 rounded-pill">حديث شريف</span>' +
                    (h.reference ? '<small class="text-muted">' + escapeHtml(h.reference) + '</small>' : '') +
                '</div>' +
                '<p class="mb-2 fs-5 lh-lg" style="font-family:\'Cairo\',serif;">' + highlightMatch(h.text, currentQuery) + '</p>' +
                (h.narrator ? '<small class="text-muted d-block">الراوي: ' + escapeHtml(h.narrator) + '</small>' : '') +
            '</div>';
        list.insertAdjacentHTML('beforeend', card);
    });

    searchData.azkar.forEach(function(z) {
        var card = 
            '<div class="card border-0 shadow-sm rounded-4 mb-3 p-4">' +
                '<div class="d-flex justify-content-between align-items-center mb-2">' +
                    '<span class="badge bg-info bg-opacity-25 text-info px-3 py-1 rounded-pill">' + escapeHtml(z.type) + '</span>' +
                    (z.reference ? '<small class="text-muted">' + escapeHtml(z.reference) + '</small>' : '') +
                '</div>' +
                '<p class="mb-0 fs-5 lh-lg" style="font-family:\'Cairo\',serif;">' + highlightMatch(z.text, currentQuery) + '</p>' +
            '</div>';
        list.insertAdjacentHTML('beforeend', card);
    });

    sec.classList.remove('d-none');
}

function highlightMatch(text, query) {
    if (!query) return escapeHtml(text);
    var cleanQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    var re = new RegExp('(' + cleanQuery + ')', 'gi');
    return escapeHtml(text).replace(re, '<mark>$1</mark>');
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

document.addEventListener('DOMContentLoaded', function() {
    <?php if($q): ?>
    runSearch("<?= addslashes($q) ?>");
    <?php endif; ?>
});
</script>
