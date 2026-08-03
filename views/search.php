<?php $page_title = 'البحث المتقدم'; 
$q = isset($_GET['q']) ? e($_GET['q']) : '';
?>

<section class="py-5 bg-light-primary border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary mb-4">البحث المتقدم</h1>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="<?= BASE_URL ?>search" method="GET" class="position-relative shadow-sm rounded-pill">
                    <button type="submit" class="position-absolute top-50 translate-middle-y border-0 bg-transparent text-primary" style="left: 20px;">
                        <i data-lucide="search"></i>
                    </button>
                    <input type="text" name="q" id="searchInput" value="<?= $q ?>" class="form-control form-control-lg rounded-pill border-0 bg-white" placeholder="ابحث في القرآن الكريم..." style="padding: 20px 20px 20px 60px;">
                </form>
                <div class="d-flex gap-2 justify-content-center mt-3 flex-wrap">
                    <span class="badge bg-white text-primary border border-primary-subtle px-3 py-2 rounded-pill search-suggestion" role="button">البقرة</span>
                    <span class="badge bg-white text-primary border border-primary-subtle px-3 py-2 rounded-pill search-suggestion" role="button">الإخلاص</span>
                    <span class="badge bg-white text-primary border border-primary-subtle px-3 py-2 rounded-pill search-suggestion" role="button">الرحمن</span>
                    <span class="badge bg-white text-primary border border-primary-subtle px-3 py-2 rounded-pill search-suggestion" role="button">يس</span>
                    <span class="badge bg-white text-primary border border-primary-subtle px-3 py-2 rounded-pill search-suggestion" role="button">الكهف</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">

        <!-- Loading State -->
        <div id="searchLoader" class="text-center py-5 d-none">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-3 text-muted">جاري البحث في القرآن الكريم...</p>
        </div>

        <!-- Results -->
        <div id="searchResults">
            <?php if($q): ?>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold">نتائج البحث عن: <span class="text-primary">"<?= $q ?>"</span></h4>
                <span class="badge bg-light text-dark px-3 py-2 rounded-pill" id="resultsCount">...</span>
            </div>
            <div id="ayahResultsContainer"></div>
            <?php else: ?>
            <div class="text-center py-5" data-aos="fade-up">
                <div class="mb-4" style="font-size: 5rem;">🔍</div>
                <h3 class="text-muted fw-bold mb-3">ابدأ البحث في القرآن الكريم</h3>
                <p class="text-secondary">اكتب اسم سورة أو جزءاً من آية للبحث فيها</p>
            </div>
            <?php endif; ?>
        </div>
        
    </div>
</section>

<style>
.ayah-result-card {
    border-right: 4px solid var(--bs-primary);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.ayah-result-card:hover {
    transform: translateX(-4px);
    box-shadow: 0 8px 20px rgba(255,138,0,0.15) !important;
}
.search-suggestion { cursor: pointer; transition: all 0.2s; }
.search-suggestion:hover { background: var(--bs-primary) !important; color: white !important; }
.quran-match-text { font-family: 'Amiri', 'Cairo', serif; font-size: 1.4rem; line-height: 2; }
.quran-match-text mark { background: rgba(255,138,0,0.2); color: var(--bs-primary); padding: 0 4px; border-radius: 4px; }
</style>

<script>
const searchInput = document.getElementById('searchInput');
const loader = document.getElementById('searchLoader');
const resultsDiv = document.getElementById('ayahResultsContainer');
const countBadge = document.getElementById('resultsCount');

<?php if($q): ?>
// Auto-run search if query exists
document.addEventListener('DOMContentLoaded', () => {
    runSearch("<?= addslashes($q) ?>");
});
<?php endif; ?>

// Suggestion chips
document.querySelectorAll('.search-suggestion').forEach(chip => {
    chip.addEventListener('click', () => {
        searchInput.value = chip.textContent.trim();
        searchInput.closest('form').submit();
    });
});

function runSearch(query) {
    loader.classList.remove('d-none');
    if(resultsDiv) resultsDiv.innerHTML = '';
    if(countBadge) countBadge.textContent = '...';

    fetch(`<?= BASE_URL ?>api/quran_search.php?q=\${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => {
            loader.classList.add('d-none');

            if (!data.success || !data.data || !data.data.matches || data.data.matches.length === 0) {
                resultsDiv.innerHTML = `
                    <div class="text-center py-5">
                        <div class="mb-4" style="font-size: 4rem;">😔</div>
                        <h4 class="text-muted">لا توجد نتائج مطابقة</h4>
                        <p class="text-secondary">جرب البحث بكلمات مختلفة أو تأكد من الإملاء</p>
                    </div>`;
                if(countBadge) countBadge.textContent = '0 نتيجة';
                return;
            }

            const matches = data.data.matches;
            if(countBadge) countBadge.textContent = `\${matches.length} نتيجة`;
            
            renderResults(matches, query);
        })
        .catch(() => {
            loader.classList.add('d-none');
            resultsDiv.innerHTML = `<div class="alert alert-danger rounded-4 border-0">خطأ في الاتصال. يرجى التأكد من اتصالك بالإنترنت والمحاولة مجدداً.</div>`;
        });
}

function renderResults(matches, query) {
    resultsDiv.innerHTML = '';
    matches.forEach((match, i) => {
        // Highlight the search query in the text
        const text = match.text.replace(new RegExp(`(\${query})`, 'gi'), '<mark>$1</mark>');
        const surahName = match.surah ? match.surah.name : '--';
        const surahNum  = match.surah ? match.surah.number : '';
        const ayahNum   = match.numberInSurah;

        const card = `
            <div class="card border-0 shadow-sm rounded-4 mb-4 p-4 ayah-result-card" data-aos="fade-up" data-aos-delay="\${Math.min(i * 50, 300)}">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge bg-light-primary text-primary fw-bold me-2 px-3 py-2 rounded-pill">\${surahName}</span>
                        <span class="badge bg-light text-muted px-3 py-2 rounded-pill">الآية \${ayahNum}</span>
                    </div>
                    <a href="<?= BASE_URL ?>quran/surah?id=\${surahNum}#ayah-\${ayahNum - 1}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        <i data-lucide="book-open" style="width:14px;height:14px;" class="me-1"></i> اذهب للآية
                    </a>
                </div>
                <p class="quran-match-text mb-0">\${text}</p>
            </div>
        `;
        resultsDiv.insertAdjacentHTML('beforeend', card);
    });
    if (typeof AOS !== 'undefined') AOS.refresh();
    if (typeof lucide !== 'undefined') lucide.createIcons();
}
</script>
