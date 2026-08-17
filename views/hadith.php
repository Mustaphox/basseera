<?php 
$page_title = 'الأحاديث النبوية'; 

// Fetch categories from DB if available
$categories = [];
try {
    $stmt = $pdo->query("SELECT * FROM categories WHERE type = 'hadith' ORDER BY name ASC");
    if($stmt) $categories = $stmt->fetchAll();
} catch (Exception $e) {}
?>

<section class="py-5 bg-light-primary border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary mb-3">الأحاديث النبوية الشريفة</h1>
        <p class="lead text-muted mx-auto mb-4" style="max-width: 600px;">
            مكتبة جامعة لصحيح الأحاديث النبوية الشريفة من أمهات كتب الحديث المعتمدة
        </p>

        <!-- Search Bar -->
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-8">
                <div class="position-relative shadow-sm rounded-pill mb-3">
                    <i data-lucide="search" class="position-absolute top-50 translate-middle-y text-muted" style="right: 18px;"></i>
                    <input type="text" id="hadithSearch" class="form-control form-control-lg rounded-pill border-0 pe-5 shadow-sm" placeholder="ابحث في نص الحديث أو الراوي..." style="padding-right: 48px;">
                </div>
            </div>
        </div>

        <!-- Book Filter Buttons -->
        <div class="d-flex flex-wrap justify-content-center gap-2 mt-2">
            <button class="btn btn-primary rounded-pill px-4 filter-book active" data-book="bukhari" onclick="selectBook('bukhari', this)">صحيح البخاري</button>
            <button class="btn btn-outline-primary rounded-pill px-4 filter-book" data-book="muslim" onclick="selectBook('muslim', this)">صحيح مسلم</button>
            <button class="btn btn-outline-primary rounded-pill px-4 filter-book" data-book="tirmidzi" onclick="selectBook('tirmidzi', this)">جامع الترمذي</button>
            <button class="btn btn-outline-primary rounded-pill px-4 filter-book" data-book="abudawud" onclick="selectBook('abudawud', this)">سنن أبي داود</button>
            <button class="btn btn-outline-primary rounded-pill px-4 filter-book" data-book="nasai" onclick="selectBook('nasai', this)">سنن النسائي</button>
            <button class="btn btn-outline-primary rounded-pill px-4 filter-book" data-book="ibnumajah" onclick="selectBook('ibnumajah', this)">سنن ابن ماجه</button>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-lg-10" id="hadithContainer">
                <!-- Loader -->
                <div class="text-center py-5" id="hadithLoader">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-3 text-muted fw-bold">جاري تحميل الأحاديث الشريفة...</p>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center align-items-center gap-3 mt-4" id="hadithPagination" style="display:none;">
                <button class="btn btn-outline-primary rounded-pill px-4" id="prevHadithBtn" onclick="changeHadithPage(-1)">
                    <i data-lucide="chevron-right" class="me-1"></i> السابق
                </button>
                <span class="text-muted fw-bold" id="hadithPageIndicator">صفحة 1</span>
                <button class="btn btn-outline-primary rounded-pill px-4" id="nextHadithBtn" onclick="changeHadithPage(1)">
                    التالي <i data-lucide="chevron-left" class="ms-1"></i>
                </button>
            </div>
        </div>
        
    </div>
</section>

