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

// Fallback Mock Data if DB is empty/unavailable
if (empty($hadiths)) {
    $hadiths = [
        (object)[
            'text_arabic' => 'إِنَّمَا الأَعْمَالُ بِالنِّيَّاتِ، وَإِنَّمَا لِكُلِّ امْرِئٍ مَا نَوَى.',
            'narrator' => 'عمر بن الخطاب',
            'reference' => 'صحيح البخاري',
            'grade' => 'صحيح',
            'category_name' => 'أحاديث نبوية'
        ],
        (object)[
            'text_arabic' => 'خَيْرُكُمْ مَنْ تَعَلَّمَ الْقُرْآنَ وَعَلَّمَهُ.',
            'narrator' => 'عثمان بن عفان',
            'reference' => 'صحيح البخاري',
            'grade' => 'صحيح',
            'category_name' => 'أحاديث نبوية'
        ],
        (object)[
            'text_arabic' => 'أَنَا عِنْدَ ظَنِّ عَبْدِي بِي، وَأَنَا مَعَهُ إِذَا ذَكَرَنِي...',
            'narrator' => 'أبو هريرة',
            'reference' => 'متفق عليه',
            'grade' => 'صحيح',
            'category_name' => 'أحاديث قدسية'
        ]
    ];
}
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
            <a href="<?= BASE_URL ?>hadith" class="btn <?= !isset($_GET['category']) ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill px-4">الكل</a>
            <?php foreach($categories as $cat): ?>
                <a href="<?= BASE_URL ?>hadith?category=<?= $cat->id ?>" class="btn <?= isset($_GET['category']) && $_GET['category'] == $cat->id ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill px-4">
                    <?= e($cat->name) ?>
                </a>
            <?php endforeach; ?>
            <?php if(empty($categories)): ?>
                <button class="btn btn-outline-primary rounded-pill px-4">أحاديث نبوية</button>
                <button class="btn btn-outline-primary rounded-pill px-4">أحاديث قدسية</button>
            <?php endif; ?>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php foreach($hadiths as $index => $hadith): ?>
                <div class="card border-0 shadow-sm rounded-4 mb-4" data-aos="fade-up" data-aos-delay="<?= ($index % 5) * 50 ?>">
                    <div class="card-body p-4 p-md-5 relative">
                        <!-- Grade Badge -->
                        <?php if(isset($hadith->grade) && $hadith->grade): ?>
                        <span class="badge bg-light-primary text-primary position-absolute top-0 end-0 m-4 fs-6 px-3 py-2 rounded-pill">
                            <?= e($hadith->grade) ?>
                        </span>
                        <?php endif; ?>
                        
                        <div class="mb-4">
                            <span class="text-muted small">عن <?= e($hadith->narrator) ?> رضي الله عنه قال:</span>
                        </div>
                        
                        <p class="fs-3 fw-bold lh-lg text-primary text-center mb-5" style="font-family: 'Amiri', 'Cairo', serif;">
                            "<?= e($hadith->text_arabic) ?>"
                        </p>
                        
                        <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-top">
                            <div class="text-muted">
                                <i data-lucide="book" class="me-1" style="width:16px;height:16px;"></i> 
                                المرجع: <span class="fw-bold"><?= e($hadith->reference) ?></span>
                            </div>
                            
                            <div class="d-flex gap-2 mt-3 mt-md-0">
                                <button class="icon-btn bg-light text-primary" onclick="copyToClipboard('<?= addslashes($hadith->text_arabic) ?>', this)" title="نسخ الحديث">
                                    <i data-lucide="copy"></i>
                                </button>
                                <button class="icon-btn bg-light text-primary" title="مشاركة">
                                    <i data-lucide="share-2"></i>
                                </button>
                                <button class="icon-btn bg-light text-danger" title="المفضلة">
                                    <i data-lucide="heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
    </div>
</section>

<script>
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
