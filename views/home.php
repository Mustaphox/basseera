<?php $page_title = 'الرئيسية'; ?>

<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="hero-bg-pattern"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="zoom-in">
                <div class="mb-4 text-primary">
                    <i data-lucide="moon" width="64" height="64" stroke-width="1.5"></i>
                </div>
                <h1 class="hero-title">مرحبًا بك في بصيرة</h1>
                <p class="hero-subtitle mx-auto" style="max-width: 600px;">
                    منصة إسلامية متكاملة تضم القرآن الكريم، الأحاديث، السيرة النبوية، الأذكار، الأدعية، ومحتوى إسلاميًا موثوقًا.
                </p>
                <div class="hero-actions">
                    <a href="<?= BASE_URL ?>quran" class="btn btn-primary btn-lg rounded-pill px-5">ابدأ الآن</a>
                    <a href="<?= BASE_URL ?>quran?listen=true" class="btn btn-outline-primary btn-lg rounded-pill px-5">
                        <i data-lucide="headphones" class="me-2"></i> استمع للقرآن
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="py-5 bg-light-primary">
    <div class="container py-4">
        <div class="row g-4">
            <?php
            $services = [
                ['title' => 'القرآن الكريم', 'icon' => 'book-open', 'link' => 'quran', 'desc' => 'تلاوة، تفسير، واستماع'],
                ['title' => 'السيرة النبوية', 'icon' => 'history', 'link' => 'seerah', 'desc' => 'قصص من حياة النبي'],
                ['title' => 'الأحاديث', 'icon' => 'message-circle', 'link' => 'hadith', 'desc' => 'الصحاح والسنن'],
                ['title' => 'الأذكار', 'icon' => 'sun', 'link' => 'azkar', 'desc' => 'أذكار الصباح والمساء'],
                ['title' => 'الأدعية', 'icon' => 'heart', 'link' => 'duaa', 'desc' => 'أدعية مأثورة وقرآنية'],
                ['title' => 'مواقيت الصلاة', 'icon' => 'clock', 'link' => 'prayer-times', 'desc' => 'مواقيت دقيقة لمدينتك'],
                ['title' => 'القبلة', 'icon' => 'compass', 'link' => 'qibla', 'desc' => 'اتجاه القبلة بدقة'],
                ['title' => 'قصص الأنبياء', 'icon' => 'users', 'link' => 'prophets', 'desc' => 'سير الأنبياء والرسل']
            ];
            foreach ($services as $index => $service):
            ?>
            <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= $index * 50 ?>">
                <a href="<?= BASE_URL . $service['link'] ?>" class="text-decoration-none">
                    <div class="card service-card h-100 border-0">
                        <div class="card-body">
                            <div class="service-icon mx-auto">
                                <i data-lucide="<?= $service['icon'] ?>" width="32" height="32"></i>
                            </div>
                            <h4 class="card-title h5 mb-2 text-dark"><?= $service['title'] ?></h4>
                            <p class="text-muted mb-0 small"><?= $service['desc'] ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Sections -->
<section class="py-5 my-4">
    <div class="container">
        <div class="row g-4">
            