<style>
.hadith-card {
    border-right: 4px solid var(--bs-primary) !important;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.hadith-card:hover {
    transform: translateX(-4px);
    box-shadow: 0 10px 30px rgba(255,138,0,0.15) !important;
}
.hadith-arabic-text {
    font-family: 'Amiri', 'Cairo', serif;
    font-size: 1.45rem;
    line-height: 2.3;
    text-align: justify;
}
</style>

<script>
var currentBook = 'bukhari';
var hadithPage = 1;
var hadithsList = [];
var filteredHadiths = [];

function selectBook(book, btn) {
    document.querySelectorAll('.filter-book').forEach(function(b) {
        b.className = 'btn btn-outline-primary rounded-pill px-4 filter-book';
    });
    btn.className = 'btn btn-primary rounded-pill px-4 filter-book active';
    currentBook = book;
    hadithPage = 1;
    fetchHadiths(hadithPage);
}

function fetchHadiths(page) {
    var loader = document.getElementById('hadithLoader');
    var container = document.getElementById('hadithContainer');
    var pag = document.getElementById('hadithPagination');
    
    container.innerHTML = '';
    container.appendChild(loader);
    loader.classList.remove('d-none');
    pag.style.display = 'none';

    fetch('https://hadis-api-id.vercel.app/hadith/' + currentBook + '?page=' + page + '&limit=10')
        .then(function(res) { return res.json(); })
        .then(function(data) {
            loader.classList.add('d-none');
            hadithsList = data.items || [];
            filteredHadiths = hadithsList;
            renderHadiths();
        })
        .catch(function() {
            loader.classList.add('d-none');
            container.innerHTML = 
                '<div class="alert alert-warning rounded-4 border-0 p-4 text-center">' +
                    '<h4>تنبيه الاتصال</h4>' +
                    '<p class="mb-0">تعذر جلب الأحاديث من الخادم حالياً. يرجى التحقق من اتصالك بالإنترنت.</p>' +
                '</div>';
        });
}

function renderHadiths() {
    var container = document.getElementById('hadithContainer');
    var pag = document.getElementById('hadithPagination');
    container.innerHTML = '';

    if (filteredHadiths.length === 0) {
        container.innerHTML = '<div class="text-center py-5 text-muted"><h4>لا توجد أحاديث مطابقة</h4></div>';
        pag.style.display = 'none';
        return;
    }

    var bookName = document.querySelector('.filter-book.active').textContent;

    filteredHadiths.forEach(function(item, idx) {
        var card = 
            '<div class="card border-0 shadow-sm rounded-4 mb-4 hadith-card">' +
                '<div class="card-body p-4 p-md-5">' +
                    '<div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom flex-wrap gap-2">' +
                        '<div class="d-flex align-items-center gap-2">' +
                            '<span class="badge bg-warning bg-opacity-25 text-warning fw-bold px-3 py-2 rounded-pill">' + bookName + '</span>' +
                            '<span class="badge bg-light text-muted px-3 py-2 rounded-pill">رقم ' + (item.number || (idx + 1)) + '</span>' +
                        '</div>' +
                        '<button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="copyHadith(this, `' + escapeQuotes(item.arab || item.text) + '`, `' + bookName + '`)" title="نسخ الحديث">' +
                            '<i data-lucide="copy" style="width:14px;height:14px;" class="me-1"></i> نسخ' +
                        '</button>' +
                    '</div>' +
                    '<p class="hadith-arabic-text mb-0">' + (item.arab || item.text) + '</p>' +
                '</div>' +
            '</div>';
        container.insertAdjacentHTML('beforeend', card);
    });

    pag.style.display = 'flex';
    document.getElementById('hadithPageIndicator').textContent = 'صفحة ' + hadithPage;
    document.getElementById('prevHadithBtn').disabled = hadithPage <= 1;

    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function changeHadithPage(delta) {
    hadithPage += delta;
    fetchHadiths(hadithPage);
    window.scrollTo({ top: 350, behavior: 'smooth' });
}

function copyHadith(btn, text, book) {
    var full = text + '\n[' + book + ']';
    navigator.clipboard.writeText(full).then(function() {
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

document.getElementById('hadithSearch').addEventListener('input', function(e) {
    var q = e.target.value.trim().toLowerCase();
    filteredHadiths = hadithsList.filter(function(h) {
        return (h.arab || '').includes(q) || (h.id || '').toLowerCase().includes(q);
    });
    renderHadiths();
});

document.addEventListener('DOMContentLoaded', function() {
    fetchHadiths(1);
});
</script>
