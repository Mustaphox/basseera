<?php 
$page_title = 'الأحاديث النبوية'; 

// Fetch categories
$categories = [];
try {
    $stmt = $pdo->query("SELECT * FROM categories WHERE type = 'hadith' ORDER BY name ASC");
    if($stmt) $categories = $stmt->fetchAll();
} catch (Exception $e) {}

// Fetch Hadiths (simulate or real)
$hadiths = [];
try {
    $cat_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
    $query = "SELECT h.*, c.name as category_name FROM hadiths h LEFT JOIN categories c ON h.category_id = c.id";
    if ($cat_id > 0) $query .= " WHERE h.category_id = $cat_id";
    $query .= " ORDER BY h.id DESC LIMIT 20";
    
    $stmt = $pdo->query($query);
    if($stmt) $hadiths = $stmt->fetchAll();
} catch (Exception $e) {}

// Removed static mock data to use dynamic API
?>

<section class="py-5 bg-light-primary border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary mb-3">الأحاديث النبوية</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            مكتبة شاملة للأحاديث النبوية الشريفة مع التخريج والحكم
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="position-relative shadow-sm rounded-pill">
                    <i data-lucide="search" class="position-absolute top-50 translate-middle-y text-muted" style="right: 20px;"></i>
                    <input type="text" class="form-control form-control-lg rounded-pill pe-5 border-0 bg-white" placeholder="ابحث في الأحاديث..." style="padding: 15px 50px 15px 20px;">
                </div>
            </div>
        </div>
        
        <!-- Categories -->
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
                <button class="btn btn-primary rounded-pill px-4 filter-book active" data-book="bukhari">صحيح البخاري</button>
                <button class="btn btn-outline-primary rounded-pill px-4 filter-book" data-book="muslim">صحيح مسلم</button>
                <button class="btn btn-outline-primary rounded-pill px-4 filter-book" data-book="tirmidzi">جامع الترمذي</button>
                <button class="btn btn-outline-primary rounded-pill px-4 filter-book" data-book="abudawud">سنن أبي داود</button>
                <button class="btn btn-outline-primary rounded-pill px-4 filter-book" data-book="nasai">سنن النسائي</button>
                <button class="btn btn-outline-primary rounded-pill px-4 filter-book" data-book="ibnumajah">سنن ابن ماجه</button>
            </div>

        <div class="row justify-content-center">
            <div class="col-lg-10" id="hadithContainer">
                <!-- Hadiths will be loaded here dynamically -->
                <div class="text-center py-5" id="hadithLoader">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-3 text-muted">جاري تحميل الأحاديث...</p>
                </div>
            </div>
            
            <div class="col-12 text-center mt-4">
                <button class="btn btn-outline-primary rounded-pill px-5 d-none" id="loadMoreBtn">تحميل المزيد</button>
            </div>
        </div>
        
    </div>
</section>

<script>
let currentPage = 1;
let currentBook = 'bukhari';

function fetchHadiths(page = 1, append = false) {
    const loader = document.getElementById('hadithLoader');
    const container = document.getElementById('hadithContainer');
    const btn = document.getElementById('loadMoreBtn');
    
    if(!append) {
        container.innerHTML = '';
        container.appendChild(loader);
    }
    loader.classList.remove('d-none');
    btn.classList.add('d-none');
    
    fetch(`https://hadis-api-id.vercel.app/hadith/${currentBook}?page=${page}&limit=20`)
        .then(res => res.json())
        .then(data => {
            loader.classList.add('d-none');
            const items = data.items || [];
            
            items.forEach((item, index) => {
                const bookName = document.querySelector(`button[data-book="${currentBook}"]`).textContent;
                const html = `
                <div class="card border-0 shadow-sm rounded-4 mb-4" data-aos="fade-up">
                    <div class="card-body p-4 p-md-5 relative">
                        <span class="badge bg-light-primary text-primary position-absolute top-0 end-0 m-4 fs-6 px-3 py-2 rounded-pill">صحيح</span>
                        <div class="mb-4">
                            <span class="text-muted small">رقم الحديث: ${item.number}</span>
                        </div>
                        <p class="fs-3 fw-bold lh-lg text-primary text-center mb-5" style="font-family: 'Amiri', 'Cairo', serif;">
                            "${item.arab}"
                        </p>
                        <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-top">
                            <div class="text-muted">
                                <i data-lucide="book" class="me-1" style="width:16px;height:16px;"></i> 
                                المرجع: <span class="fw-bold">${bookName}</span>
                            </div>
                            <div class="d-flex gap-2 mt-3 mt-md-0">
                                <button class="icon-btn bg-light text-primary" onclick="copyToClipboard('${item.arab.replace(/'/g, "\\'")}', this)" title="نسخ الحديث">
                                    <i data-lucide="copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;
                container.insertAdjacentHTML('beforeend', html);
            });
            
            if (typeof lucide !== 'undefined') lucide.createIcons();
            
            if (currentPage < data.pagination.totalPages) {
                btn.classList.remove('d-none');
            }
        })
        .catch(err => {
            loader.classList.add('d-none');
            container.insertAdjacentHTML('beforeend', '<p class="text-danger text-center">حدث خطأ أثناء تحميل الأحاديث</p>');
        });
}

document.addEventListener('DOMContentLoaded', () => {
    fetchHadiths();
    
    document.querySelectorAll('.filter-book').forEach(btn => {
        btn.addEventListener('click', (e) => {
            document.querySelectorAll('.filter-book').forEach(b => {
                b.classList.remove('active', 'btn-primary');
                b.classList.add('btn-outline-primary');
            });
            e.target.classList.add('active', 'btn-primary');
            e.target.classList.remove('btn-outline-primary');
            
            currentBook = e.target.dataset.book;
            currentPage = 1;
            fetchHadiths(1, false);
        });
    });
    
    document.getElementById('loadMoreBtn').addEventListener('click', () => {
        currentPage++;
        fetchHadiths(currentPage, true);
    });
});

function copyToClipboard(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const icon = btn.querySelector('i');
        icon.setAttribute('data-lucide', 'check');
        lucide.createIcons();
        setTimeout(() => {
            icon.setAttribute('data-lucide', 'copy');
            lucide.createIcons();
        }, 2000);
    });
}
</script>
