<?php $page_title = 'أسماء الله الحسنى'; ?>

<section class="py-5 bg-light-primary border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary mb-3">أسماء الله الحسنى</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            وَلِلَّهِ الْأَسْمَاءُ الْحُسْنَىٰ فَادْعُوهُ بِهَا
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        
        <!-- Loader -->
        <div id="asmaLoader" class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-3 text-muted">جاري تحميل الأسماء الحسنى...</p>
        </div>

        <!-- Grid -->
        <div class="row g-3 g-md-4" id="asmaGrid" style="display: none;">
            <!-- Rendered via JS -->
        </div>
        
    </div>
</section>

<!-- Modal for Meaning -->
<div class="modal fade" id="asmaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <button type="button" class="btn-close m-0" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 p-md-5 text-center">
                <div class="bg-primary text-white mx-auto rounded-circle d-flex align-items-center justify-content-center mb-4 fs-1 fw-bold asma-modal-icon shadow" style="width: 120px; height: 120px; font-family: 'Amiri', 'Cairo', serif;">
                    <!-- Name -->
                </div>
                <h4 class="text-primary mb-4" id="modalEnName" dir="ltr">--</h4>
                <div class="bg-light-primary p-4 rounded-4 text-dark fs-5 lh-lg" id="modalMeaning">
                    --
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.asma-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    background: linear-gradient(135deg, #ffffff 0%, #f9f9f9 100%);
    border: 1px solid var(--border-color);
}
.asma-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 15px 30px rgba(255,138,0,0.15) !important;
    border-color: var(--bs-primary);
}
.asma-number {
    font-size: 0.8rem;
    color: var(--text-secondary);
    position: absolute;
    top: 10px;
    right: 15px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementById('asmaGrid');
    const loader = document.getElementById('asmaLoader');
    const modal = new bootstrap.Modal(document.getElementById('asmaModal'));
    
    fetch('https://api.aladhan.com/v1/asmaAlHusna')
        .then(r => r.json())
        .then(data => {
            loader.style.display = 'none';
            grid.style.display = 'flex';
            
            data.data.forEach((item, index) => {
                const delay = (index % 10) * 50;
                
                const col = document.createElement('div');
                col.className = 'col-xl-2 col-lg-3 col-md-4 col-6';
                col.setAttribute('data-aos', 'zoom-in');
                col.setAttribute('data-aos-delay', delay);
                
                col.innerHTML = `
                    <div class="card h-100 rounded-4 text-center p-4 asma-card position-relative" onclick="showAsmaModal('${item.name}', '${item.transliteration}', '${item.en.meaning}')">
                        <span class="asma-number">${item.number}</span>
                        <h3 class="fw-bold mb-0 text-primary mt-3" style="font-family: 'Amiri', 'Cairo', serif;">${item.name}</h3>
                    </div>
                `;
                
                grid.appendChild(col);
            });
        });
});

function showAsmaModal(name, enName, meaning) {
    document.querySelector('.asma-modal-icon').textContent = name;
    document.getElementById('modalEnName').textContent = enName;
    document.getElementById('modalMeaning').textContent = meaning; // API returns english meaning, to make it arabic we'd need another source or translation. Since the API provides EN, we display EN for now. If you need Arabic meanings, a local database is required.
    
    // Add Arabic translation mapping if needed, otherwise just show the english meaning
    const modalInstance = bootstrap.Modal.getInstance(document.getElementById('asmaModal'));
    modalInstance.show();
}
</script>
