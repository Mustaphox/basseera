<?php $page_title = 'أسماء الله الحسنى'; ?>

<!-- Page Header -->
<section class="py-5 bg-light-primary border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary mb-3">أسماء الله الحسنى</h1>
        <p class="lead text-muted mx-auto mb-4" style="max-width: 600px;">
            ﴿وَلِلَّهِ الْأَسْمَاءُ الْحُسْنَىٰ فَادْعُوهُ بِهَا﴾
        </p>

        <!-- Search & Filter Controls -->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="position-relative shadow-sm rounded-pill mb-3">
                    <i data-lucide="search" class="position-absolute top-50 translate-middle-y text-muted" style="right: 18px;"></i>
                    <input type="text" id="asmaSearch" class="form-control form-control-lg rounded-pill border-0 shadow-sm pe-5" placeholder="ابحث في أسماء الله الحسنى (مثال: الرحمن، الحكيم)..." style="padding-right: 48px;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Grid Section -->
<section class="py-5">
    <div class="container">
        
        <!-- Loader -->
        <div id="asmaLoader" class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-3 text-muted fw-bold">جاري تحميل الأسماء الحسنى ومعانيها...</p>
        </div>

        <!-- Grid Container -->
        <div class="row g-3 g-md-4" id="asmaGrid" style="display: none;"></div>

        <!-- Pagination Controls -->
        <div class="d-flex justify-content-center align-items-center gap-3 mt-5" id="asmaPagination" style="display: none;">
            <button class="btn btn-outline-primary rounded-pill px-4" id="prevPageBtn" onclick="changePage(-1)">
                <i data-lucide="chevron-right" class="me-1"></i> السابق
            </button>
            <span class="text-muted fw-bold" id="pageIndicator">صفحة 1 من 4</span>
            <button class="btn btn-outline-primary rounded-pill px-4" id="nextPageBtn" onclick="changePage(1)">
                التالي <i data-lucide="chevron-left" class="ms-1"></i>
            </button>
        </div>

        <!-- Empty Results -->
        <div id="noAsmaResults" class="text-center py-5 d-none">
            <div class="mb-3 text-muted" style="font-size: 3.5rem;">🔍</div>
            <h4 class="text-muted fw-bold">لا يوجد اسم مطابق للبحث</h4>
        </div>
        
    </div>
</section>

<!-- Meaning Modal -->
<div class="modal fade" id="asmaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-primary">معنى الاسم الكريم</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center mb-3 fs-1 fw-bold asma-modal-icon" 
                     style="width: 110px; height: 110px; font-family: 'Amiri', serif; background: linear-gradient(135deg, rgba(255,138,0,0.25), rgba(255,80,30,0.15)); border: 2px solid rgba(255,138,0,0.4); color: #FF8A00;" id="modalArName">
                    <!-- Name -->
                </div>
                <h4 class="fw-bold mb-3" id="modalEnName" dir="ltr">--</h4>
                <div class="p-4 rounded-4 fs-5 lh-lg" id="modalMeaning" style="background: rgba(255,138,0,0.08); border: 1px solid rgba(255,138,0,0.2);">
                    --
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.asma-card {
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    border: 1px solid var(--card-border) !important;
}
.asma-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(255,138,0,0.2) !important;
    border-color: rgba(255,138,0,0.5) !important;
    background: linear-gradient(135deg, rgba(255,138,0,0.15), rgba(255,80,30,0.08)) !important;
}
.asma-number {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--bs-primary);
    position: absolute;
    top: 12px;
    right: 14px;
}
</style>

<script>
var allAsma = [];
var filteredAsma = [];
var asmaPage = 1;
var asmaPageSize = 24;
var asmaModal = null;

document.addEventListener('DOMContentLoaded', function() {
    asmaModal = new bootstrap.Modal(document.getElementById('asmaModal'));
    
    fetch('https://api.aladhan.com/v1/asmaAlHusna')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            document.getElementById('asmaLoader').style.display = 'none';
            document.getElementById('asmaGrid').style.display = 'flex';
            document.getElementById('asmaPagination').style.display = 'flex';
            
            allAsma = data.data || [];
            filteredAsma = allAsma;
            renderAsmaPage();
        })
        .catch(function() {
            document.getElementById('asmaLoader').innerHTML = '<div class="alert alert-danger rounded-4 border-0 p-4 text-center">تعذر تحميل أسماء الله الحسنى. يرجى التأكد من اتصالك بالإنترنت.</div>';
        });

    document.getElementById('asmaSearch').addEventListener('input', function(e) {
        var q = e.target.value.trim().toLowerCase();
        filteredAsma = allAsma.filter(function(item) {
            return item.name.includes(q) || 
                   item.transliteration.toLowerCase().includes(q) ||
                   item.en.meaning.toLowerCase().includes(q) ||
                   String(item.number) === q;
        });
        asmaPage = 1;
        renderAsmaPage();
    });
});

function renderAsmaPage() {
    var grid = document.getElementById('asmaGrid');
    var noRes = document.getElementById('noAsmaResults');
    var pag = document.getElementById('asmaPagination');
    grid.innerHTML = '';

    if (filteredAsma.length === 0) {
        noRes.classList.remove('d-none');
        pag.style.display = 'none';
        return;
    }
    noRes.classList.add('d-none');

    var totalPages = Math.ceil(filteredAsma.length / asmaPageSize);
    var start = (asmaPage - 1) * asmaPageSize;
    var end = Math.min(start + asmaPageSize, filteredAsma.length);
    var pageItems = filteredAsma.slice(start, end);

    pageItems.forEach(function(item) {
        var col = document.createElement('div');
        col.className = 'col-xl-2 col-lg-3 col-md-4 col-6';
        col.innerHTML = 
            '<div class="card h-100 rounded-4 text-center p-4 asma-card position-relative" onclick="showAsmaModal(\'' + escapeHtml(item.name) + '\', \'' + escapeHtml(item.transliteration) + '\', \'' + escapeHtml(item.en.meaning) + '\')">' +
                '<span class="asma-number">' + item.number + '</span>' +
                '<h3 class="fw-bold mb-0 text-primary mt-3" style="font-family: \'Amiri\', serif; font-size: 1.8rem;">' + item.name + '</h3>' +
                '<small class="text-muted d-block mt-2" dir="ltr" style="font-size:0.8rem;">' + item.transliteration + '</small>' +
            '</div>';
        grid.appendChild(col);
    });

    if (totalPages > 1) {
        pag.style.display = 'flex';
        document.getElementById('pageIndicator').textContent = 'صفحة ' + asmaPage + ' من ' + totalPages;
        document.getElementById('prevPageBtn').disabled = asmaPage <= 1;
        document.getElementById('nextPageBtn').disabled = asmaPage >= totalPages;
    } else {
        pag.style.display = 'none';
    }
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function changePage(delta) {
    asmaPage += delta;
    renderAsmaPage();
    window.scrollTo({ top: 300, behavior: 'smooth' });
}

function showAsmaModal(name, translit, meaning) {
    document.getElementById('modalArName').textContent = name;
    document.getElementById('modalEnName').textContent = translit;
    document.getElementById('modalMeaning').textContent = meaning;
    asmaModal.show();
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/'/g, "\\'").replace(/"/g, '&quot;');
}
</script>
