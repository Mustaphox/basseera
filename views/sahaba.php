<?php $page_title = 'الصحابة'; ?>

<section class="py-5 bg-light-primary border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary mb-3">سير الصحابة</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            مِنَ الْمُؤْمِنِينَ رِجَالٌ صَدَقُوا مَا عَاهَدُوا اللَّهَ عَلَيْهِ
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        
        <!-- Search -->
        <div class="row mb-5 justify-content-center">
            <div class="col-lg-6">
                <div class="position-relative">
                    <i data-lucide="search" class="position-absolute top-50 translate-middle-y text-muted" style="right: 15px;"></i>
                    <input type="text" id="sahabaSearch" class="form-control form-control-lg rounded-pill pe-5" placeholder="ابحث عن صحابي...">
                </div>
            </div>
        </div>

        <div class="row g-4" id="sahabaGrid">
            <?php 
            $sahaba = [
                [
                    'name' => 'أبو بكر الصديق', 
                    'title' => 'أول الخلفاء الراشدين', 
                    'desc' => 'أول من آمن برسول الله من الرجال وصاحبه في الهجرة.',
                    'full_story' => 'أبو بكر الصديق (عبد الله بن أبي قحافة)، أول الخلفاء الراشدين، وأول من آمن بالنبي ﷺ من الرجال. لقبه النبي بالصديق لتصديقه له في حادثة الإسراء والمعراج. صاحبه في الهجرة إلى المدينة ومكث معه في الغار.<br><br><strong>المرجع:</strong> قوله تعالى: ﴿إِلَّا تَنْصُرُوهُ فَقَدْ نَصَرَهُ اللَّهُ إِذْ أَخْرَجَهُ الَّذِينَ كَفَرُوا ثَانِيَ اثْنَيْنِ إِذْ هُمَا فِي الْغَارِ﴾ [التوبة: 40].<br><br>قاد حروب الردة بعد وفاة النبي ﷺ وحافظ على وحدة الأمة الإسلامية. توفي سنة 13 هـ ودفن بجوار النبي ﷺ.'
                ],
                [
                    'name' => 'عمر بن الخطاب', 
                    'title' => 'الفاروق', 
                    'desc' => 'ثاني الخلفاء الراشدين، فرق الله به بين الحق والباطل.',
                    'full_story' => 'عمر بن الخطاب (أبو حفص)، ثاني الخلفاء الراشدين. لقبه النبي ﷺ بالفاروق لأن الله فرق به بين الحق والباطل. أعز الله به الإسلام حين أسلم. في عهده اتسعت رقعة الدولة الإسلامية وفتحت الشام والعراق ومصر والقدس. وهو أول من أسس الدواوين واعتمد التاريخ الهجري.<br><br><strong>المرجع:</strong> عن ابن عمر رضي الله عنهما أن رسول الله ﷺ قال: "اللهم أعز الإسلام بأحب هذين الرجلين إليك: بأبي جهل، أو بعمر بن الخطاب" (رواه الترمذي).<br><br>استشهد سنة 23 هـ طعناً على يد أبي لؤلؤة المجوسي وهو يصلي الفجر.'
                ],
                [
                    'name' => 'عثمان بن عفان', 
                    'title' => 'ذو النورين', 
                    'desc' => 'ثالث الخلفاء الراشدين، تستحي منه الملائكة.',
                    'full_story' => 'عثمان بن عفان، ثالث الخلفاء الراشدين. لقب بذي النورين لزواجه من ابنتي النبي ﷺ: رقية ثم أم كلثوم. كان كريماً حييّاً، جهز جيش العسرة من ماله الخاص واشترى بئر رومة وجعلها للمسلمين. في عهده جُمع القرآن الكريم في مصحف واحد (مصحف عثمان) واتسعت الفتوحات البحرية.<br><br><strong>المرجع:</strong> قال النبي ﷺ: "ألا أستحيي من رجل تستحيي منه الملائكة" (رواه مسلم).<br><br>استشهد مظلوماً في داره سنة 35 هـ.'
                ],
                [
                    'name' => 'علي بن أبي طالب', 
                    'title' => 'أبو تراب', 
                    'desc' => 'رابع الخلفاء الراشدين وابن عم رسول الله.',
                    'full_story' => 'علي بن أبي طالب، رابع الخلفاء الراشدين، وابن عم النبي ﷺ وزوج ابنته فاطمة الزهراء. أول من آمن من الصبيان. اشتهر بالشجاعة والعلم والفصاحة. نام في فراش النبي ﷺ ليلة الهجرة لرد الأمانات لأهل مكة. برز في معارك بدر وخيبر والخندق.<br><br><strong>المرجع:</strong> قال له النبي ﷺ: "أنت مني بمنزلة هارون من موسى، إلا أنه لا نبي بعدي" (متفق عليه).<br><br>استشهد سنة 40 هـ على يد عبد الرحمن بن ملجم الخارجي.'
                ],
                [
                    'name' => 'خالد بن الوليد', 
                    'title' => 'سيف الله المسلول', 
                    'desc' => 'القائد العسكري الفذ الذي لم يهزم في معركة.',
                    'full_story' => 'خالد بن الوليد، سيف الله المسلول. أسلم قبل فتح مكة. قائد عسكري عبقري فذ لم يُهزم في معركة قط، لا في الجاهلية ولا في الإسلام. أنقذ جيش المسلمين في غزوة مؤتة، وقاد معركة اليرموك الفاصلة، وحروب الردة، وفتوحات الشام والعراق.<br><br><strong>المرجع:</strong> قال النبي ﷺ عنه يوم مؤتة: "...حتى أخذ الراية سيف من سيوف الله، حتى فتح الله عليهم" (رواه البخاري).<br><br>توفي على فراشه في حمص سنة 21 هـ، وقال مقولته الشهيرة: "فلا نامت أعين الجبناء".'
                ],
                [
                    'name' => 'أبو عبيدة بن الجراح', 
                    'title' => 'أمين هذه الأمة', 
                    'desc' => 'أحد العشرة المبشرين بالجنة وقائد جيوش الشام.',
                    'full_story' => 'أبو عبيدة عامر بن عبد الله بن الجراح، أحد العشرة المبشرين بالجنة. عُرف بالأمانة والزهد والتواضع. قاد جيوش المسلمين في فتوحات الشام بعد خالد بن الوليد، وكان قائد معركة اليرموك بعد عزل خالد.<br><br><strong>المرجع:</strong> قال النبي ﷺ: "إن لكل أمة أميناً، وإن أميننا أيتها الأمة أبو عبيدة بن الجراح" (متفق عليه).<br><br>توفي في طاعون عمواس سنة 18 هـ.'
                ],
                [
                    'name' => 'سعد بن أبي وقاص', 
                    'title' => 'أول من رمى بسهم في الإسلام', 
                    'desc' => 'خال النبي وأحد العشرة المبشرين بالجنة.',
                    'full_story' => 'سعد بن أبي وقاص، أحد العشرة المبشرين بالجنة، وهو من أخوال النبي ﷺ من بني زهرة. أول من رمى بسهم في سبيل الله. اشتهر بإجابة الدعوة لقول النبي ﷺ: "اللهم سدد رميته، وأجب دعوته". قاد جيش المسلمين في معركة القادسية العظيمة وفتح المدائن وبنى مدينة الكوفة.<br><br><strong>المرجع:</strong> قال النبي ﷺ: "ارم سعد فداك أبي وأمي" (متفق عليه).<br><br>توفي سنة 55 هـ بالعقيق ودفن بالبقيع.'
                ],
                [
                    'name' => 'الزبير بن العوام', 
                    'title' => 'حواري رسول الله', 
                    'desc' => 'ابن عمة النبي وأول من سل سيفاً في الإسلام.',
                    'full_story' => 'الزبير بن العوام، حواري رسول الله ﷺ (أي ناصره المخلص)، وابن عمته صفية بنت عبد المطلب. أحد العشرة المبشرين بالجنة. أول من سل سيفاً في سبيل الله دفاعاً عن النبي ﷺ في مكة. شارك في جميع الغزوات مع النبي ﷺ، وكان بطل معركة اليرموك وفتح مصر.<br><br><strong>المرجع:</strong> قال النبي ﷺ: "إن لكل نبي حوارياً، وحواريي الزبير" (متفق عليه).<br><br>استشهد يوم الجمل سنة 36 هـ.'
                ]
            ];
            
            foreach($sahaba as $index => $s):
            ?>
            <div class="col-xl-3 col-lg-4 col-md-6 sahaba-item">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center hover-lift" data-aos="fade-up" data-aos-delay="<?= ($index % 4) * 50 ?>">
                    <div class="card-body p-4 p-md-5 d-flex flex-column">
                        <div class="bg-light-primary text-primary mx-auto rounded-circle d-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i data-lucide="user" width="40" height="40"></i>
                        </div>
                        <h4 class="fw-bold mb-2 sahaba-name"><?= $s['name'] ?></h4>
                        <h6 class="text-primary mb-3"><?= $s['title'] ?></h6>
                        <p class="text-muted small mb-4 flex-grow-1"><?= $s['desc'] ?></p>
                        
                        <button class="btn btn-outline-primary rounded-pill w-100" onclick="showSahabaModal(`<?= htmlspecialchars($s['name']) ?>`, `<?= htmlspecialchars($s['title']) ?>`, `<?= htmlspecialchars($s['full_story']) ?>`)">
                            اقرأ سيرته
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
    </div>
