<?php $page_title = 'قصص الأنبياء'; ?>

<section class="py-5 bg-light-primary border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary mb-3">قصص الأنبياء</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            لَقَدْ كَانَ فِي قَصَصِهِمْ عِبْرَةٌ لِّأُولِي الْأَلْبَابِ
        </p>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        
        <div class="timeline position-relative py-5">
            <!-- Line -->
            <div class="position-absolute h-100 bg-light-primary" style="width: 4px; left: 50%; transform: translateX(-50%); top: 0;"></div>
            
            <?php 
            $prophets = [
                ['name' => 'آدم عليه السلام', 'title' => 'أبو البشر', 'desc' => 'خلقه الله بيده، وأسجد له ملائكته، وعلمه أسماء كل شيء.', 'image' => 'https://images.unsplash.com/photo-1518599904199-0ca897819ddb?w=600&q=80', 'align' => 'right'],
                ['name' => 'نوح عليه السلام', 'title' => 'أول رسل الله إلى الأرض', 'desc' => 'لبث في قومه ألف سنة إلا خمسين عاماً يدعوهم إلى التوحيد.', 'image' => 'https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?w=600&q=80', 'align' => 'left'],
                ['name' => 'إبراهيم عليه السلام', 'title' => 'خليل الرحمن', 'desc' => 'أبو الأنبياء، بنى الكعبة المشرفة مع ابنه إسماعيل.', 'image' => 'https://images.unsplash.com/photo-1594901844696-6e5a40b377f0?w=600&q=80', 'align' => 'right'],
                ['name' => 'موسى عليه السلام', 'title' => 'كليم الله', 'desc' => 'أرسله الله إلى فرعون، وأنزل عليه التوراة.', 'image' => 'https://images.unsplash.com/photo-1601058269785-5a1e2f3d790d?w=600&q=80', 'align' => 'left'],
                ['name' => 'عيسى عليه السلام', 'title' => 'كلمة الله وروحه', 'desc' => 'ولد من مريم العذراء بمعجزة، وأنزل عليه الإنجيل.', 'image' => 'https://images.unsplash.com/photo-1560064560-64205f0612bb?w=600&q=80', 'align' => 'right'],
                ['name' => 'محمد ﷺ', 'title' => 'خاتم الأنبياء والمرسلين', 'desc' => 'أرسله الله رحمة للعالمين وأنزل عليه القرآن الكريم.', 'image' => 'https://images.unsplash.com/photo-1565552643806-0563fbcd61c5?w=600&q=80', 'align' => 'left'],
            ];
            
            foreach($prophets as $index => $prophet): 
                $isRight = $prophet['align'] === 'right';
            ?>
            <div class="row align-items-center mb-5" data-aos="<?= $isRight ? 'fade-left' : 'fade-right' ?>">
                <?php if($isRight): ?>
                    <div class="col-md-5 text-end pe-md-5">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-lift">
                            <img src="<?= $prophet['image'] ?>" class="card-img-top" alt="<?= $prophet['name'] ?>" style="height: 250px; object-fit: cover; filter: brightness(0.9);">
                            <div class="card-body p-4 text-start" dir="rtl">
                                <h3 class="fw-bold mb-1 text-primary"><?= $prophet['name'] ?></h3>
                                <h5 class="text-muted mb-3"><?= $prophet['title'] ?></h5>
                                <p class="text-secondary mb-4"><?= $prophet['desc'] ?></p>
                                <a href="#" class="btn btn-outline-primary rounded-pill px-4">اقرأ القصة كاملة</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 text-center position-relative">
                        <div class="bg-primary rounded-circle mx-auto border border-4 border-white shadow-sm" style="width: 24px; height: 24px; z-index: 2; position: relative;"></div>
                    </div>
                    <div class="col-md-5"></div>
                <?php else: ?>
                    <div class="col-md-5"></div>
                    <div class="col-md-2 text-center position-relative">
                        <div class="bg-primary rounded-circle mx-auto border border-4 border-white shadow-sm" style="width: 24px; height: 24px; z-index: 2; position: relative;"></div>
                    </div>
                    <div class="col-md-5 text-start ps-md-5">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-lift">
                            <img src="<?= $prophet['image'] ?>" class="card-img-top" alt="<?= $prophet['name'] ?>" style="height: 250px; object-fit: cover; filter: brightness(0.9);">
                            <div class="card-body p-4" dir="rtl">
                                <h3 class="fw-bold mb-1 text-primary"><?= $prophet['name'] ?></h3>
                                <h5 class="text-muted mb-3"><?= $prophet['title'] ?></h5>
                                <p class="text-secondary mb-4"><?= $prophet['desc'] ?></p>
                                <a href="#" class="btn btn-outline-primary rounded-pill px-4">اقرأ القصة كاملة</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            
        </div>
        
    </div>
</section>

<style>
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}

@media (max-width: 767px) {
    .timeline > div.position-absolute {
        left: 20px !important;
    }
    .timeline .row {
        flex-direction: column !important;
    }
    .timeline .col-md-5 {
        width: 100% !important;
        padding-left: 50px !important;
        padding-right: 15px !important;
        text-align: right !important;
    }
    .timeline .col-md-5 .card-body {
        text-align: right !important;
    }
    .timeline .col-md-2 {
        position: absolute;
        left: 8px;
        top: 20px;
        width: auto !important;
    }
}
</style>