<?php
require_once __DIR__ . '/../includes/QuranApiService.php';
$quranApi = new QuranApiService();
$randomAyahResp = $quranApi->getRandomAyah();
$randomAyah = $randomAyahResp['success'] ? $randomAyahResp['data'] : ['text' => 'إِنَّ مَعَ الْعُسْرِ يُسْرًا', 'surah' => ['name' => 'الشرح'], 'numberInSurah' => 6];
?>

            <!-- Ayat of the day -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="card h-100 p-4 border-0 shadow-sm" style="background: linear-gradient(135deg, rgba(255,138,0,0.1) 0%, rgba(255,138,0,0) 100%);">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-btn bg-white text-primary me-3 shadow-sm" style="cursor:default;">
                            <i data-lucide="book-open"></i>
                        </div>
                        <h3 class="h4 mb-0">آية اليوم</h3>
                    </div>
                    <p class="quran-text fs-3 mb-4 text-primary" style="font-family: 'Amiri', serif; line-height: 1.8;">"<?= $randomAyah['text'] ?>"</p>
                    <p class="text-muted text-start mb-0"><?= $randomAyah['surah']['name'] ?> - الآية <?= $randomAyah['numberInSurah'] ?></p>
                </div>
            </div>

            <!-- Continue Reading (Injected via JS) -->
            <div class="col-lg-12 mt-4 d-none" id="continueReadingSection" data-aos="fade-up">
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-primary text-white position-relative overflow-hidden">
                    <i data-lucide="headphones" class="position-absolute opacity-25" style="width:150px; height:150px; left:-20px; bottom:-20px;"></i>
                    <div class="d-flex justify-content-between align-items-center position-relative z-1">
                        <div>
                            <h3 class="fw-bold mb-1">مواصلة الاستماع/القراءة</h3>
                            <p class="mb-0 text-white-50" id="continueReadingDetails">سورة -- الآية --</p>
                        </div>
                        <a href="#" id="continueReadingBtn" class="btn btn-light rounded-pill px-4 text-primary fw-bold shadow-sm">متابعة</a>
                    </div>
                </div>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', () => {
                const bookmarks = JSON.parse(localStorage.getItem('quran_bookmarks'));
                if (bookmarks && bookmarks.lastRead) {
                    const lr = bookmarks.lastRead;
                    document.getElementById('continueReadingDetails').textContent = `سورة رقم ${lr.surah} - الآية ${lr.ayah}`;
                    document.getElementById('continueReadingBtn').href = `<?= BASE_URL ?>quran/surah?id=${lr.surah}#ayah-${lr.ayah - 1}`;
                    document.getElementById('continueReadingSection').classList.remove('d-none');
                }
            });
            </script>

            <!-- Zikr of the day -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="card widget-card h-100 p-4 shadow-md rounded-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-btn bg-white text-primary me-3" style="cursor:default;">
                            <i data-lucide="sun"></i>
                        </div>
                        <h3 class="h4 mb-0 text-white">ذكر اليوم</h3>
                    </div>
                    <p class="fs-4 mb-4 fw-bold">"سُبْحَانَ اللَّهِ وَبِحَمْدِهِ ، سُبْحَانَ اللَّهِ الْعَظِيمِ"</p>
                    <p class="text-white-50 text-start mb-0">كلمتان خفيفتان على اللسان ثقيلتان في الميزان</p>
                </div>
            </div>

            <!-- Duaa of the day -->
            <div class="col-lg-6" data-aos="fade-up">
                <div class="card h-100 p-4 border-0 shadow-sm">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-btn bg-light-primary text-primary me-3" style="cursor:default;">
                            <i data-lucide="heart"></i>
                        </div>
                        <h3 class="h4 mb-0">دعاء اليوم</h3>
                    </div>
                    <p class="fs-4 mb-4 text-dark">"رَبَّنَا آتِنَا فِي الدُّنْيَا حَسَنَةً وَفِي الآخِرَةِ حَسَنَةً وَقِنَا عَذَابَ النَّارِ"</p>
                </div>
            </div>

            <!-- Prayer Times Widget Preview -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 p-4 border-0 shadow-sm bg-dark text-white">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center">
                            <i data-lucide="clock" class="text-primary me-3"></i>
                            <h3 class="h4 mb-0 text-white">مواقيت الصلاة</h3>
                        </div>
                        <span class="badge bg-primary rounded-pill px-3" id="homeCityName">جاري التحديد...</span>
                    </div>
                    <div class="row text-center g-2 mt-2" id="homePrayerTimes">
                        <?php 
                        $prayers = ['الفجر' => 'Fajr', 'الشروق' => 'Sunrise', 'الظهر' => 'Dhuhr', 'العصر' => 'Asr', 'المغرب' => 'Maghrib', 'العشاء' => 'Isha'];
                        foreach($prayers as $name => $key):
                        ?>
                        <div class="col">
                            <div class="p-2 border border-secondary rounded-3">
                                <small class="d-block text-white-50 mb-1"><?= $name ?></small>
                                <strong class="fs-5 prayer-time-value" id="pt-<?= $key ?>">--:--</strong>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <script>
                document.addEventListener('DOMContentLoaded', () => {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(pos => {
                            const lat = pos.coords.latitude;
                            const lng = pos.coords.longitude;
                            
                            fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lng}&localityLanguage=ar`)
                                .then(r => r.json())
                                .then(d => {
                                    document.getElementById('homeCityName').textContent = d.city || d.locality || 'موقعك الحالي';
                                }).catch(() => document.getElementById('homeCityName').textContent = 'موقعك الحالي');
                            
                            const now = new Date();
                            fetch(`https://api.aladhan.com/v1/timings/${Math.floor(now.getTime()/1000)}?latitude=${lat}&longitude=${lng}&method=4`)
                                .then(r => r.json())
                                .then(data => {
                                    if(data.code === 200) {
                                        const timings = data.data.timings;
                                        ['Fajr', 'Sunrise', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'].forEach(key => {
                                            const el = document.getElementById(`pt-${key}`);
                                            if(el) el.textContent = timings[key].split(' ')[0];
                                        });
                                    }
                                });
                        }, () => {
                            document.getElementById('homeCityName').textContent = 'تعذر تحديد الموقع';
                        });
                    } else {
                        document.getElementById('homeCityName').textContent = 'الموقع غير مدعوم';
                    }
                });
                </script>
            </div>
            
        </div>
    </div>
</section>