</section>

<!-- Sahaba Modal -->
<div class="modal fade" id="sahabaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <button type="button" class="btn-close m-0" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 p-md-5 text-center">
                <div class="bg-light-primary text-primary mx-auto rounded-circle d-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                    <i data-lucide="user" width="50" height="50"></i>
                </div>
                <h2 class="fw-bold mb-2" id="modalName">الاسم</h2>
                <h5 class="text-primary mb-4" id="modalTitle">اللقب</h5>
                
                <div class="text-start bg-light p-4 rounded-4 lh-lg text-secondary" dir="rtl">
                    <div id="modalDesc" class="mb-0 fs-5">هنا سيكتب التفاصيل الكاملة لحياة الصحابي الجليل والمواقف البارزة في حياته...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}
</style>

<script>
function showSahabaModal(name, title, desc) {
    document.getElementById('modalName').textContent = name;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDesc').innerHTML = desc;
    
    const modalEl = document.getElementById('sahabaModal');
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}

document.getElementById('sahabaSearch').addEventListener('input', function(e) {
    const term = e.target.value.toLowerCase();
    const items = document.querySelectorAll('.sahaba-item');
    
    items.forEach(item => {
        const name = item.querySelector('.sahaba-name').textContent.toLowerCase();
        if(name.includes(term)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>
