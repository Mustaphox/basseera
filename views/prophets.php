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
                [
                    'name' => 'آدم عليه السلام', 
                    'title' => 'أبو البشر', 
                    'desc' => 'خلقه الله بيده، وأسجد له ملائكته، وعلمه أسماء كل شيء.', 
                    'image' => 'https://images.unsplash.com/photo-1518599904199-0ca897819ddb?w=600&q=80', 
                    'align' => 'right',
                    'full_story' => 'خلق الله تعالى آدم بيده من طين، ونفخ فيه من روحه، وأمر الملائكة بالسجود له تكريماً. أسكنه الله وزوجته حواء الجنة، ولكن وسوس لهما الشيطان فأكلا من الشجرة المحرمة. أهبطهما الله إلى الأرض لتبدأ رحلة البشرية والابتلاء في هذه الدنيا، وتاب الله عليهما.<br><br><strong>المرجع:</strong> قوله تعالى: ﴿وَإِذْ قَالَ رَبُّكَ لِلْمَلَائِكَةِ إِنِّي جَاعِلٌ فِي الْأَرْضِ خَلِيفَةً﴾ [البقرة: 30]، وقوله: ﴿فَتَلَقَّىٰ آدَمُ مِن رَّبِّهِ كَلِمَاتٍ فَتَابَ عَلَيْهِ ۚ إِنَّهُ هُوَ التَّوَّابُ الرَّحِيمُ﴾ [البقرة: 37].'
                ],
                [
                    'name' => 'نوح عليه السلام', 
                    'title' => 'أول رسل الله إلى الأرض', 
                    'desc' => 'لبث في قومه ألف سنة إلا خمسين عاماً يدعوهم إلى التوحيد.', 
                    'image' => 'https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?w=600&q=80', 
                    'align' => 'left',
                    'full_story' => 'أرسل الله نوحاً إلى قومه فدعاهم ألف سنة إلا خمسين عاماً ولم يؤمن معه إلا قليل. سخر منه قومه وآذوه، فأوحى الله إليه بصنع السفينة لينجو هو والمؤمنون من الطوفان العظيم الذي أغرق الكافرين، بمن فيهم ابنه الذي رفض الركوب واعتصم بجبل ظناً أنه سيعصمه من الماء.<br><br><strong>المرجع:</strong> قوله تعالى: ﴿وَلَقَدْ أَرْسَلْنَا نُوحًا إِلَىٰ قَوْمِهِ فَلَبِثَ فِيهِمْ أَلْفَ سَنَةٍ إِلَّا خَمْسِينَ عَامًا فَأَخَذَهُمُ الطُّوفَانُ وَهُمْ ظَالِمُونَ﴾ [العنكبوت: 14].'
                ],
                [
                    'name' => 'إبراهيم عليه السلام', 
                    'title' => 'خليل الرحمن', 
                    'desc' => 'أبو الأنبياء، بنى الكعبة المشرفة مع ابنه إسماعيل.', 
                    'image' => 'https://images.unsplash.com/photo-1594901844696-6e5a40b377f0?w=600&q=80', 
                    'align' => 'right',
                    'full_story' => 'خليل الرحمن، أبو الأنبياء. حطم الأصنام وتحدى الملك النمرود. ألقاه قومه في نار عظيمة فجعلها الله برداً وسلاماً عليه. ابتلاه الله بذبح ابنه إسماعيل فامتثل للأمر بصدق، ففداه الله بكبش عظيم. بنى الكعبة المشرفة مع ابنه إسماعيل ودعا الناس للحج.<br><br><strong>المرجع:</strong> قوله تعالى: ﴿قُلْنَا يَا نَارُ كُونِي بَرْدًا وَسَلَامًا عَلَىٰ إِبْرَاهِيمَ﴾ [الأنبياء: 69]، وقوله: ﴿وَإِذْ يَرْفَعُ إِبْرَاهِيمُ الْقَوَاعِدَ مِنَ الْبَيْتِ وَإِسْمَاعِيلُ رَبَّنَا تَقَبَّلْ مِنَّا ۖ إِنَّكَ أَنتَ السَّمِيعُ الْعَلِيمُ﴾ [البقرة: 127].'
                ],
                [
                    'name' => 'موسى عليه السلام', 
                    'title' => 'كليم الله', 
                    'desc' => 'أرسله الله إلى فرعون، وأنزل عليه التوراة.', 
                    'image' => 'https://images.unsplash.com/photo-1601058269785-5a1e2f3d790d?w=600&q=80', 
                    'align' => 'left',
                    'full_story' => 'كليم الله الذي كلمه الله تكليماً. أرسله الله إلى فرعون مصر لدعوتهم إلى التوحيد ولإنقاذ بني إسرائيل من الاستعباد. أيده الله بتسع آيات بينات منها معجزة العصا واليد البيضاء. شق الله له البحر لينجو وقومه، وأغرق فرعون وجنوده. أنزل الله عليه التوراة في جبل الطور.<br><br><strong>المرجع:</strong> قوله تعالى: ﴿وَكَلَّمَ اللَّهُ مُوسَىٰ تَكْلِيمًا﴾ [النساء: 164]، وقوله: ﴿فَأَوْحَيْنَا إِلَىٰ مُوسَىٰ أَنِ اضْرِب بِّعَصَاكَ الْبَحْرَ ۖ فَانفَلَقَ فَكَانَ كُلُّ فِرْقٍ كَالطَّوْدِ الْعَظِيمِ﴾ [الشعراء: 63].'
                ],
                [
                    'name' => 'عيسى عليه السلام', 
                    'title' => 'كلمة الله وروحه', 
                    'desc' => 'ولد من مريم العذراء بمعجزة، وأنزل عليه الإنجيل.', 
                    'image' => 'https://images.unsplash.com/photo-1560064560-64205f0612bb?w=600&q=80', 
                    'align' => 'right',
                    'full_story' => 'عيسى بن مريم عليه السلام، ولد بمعجزة إلهية من السيدة مريم العذراء بلا أب. تكلم في المهد صبياً، وأيده الله بمعجزات عظيمة كإبراء الأكمه والأبرص وإحياء الموتى بإذن الله. أنزل الله عليه الإنجيل. تآمروا لقتله لكن الله نجاه ولم يُقتل ولم يُصلب بل رفعه الله إليه، وسيعود في آخر الزمان.<br><br><strong>المرجع:</strong> قوله تعالى: ﴿إِذْ قَالَتِ الْمَلَائِكَةُ يَا مَرْيَمُ إِنَّ اللَّهَ يُبَشِّرُكِ بِكَلِمَةٍ مِّنْهُ اسْمُهُ الْمَسِيحُ عِيسَى ابْنُ مَرْيَمَ﴾ [آل عمران: 45]، وقوله: ﴿وَمَا قَتَلُوهُ وَمَا صَلَبُوهُ وَلَٰكِن شُبِّهَ لَهُمْ﴾ [النساء: 157].'
                ],
                [
                    'name' => 'محمد ﷺ', 
                    'title' => 'خاتم الأنبياء والمرسلين', 
                    'desc' => 'أرسله الله رحمة للعالمين وأنزل عليه القرآن الكريم.', 
                    'image' => 'https://images.unsplash.com/photo-1565552643806-0563fbcd61c5?w=600&q=80', 
                    'align' => 'left',
                    'full_story' => 'محمد بن عبد الله ﷺ، خاتم الأنبياء والمرسلين، أُرسل للناس كافة رحمة للعالمين. نزل عليه الوحي بالقرآن الكريم بواسطة الملاك جبريل في غار حراء. لاقى الأذى من مشركي قريش فصبر، ثم هاجر إلى المدينة المنورة حيث أسس الدولة الإسلامية. أتم الله به الدين وأتم عليه النعمة، ومات بعد أن بلغ الرسالة وأدى الأمانة.<br><br><strong>المرجع:</strong> قوله تعالى: ﴿مَّا كَانَ مُحَمَّدٌ أَبَا أَحَدٍ مِّن رِّجَالِكُمْ وَلَٰكِن رَّسُولَ اللَّهِ وَخَاتَمَ النَّبِيِّينَ﴾ [الأحزاب: 40]، وقوله: ﴿وَمَا أَرْسَلْنَاكَ إِلَّا رَحْمَةً لِّلْعَالَمِينَ﴾ [الأنبياء: 107].'
                ],
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
                                <button type="button" class="btn btn-outline-primary rounded-pill px-4" onclick="showProphetModal(`<?= htmlspecialchars($prophet['name']) ?>`, `<?= htmlspecialchars($prophet['title']) ?>`, `<?= htmlspecialchars($prophet['full_story']) ?>`, `<?= htmlspecialchars($prophet['image']) ?>`)">اقرأ القصة كاملة</button>
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
                                <button type="button" class="btn btn-outline-primary rounded-pill px-4" onclick="showProphetModal(`<?= htmlspecialchars($prophet['name']) ?>`, `<?= htmlspecialchars($prophet['title']) ?>`, `<?= htmlspecialchars($prophet['full_story']) ?>`, `<?= htmlspecialchars($prophet['image']) ?>`)">اقرأ القصة كاملة</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            
        </div>
        
    </div>
</section>

<!-- Prophet Modal -->
<div class="modal fade" id="prophetModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow overflow-hidden">
            <div class="position-relative" style="height: 200px;">
                <img id="modalImage" src="" class="w-100 h-100" style="object-fit: cover; filter: brightness(0.7);" alt="Prophet Image">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-4 z-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 p-md-5 text-center mt-n5 position-relative z-2">
                <div class="bg-white rounded-4 shadow-sm p-4 text-start mb-0" dir="rtl">
                    <h2 class="fw-bold mb-2 text-primary" id="modalProphetName">الاسم</h2>
                    <h5 class="text-muted mb-4 border-bottom pb-3" id="modalProphetTitle">اللقب</h5>
                    <div id="modalProphetStory" class="lh-lg text-secondary fs-5">هنا ستكتب القصة الكاملة...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}
.mt-n5 {
    margin-top: -3rem !important;
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

<script>
function showProphetModal(name, title, story, image) {
    document.getElementById('modalProphetName').textContent = name;
    document.getElementById('modalProphetTitle').textContent = title;
    document.getElementById('modalProphetStory').innerHTML = story;
    document.getElementById('modalImage').src = image;
    
    const modalEl = document.getElementById('prophetModal');
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}
</script>
