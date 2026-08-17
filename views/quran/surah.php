<?php 
require_once __DIR__ . '/../../includes/QuranApiService.php';
$quranApi = new QuranApiService();

$surah_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
if ($surah_id < 1 || $surah_id > 114) $surah_id = 1;

$listen   = isset($_GET['listen']) && $_GET['listen'] === 'true';
$reader   = isset($_GET['reader']) && !empty($_GET['reader']) ? $_GET['reader'] : 'ar.alafasy';
$playMode = isset($_GET['mode']) && in_array($_GET['mode'], ['full', 'ayah']) ? $_GET['mode'] : 'full';

// Reciters directory & audio servers
$reciters = [
    'ar.alafasy' => [
        'name' => 'مشاري راشد العفاسي',
        'server' => 'https://server8.mp3quran.net/afs/',
        'ayah_edition' => 'ar.alafasy'
    ],
    'ar.abdulbasitmurattal' => [
        'name' => 'عبد الباسط عبد الصمد (مرتل)',
        'server' => 'https://server7.mp3quran.net/basit/',
        'ayah_edition' => 'ar.abdulbasitmurattal'
    ],
    'ar.husary' => [
        'name' => 'محمود خليل الحصري',
        'server' => 'https://server13.mp3quran.net/husr/',
        'ayah_edition' => 'ar.husary'
    ],
    'ar.minshawi' => [
        'name' => 'محمد صديق المنشاوي (مرتل)',
        'server' => 'https://server10.mp3quran.net/minsh/',
        'ayah_edition' => 'ar.minshawi'
    ],
    'ar.sudais' => [
        'name' => 'عبد الرحمن السديس',
        'server' => 'https://server11.mp3quran.net/sds/',
        'ayah_edition' => 'ar.sudais'
    ],
    'ar.maher' => [
        'name' => 'ماهر المعيقلي',
        'server' => 'https://server12.mp3quran.net/maher/',
        'ayah_edition' => 'ar.mahermuaiqly'
    ],
    'ar.ghamdi' => [
        'name' => 'سعد الغامدي',
        'server' => 'https://server7.mp3quran.net/s_gmd/',
        'ayah_edition' => 'ar.alafasy'
    ],
    'ar.dosari' => [
        'name' => 'ياسر الدوسري',
        'server' => 'https://server11.mp3quran.net/yasser/',
        'ayah_edition' => 'ar.alafasy'
    ],
    'ar.shatri' => [
        'name' => 'أبو بكر الشاطري',
        'server' => 'https://server11.mp3quran.net/shatri/',
        'ayah_edition' => 'ar.shaatree'
    ],
    'ar.ajamy' => [
        'name' => 'أحمد بن علي العجمي',
        'server' => 'https://server10.mp3quran.net/ajm/',
        'ayah_edition' => 'ar.ahmedajamy'
    ]
];

if (!isset($reciters[$reader])) {
    $reader = 'ar.alafasy';
}

$surahPadded = str_pad($surah_id, 3, '0', STR_PAD_LEFT);
$fullSurahMp3Url = $reciters[$reader]['server'] . $surahPadded . '.mp3';

// Fetch Arabic text
$textResponse = $quranApi->getSurah($surah_id, 'quran-uthmani');

if (!$textResponse['success']) {
    $page_title = 'خطأ في الاتصال';
    echo "<div class='container py-5 text-center'><div class='alert alert-danger rounded-4 border-0 shadow-sm p-5'>
        <h4>⚠️ تعذّر الاتصال بخادم القرآن</h4>
        <p class='text-muted mb-4'>يرجى التأكد من الاتصال بالإنترنت والمحاولة مجدداً.</p>
        <a href='" . BASE_URL . "quran' class='btn btn-primary rounded-pill px-5'>العودة للفهرس</a>
    </div></div>";
    return;
}

$surah     = $textResponse['data'];
$surahName = str_replace('سُورَةُ ', '', $surah['name']);
$page_title = 'سورة ' . $surahName;
$typeAr    = $surah['revelationType'] === 'Meccan' ? 'مكية' : 'مدنية';
$ayahs     = $surah['ayahs'];

// Encode ayah data for JS (text + metadata)
$ayahsForJs = array_map(function($a) {
    return [
        'number'          => $a['number'],
        'numberInSurah'   => $a['numberInSurah'],
        'text'            => $a['text'],
        'juz'             => $a['juz'],
        'page'            => $a['page'],
        'ruku'            => $a['ruku'],
        'sajda'           => !empty($a['sajda']),
    ];
}, $ayahs);
?>

<!-- Reading Settings Offcanvas -->
<div class="offcanvas offcanvas-end shadow" tabindex="-1" id="settingsSidebar">
    <div class="offcanvas-header border-bottom pb-3">
        <h5 class="fw-bold mb-0"><i data-lucide="settings" class="me-2"></i>إعدادات القراءة والتلاوة</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <label class="form-label fw-bold text-muted mb-3">حجم الخط</label>
        <div class="d-flex gap-2 mb-4">
            <button class="btn btn-outline-secondary flex-grow-1 fs-5 fw-bold" id="decreaseFontBtn">A-</button>
            <button class="btn btn-outline-primary flex-grow-1 fs-5 fw-bold" id="increaseFontBtn">A+</button>
        </div>

        <label class="form-label fw-bold text-muted mb-3">الوضع الافتراضي للاستماع</label>
        <div class="d-grid gap-2 mb-4">
            <button class="btn btn-outline-primary rounded-3 text-start d-flex align-items-center justify-content-between py-2" onclick="setPlayMode('full'); bootstrap.Offcanvas.getInstance(document.getElementById('settingsSidebar')).hide();">
                <span><i data-lucide="disc" class="me-2"></i> السورة كاملة (متصل)</span>
                <span class="badge bg-primary rounded-pill">موصى به</span>
            </button>
            <button class="btn btn-outline-secondary rounded-3 text-start d-flex align-items-center justify-content-between py-2" onclick="setPlayMode('ayah'); bootstrap.Offcanvas.getInstance(document.getElementById('settingsSidebar')).hide();">
                <span><i data-lucide="list-music" class="me-2"></i> آية بآية (مع التظليل)</span>
            </button>
        </div>

        <label class="form-label fw-bold text-muted mb-3">المظهر</label>
        <button class="btn btn-outline-dark w-100 py-3 rounded-3" onclick="document.getElementById('theme-toggle').click(); bootstrap.Offcanvas.getInstance(document.getElementById('settingsSidebar')).hide();">
            <i data-lucide="moon" class="me-2"></i>تبديل الوضع الليلي
        </button>
    </div>
</div>

<!-- Page Header -->
<section class="py-4 bg-light-primary border-bottom">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <a href="<?= BASE_URL ?>quran" class="btn btn-outline-primary rounded-pill">
                <i data-lucide="list" class="me-1"></i> الفهرس
            </a>
            <div class="text-center">
                <h1 class="display-5 fw-bold text-primary mb-1" style="font-family:'Amiri','Cairo',serif;">سورة <?= $surahName ?></h1>
                <span class="text-muted">
                    <?= $typeAr ?> &bull; <?= count($ayahs) ?> آية
                    &bull; الجزء <?= $ayahs[0]['juz'] ?>
                </span>
            </div>
            <button class="btn btn-outline-secondary rounded-pill" data-bs-toggle="offcanvas" data-bs-target="#settingsSidebar">
                <i data-lucide="settings" class="me-1"></i> إعدادات
            </button>
        </div>
    </div>
</section>

<!-- Sticky Audio Player Bar -->
<div id="audioPlayerBar" class="border-bottom py-2 py-md-3 sticky-top shadow-sm" style="top: 72px; z-index: 900; background: rgba(13,8,30,0.94) !important; backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-color: rgba(255,255,255,0.08) !important;">
    <div class="container">
        <audio id="quranAudio" preload="none"></audio>
        
        <!-- Upper Row: Mode Toggle & Reciter Info -->
        <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-secondary border-opacity-25 flex-wrap gap-2">
            <!-- Mode Switcher -->
            <div class="d-flex align-items-center gap-2">
                <div class="btn-group btn-group-sm p-1 rounded-pill" style="background: rgba(255,255,255,0.08);" role="group">
                    <button type="button" class="btn btn-sm rounded-pill px-3 fw-bold <?= $playMode==='full'?'btn-primary':'btn-dark text-light border-0' ?>" id="modeFullBtn" onclick="setPlayMode('full')">
                        <i data-lucide="disc" style="width:14px;height:14px;" class="me-1"></i> السورة كاملة
                    </button>
                    <button type="button" class="btn btn-sm rounded-pill px-3 fw-bold <?= $playMode==='ayah'?'btn-primary':'btn-dark text-light border-0' ?>" id="modeAyahBtn" onclick="setPlayMode('ayah')">
                        <i data-lucide="list-music" style="width:14px;height:14px;" class="me-1"></i> آية بآية
                    </button>
                </div>
            </div>

            <!-- Current Track Info & Mode Badge -->
            <div class="d-flex align-items-center gap-2 text-truncate">
                <span class="badge bg-warning bg-opacity-25 text-warning px-2 py-1 rounded-pill small" id="modeBadge">
                    <?= $playMode==='full' ? 'تلاوة السورة كاملة' : 'تلاوة آية بآية' ?>
                </span>
                <span class="text-light fw-bold text-truncate small" id="playerTitle" style="max-width: 320px;">
                    سورة <?= $surahName ?> كاملة &mdash; <?= $reciters[$reader]['name'] ?>
                </span>
            </div>

            <!-- Quick Download MP3 -->
            <div>
                <a id="downloadSurahBtn" href="<?= $fullSurahMp3Url ?>" target="_blank" download="Surah_<?= $surahPadded ?>_<?= $reader ?>.mp3" class="btn btn-sm btn-outline-light rounded-pill px-3 d-inline-flex align-items-center gap-1" title="تحميل السورة كاملة بصيغة MP3">
                    <i data-lucide="download" style="width:14px;height:14px;"></i>
                    <span class="d-none d-sm-inline">تحميل MP3</span>
                </a>
            </div>
        </div>

        <!-- Main Player Controls & Progress -->
        <div class="row align-items-center g-2 g-md-3">

            <!-- Playback Action Buttons -->
            <div class="col-auto d-flex gap-1 gap-md-2 align-items-center">
                <!-- Prev / Skip Back -->
                <button class="btn btn-dark text-light border-0 rounded-circle p-2 shadow-sm" onclick="handlePrev()" title="السابق">
                    <i data-lucide="skip-back" style="width:18px;height:18px;"></i>
                </button>

                <!-- 10s Rewind -->
                <button class="btn btn-dark text-light border-0 rounded-circle p-2 shadow-sm d-none d-sm-flex" onclick="skipTime(-10)" title="تأخير 10 ثوانٍ">
                    <i data-lucide="rotate-ccw" style="width:18px;height:18px;"></i>
                </button>

                <!-- Main Play/Pause Button -->
                <button id="playPauseBtn" class="btn btn-primary rounded-circle shadow-lg" onclick="togglePlay()"
                    style="width:48px;height:48px; display:flex;align-items:center;justify-content:center; box-shadow: 0 0 18px rgba(255,138,0,0.45) !important;">
                    <i data-lucide="play" fill="white" style="width:22px;height:22px;"></i>
                </button>

                <!-- 10s Forward -->
                <button class="btn btn-dark text-light border-0 rounded-circle p-2 shadow-sm d-none d-sm-flex" onclick="skipTime(10)" title="تقديم 10 ثوانٍ">
                    <i data-lucide="rotate-cw" style="width:18px;height:18px;"></i>
                </button>

                <!-- Next / Skip Forward -->
                <button class="btn btn-dark text-light border-0 rounded-circle p-2 shadow-sm" onclick="handleNext()" title="التالي">
                    <i data-lucide="skip-forward" style="width:18px;height:18px;"></i>
                </button>
            </div>

            <!-- Progress Bar & Timer -->
            <div class="col">
                <div class="d-flex justify-content-between mb-1 small">
                    <span class="text-light-50" id="playerStatus" style="font-size:0.8rem; color: rgba(255,255,255,0.7);">جاهز للتشغيل</span>
                    <span class="text-warning fw-bold" id="playerTime" style="font-family:monospace; font-size:0.85rem;">0:00 / 0:00</span>
                </div>
                <div class="progress rounded-pill" style="height:8px; cursor:pointer; background: rgba(255,255,255,0.15);" id="progressBar" onclick="seekAudio(event)">
                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" id="progressFill" style="width:0%; transition:width .1s linear;"></div>
                </div>
            </div>

            <!-- Reciter, Speed & Repeat Options -->
            <div class="col-auto d-flex gap-1 gap-md-2 align-items-center">
                <!-- Reader selector -->
                <select id="readerSelect" class="form-select form-select-sm border-0 text-light fw-bold" style="max-width:150px; background: rgba(255,255,255,0.1); border-radius:20px;"
                    onchange="changeReader(this.value)">
                    <?php foreach ($reciters as $key => $r): ?>
                        <option value="<?= $key ?>" class="text-dark bg-light" <?= $reader===$key?'selected':'' ?>><?= $r['name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Speed -->
                <div class="dropdown">
                    <button class="btn btn-dark text-light border-0 btn-sm rounded-pill px-2 px-md-3" data-bs-toggle="dropdown" title="سرعة التلاوة">
                        <span id="speedLabel">1x</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="background: rgba(25,12,50,0.96); backdrop-filter: blur(20px);">
                        <li><button class="dropdown-item text-light py-2" onclick="setSpeed(0.5)">0.5x بطيء جداً</button></li>
                        <li><button class="dropdown-item text-light py-2" onclick="setSpeed(0.75)">0.75x بطيء</button></li>
                        <li><button class="dropdown-item text-light py-2 fw-bold active" onclick="setSpeed(1.0)">1.0x طبيعي</button></li>
                        <li><button class="dropdown-item text-light py-2" onclick="setSpeed(1.25)">1.25x متوسط</button></li>
                        <li><button class="dropdown-item text-light py-2" onclick="setSpeed(1.5)">1.5x سريع</button></li>
                        <li><button class="dropdown-item text-light py-2" onclick="setSpeed(2.0)">2.0x أسرع</button></li>
                    </ul>
                </div>

                <!-- Repeat -->
                <button id="repeatBtn" class="btn btn-dark text-light border-0 btn-sm rounded-circle p-2" onclick="toggleRepeat()" title="تكرار السورة أو الآية">
                    <i data-lucide="repeat" style="width:18px;height:18px;"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Quran Text -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-9 col-xl-10">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5">

                    <?php if ($surah_id !== 1 && $surah_id !== 9): ?>
                    <div class="text-center mb-5 pb-3 border-bottom">
                        <p class="fs-2 text-muted" style="font-family:'Amiri',serif; letter-spacing: 2px;">
                            بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ
                        </p>
                    </div>
                    <?php endif; ?>

                    <div id="quranText" style="font-family:'Amiri','Cairo',serif; font-size:2.4rem; line-height:2.8; text-align:justify; direction:rtl;">
                        <?php foreach ($ayahs as $i => $ayah): ?>
                            <span class="ayah-word"
                                  id="ayah-<?= $i ?>"
                                  data-index="<?= $i ?>"
                                  data-number="<?= $ayah['numberInSurah'] ?>"
                                  data-juz="<?= $ayah['juz'] ?>"
                                  data-page="<?= $ayah['page'] ?>"
                                  data-ruku="<?= $ayah['ruku'] ?>"
                                  data-sajda="<?= !empty($ayah['sajda']) ? '1' : '0' ?>"
                                  data-text="<?= htmlspecialchars($ayah['text'], ENT_QUOTES) ?>"
                                  onclick="selectAyah(<?= $i ?>)"><?= $ayah['text'] ?>
                                <span class="ayah-num"><?= $ayah['numberInSurah'] ?></span>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Navigation between Surahs -->
                <div class="d-flex justify-content-between gap-3 flex-wrap">
                    <?php if($surah_id > 1): ?>
                    <a href="<?= BASE_URL ?>quran/surah?id=<?= $surah_id-1 ?>&reader=<?= urlencode($reader) ?>&mode=<?= urlencode($playMode) ?>"
                       class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                        <i data-lucide="chevron-right" class="me-1"></i> السابقة
                    </a>
                    <?php else: ?><div></div><?php endif; ?>

                    <a href="<?= BASE_URL ?>quran" class="btn btn-light rounded-pill px-4 fw-bold">
                        <i data-lucide="list" class="me-1"></i> الفهرس
                    </a>

                    <?php if($surah_id < 114): ?>
                    <a href="<?= BASE_URL ?>quran/surah?id=<?= $surah_id+1 ?>&reader=<?= urlencode($reader) ?>&mode=<?= urlencode($playMode) ?>"
                       class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                        التالية <i data-lucide="chevron-left" class="ms-1"></i>
                    </a>
                    <?php else: ?><div></div><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Ayah Action Modal -->
<div class="modal fade" id="ayahModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4" style="background: rgba(20,8,45,0.95); backdrop-filter: blur(30px); -webkit-backdrop-filter: blur(30px); border: 1px solid rgba(255,255,255,0.15) !important;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-primary" id="modalLabel">خيارات الآية</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <div class="rounded-4 p-3 mb-4 text-center text-white" style="background:rgba(255,138,0,0.08); font-family:'Amiri',serif; font-size:1.4rem; line-height:2;" id="modalAyahText">
                    &mdash;
                </div>
                <div class="row text-center small mb-4" style="color: rgba(255,255,255,0.75);">
                    <div class="col-4"><span class="fw-bold text-primary d-block fs-5" id="modalJuz">-</span>الجزء</div>
                    <div class="col-4"><span class="fw-bold text-primary d-block fs-5" id="modalPage">-</span>الصفحة</div>
                    <div class="col-4"><span class="fw-bold text-primary d-block fs-5" id="modalRuku">-</span>الركوع</div>
                </div>
                <div id="modalSajda" class="text-center mb-3"></div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary flex-grow-1 rounded-pill py-2 fw-bold" id="modalPlayBtn" onclick="playFromModal()">
                        <i data-lucide="play" class="me-1"></i> استمع للآية
                    </button>
                    <button class="btn btn-outline-secondary flex-grow-1 rounded-pill py-2 fw-bold" id="modalCopyBtn" onclick="copyFromModal()">
                        <i data-lucide="copy" class="me-1"></i> نسخ
                    </button>
                    <button class="btn btn-outline-primary flex-grow-1 rounded-pill py-2 fw-bold" id="modalBookmarkBtn" onclick="bookmarkFromModal()">
                        <i data-lucide="bookmark" class="me-1"></i> حفظ
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.ayah-word {
    cursor: pointer;
    border-radius: 8px;
    padding: 2px 4px;
    transition: background-color 0.2s, color 0.2s;
    display: inline;
}
.ayah-word:hover { background: rgba(255,138,0,0.12); }
.ayah-word.playing { background: rgba(255,138,0,0.22); color: #FF8A00; text-shadow: 0 0 10px rgba(255,138,0,0.3); }
.ayah-num {
    display: inline-flex; align-items: center; justify-content: center;
    width: 34px; height: 34px;
    font-size: 1rem; font-family: 'Cairo', sans-serif;
    color: #FF8A00; font-weight: 700;
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M50 2 L98 26 L98 74 L50 98 L2 74 L2 26 Z' fill='none' stroke='%23FF8A00' stroke-width='4'/%3E%3C/svg%3E") center/contain no-repeat;
    vertical-align: middle; margin: 0 8px;
}
</style>

<script>
// ── Data & Reciters Directory ──────────────────────────────────────────────────
var surahId     = <?= $surah_id ?>;
var surahPadded = '<?= $surahPadded ?>';
var surahName   = '<?= addslashes($surahName) ?>';
var readerKey   = '<?= addslashes($reader) ?>';
var playMode    = '<?= addslashes($playMode) ?>'; // 'full' or 'ayah'
var ayahsData   = <?= json_encode($ayahsForJs, JSON_UNESCAPED_UNICODE) ?>;
var recitersMap = <?= json_encode($reciters, JSON_UNESCAPED_UNICODE) ?>;

// ── Player State ──────────────────────────────────────────────────────────────
var audio        = document.getElementById('quranAudio');
var audioData    = [];   // filled in ayah mode
var curAyahIdx   = -1;   // currently playing ayah index in ayah mode
var isRepeat     = false;
var speed        = 1.0;
var modalIdx     = -1;
var ayahModal    = new bootstrap.Modal(document.getElementById('ayahModal'));

// ── Mode Switcher ─────────────────────────────────────────────────────────────
function setPlayMode(mode, autoStart) {
    var wasPlaying = !audio.paused;
    playMode = mode;

    var modeFullBtn = document.getElementById('modeFullBtn');
    var modeAyahBtn = document.getElementById('modeAyahBtn');
    var modeBadge   = document.getElementById('modeBadge');

    if (mode === 'full') {
        modeFullBtn.className = 'btn btn-sm rounded-pill px-3 fw-bold btn-primary';
        modeAyahBtn.className = 'btn btn-sm rounded-pill px-3 fw-bold btn-dark text-light border-0';
        modeBadge.textContent = 'تلاوة السورة كاملة';
        modeBadge.className   = 'badge bg-warning bg-opacity-25 text-warning px-2 py-1 rounded-pill small';
        clearAyahHighlight();
        loadFullSurahAudio(autoStart || wasPlaying);
    } else {
        modeFullBtn.className = 'btn btn-sm rounded-pill px-3 fw-bold btn-dark text-light border-0';
        modeAyahBtn.className = 'btn btn-sm rounded-pill px-3 fw-bold btn-primary';
        modeBadge.textContent = 'تلاوة آية بآية';
        modeBadge.className   = 'badge bg-info bg-opacity-25 text-info px-2 py-1 rounded-pill small';
        
        var startIdx = curAyahIdx >= 0 ? curAyahIdx : 0;
        loadAyahAudioEdition(readerKey, (autoStart || wasPlaying) ? startIdx : null);
    }
    updateDownloadBtn();
}

// ── Full Surah Playback ───────────────────────────────────────────────────────
function getFullSurahUrl(rKey) {
    var rec = recitersMap[rKey] || recitersMap['ar.alafasy'];
    return rec.server + surahPadded + '.mp3';
}

function loadFullSurahAudio(andPlay) {
    var url = getFullSurahUrl(readerKey);
    var currentReciter = recitersMap[readerKey] || recitersMap['ar.alafasy'];
    
    document.getElementById('playerTitle').textContent = 'سورة ' + surahName + ' كاملة — ' + currentReciter.name;
    document.getElementById('playerStatus').textContent = 'السورة كاملة';
    
    if (audio.src !== url) {
        audio.src = url;
    }
    audio.playbackRate = speed;

    if (andPlay) {
        audio.play()
            .then(function() { updatePlayUI(true); })
            .catch(function(e) { console.warn('Full surah autoplay blocked:', e); });
    } else {
        updatePlayUI(false);
    }
}

// ── Ayah-by-Ayah Playback ─────────────────────────────────────────────────────
function loadAyahAudioEdition(readerVal, thenPlayIndex) {
    var rec = recitersMap[readerVal] || recitersMap['ar.alafasy'];
    var edition = rec.ayah_edition || 'ar.alafasy';

    document.getElementById('playerStatus').textContent = 'جاري جلب صوت الآيات...';
    fetch('https://api.alquran.cloud/v1/surah/' + surahId + '/' + edition)
        .then(function(r) { return r.json(); })
        .then(function(json) {
            if (json.code !== 200) throw new Error('bad');
            audioData = json.data.ayahs;
            document.getElementById('playerStatus').textContent = 'آية بآية';
            if (typeof thenPlayIndex === 'number') {
                playAyah(thenPlayIndex);
            }
        })
        .catch(function() {
            document.getElementById('playerStatus').textContent = 'تعذر جلب صوت الآيات';
            console.warn('Ayah audio fetch failed for', edition);
        });
}

function playAyah(idx) {
    if (playMode !== 'ayah') {
        playMode = 'ayah';
        document.getElementById('modeFullBtn').className = 'btn btn-sm rounded-pill px-3 fw-bold btn-dark text-light border-0';
        document.getElementById('modeAyahBtn').className = 'btn btn-sm rounded-pill px-3 fw-bold btn-primary';
        document.getElementById('modeBadge').textContent = 'تلاوة آية بآية';
        document.getElementById('modeBadge').className   = 'badge bg-info bg-opacity-25 text-info px-2 py-1 rounded-pill small';
    }

    if (!audioData[idx]) {
        loadAyahAudioEdition(readerKey, idx);
        return;
    }
    curAyahIdx = idx;
    audio.src = audioData[idx].audio;
    audio.playbackRate = speed;
    audio.play()
         .then(function() { updatePlayUI(true); })
         .catch(function(e) { console.warn('playAyah blocked:', e); });
    
    highlightAyah(idx);
    updatePlayerTitleForAyah(idx);
    saveLastRead(idx);
}

// ── Controls: Play/Pause, Next, Prev, Seek, Speed, Skip ────────────────────────
function togglePlay() {
    if (audio.paused) {
        if (playMode === 'full') {
            if (!audio.src || audio.src === '' || audio.src === window.location.href) {
                loadFullSurahAudio(true);
            } else {
                audio.play().then(function() { updatePlayUI(true); });
            }
        } else {
            if (curAyahIdx < 0) { playAyah(0); return; }
            audio.play().then(function() { updatePlayUI(true); });
        }
    } else {
        audio.pause();
        updatePlayUI(false);
    }
}

function handleNext() {
    if (playMode === 'full') {
        if (surahId < 114) {
            window.location.href = '<?= BASE_URL ?>quran/surah?id=' + (surahId + 1) + '&listen=true&reader=' + readerKey + '&mode=full';
        } else {
            skipTime(10);
        }
    } else {
        nextAyah();
    }
}

function handlePrev() {
    if (playMode === 'full') {
        if (audio.currentTime > 5) {
            audio.currentTime = 0;
        } else if (surahId > 1) {
            window.location.href = '<?= BASE_URL ?>quran/surah?id=' + (surahId - 1) + '&listen=true&reader=' + readerKey + '&mode=full';
        }
    } else {
        prevAyah();
    }
}

function nextAyah() {
    var next = curAyahIdx + 1;
    if (next < ayahsData.length) {
        playAyah(next);
    } else if (surahId < 114) {
        window.location.href = '<?= BASE_URL ?>quran/surah?id=' + (surahId + 1) + '&listen=true&reader=' + readerKey + '&mode=ayah';
    }
}

function prevAyah() {
    if (curAyahIdx > 0) {
        playAyah(curAyahIdx - 1);
    } else if (audio.currentTime > 2) {
        audio.currentTime = 0;
    }
}

function skipTime(seconds) {
    if (!audio.duration) return;
    audio.currentTime = Math.max(0, Math.min(audio.duration, audio.currentTime + seconds));
}

function seekAudio(e) {
    if (!audio.duration) return;
    var bar  = document.getElementById('progressBar');
    var rect = bar.getBoundingClientRect();
    var pct  = (e.clientX - rect.left) / rect.width;
    audio.currentTime = Math.max(0, Math.min(audio.duration, pct * audio.duration));
}

function setSpeed(val) {
    speed = val;
    audio.playbackRate = val;
    document.getElementById('speedLabel').textContent = val + 'x';
}

function toggleRepeat() {
    isRepeat = !isRepeat;
    var btn = document.getElementById('repeatBtn');
    btn.classList.toggle('btn-primary', isRepeat);
    btn.classList.toggle('btn-dark', !isRepeat);
    btn.title = isRepeat ? 'إلغاء التكرار' : 'تكرار التلاوة';
}

function changeReader(val) {
    readerKey = val;
    updateDownloadBtn();
    if (playMode === 'full') {
        var wasPlaying = !audio.paused;
        loadFullSurahAudio(wasPlaying);
    } else {
        audioData = [];
        var wasPlaying = curAyahIdx >= 0 && !audio.paused;
        loadAyahAudioEdition(val, wasPlaying ? curAyahIdx : null);
    }
}

function updateDownloadBtn() {
    var url = getFullSurahUrl(readerKey);
    var btn = document.getElementById('downloadSurahBtn');
    if (btn) {
        btn.href = url;
        btn.setAttribute('download', 'Surah_' + surahPadded + '_' + readerKey + '.mp3');
    }
}

// ── Audio Events ──────────────────────────────────────────────────────────────
audio.addEventListener('ended', function() {
    if (isRepeat) {
        audio.currentTime = 0;
        audio.play();
        return;
    }
    if (playMode === 'full') {
        if (surahId < 114) {
            window.location.href = '<?= BASE_URL ?>quran/surah?id=' + (surahId + 1) + '&listen=true&reader=' + readerKey + '&mode=full';
        } else {
            updatePlayUI(false);
        }
    } else {
        nextAyah();
    }
});

audio.addEventListener('timeupdate', function() {
    if (!audio.duration) return;
    var pct = (audio.currentTime / audio.duration) * 100;
    document.getElementById('progressFill').style.width = pct + '%';
    document.getElementById('playerTime').textContent =
        fmt(audio.currentTime) + ' / ' + fmt(audio.duration);
});

audio.addEventListener('play',  function() { updatePlayUI(true);  });
audio.addEventListener('pause', function() { updatePlayUI(false); });

// ── UI Helpers ────────────────────────────────────────────────────────────────
function fmt(s) {
    if (!s || isNaN(s)) return '0:00';
    var m = Math.floor(s / 60), sec = Math.floor(s % 60);
    return m + ':' + (sec < 10 ? '0' : '') + sec;
}

function updatePlayUI(playing) {
    var icon = document.querySelector('#playPauseBtn i');
    if (icon) {
        icon.setAttribute('data-lucide', playing ? 'pause' : 'play');
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }
}

function updatePlayerTitleForAyah(idx) {
    var currentReciter = recitersMap[readerKey] || recitersMap['ar.alafasy'];
    document.getElementById('playerTitle').textContent =
        'الآية ' + ayahsData[idx].numberInSurah + ' — سورة ' + surahName + ' (' + currentReciter.name + ')';
    document.getElementById('playerStatus').textContent = 'آية ' + ayahsData[idx].numberInSurah + ' من ' + ayahsData.length;
}

function highlightAyah(idx) {
    clearAyahHighlight();
    var el = document.getElementById('ayah-' + idx);
    if (el) {
        el.classList.add('playing');
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

function clearAyahHighlight() {
    document.querySelectorAll('.ayah-word').forEach(function(el) {
        el.classList.remove('playing');
    });
}

// ── Ayah Click & Modal Actions ────────────────────────────────────────────────
function selectAyah(idx) {
    modalIdx = idx;
    var a = ayahsData[idx];
    document.getElementById('modalAyahText').textContent = a.text;
    document.getElementById('modalJuz').textContent  = a.juz;
    document.getElementById('modalPage').textContent = a.page;
    document.getElementById('modalRuku').textContent = a.ruku;

    var sajdaEl = document.getElementById('modalSajda');
    sajdaEl.innerHTML = a.sajda
        ? '<span class="badge bg-danger px-3 py-2 rounded-pill">⚠️ فيها سجدة تلاوة</span>'
        : '';

    // Bookmark icon fill
    var bk = getBookmarks();
    var id = surahId + '-' + a.numberInSurah;
    var bkIcon = document.querySelector('#modalBookmarkBtn i');
    if (bkIcon) bkIcon.setAttribute('fill', bk.some(function(x) { return x.id === id; }) ? 'currentColor' : 'none');

    if (typeof lucide !== 'undefined') lucide.createIcons();
    ayahModal.show();
}

function playFromModal() {
    ayahModal.hide();
    setPlayMode('ayah');
    playAyah(modalIdx);
}

function copyFromModal() {
    var a = ayahsData[modalIdx];
    var txt = a.text + ' ﴿' + a.numberInSurah + '﴾ [سورة ' + surahName + ']';
    navigator.clipboard.writeText(txt).then(function() {
        var btn = document.getElementById('modalCopyBtn');
        btn.innerHTML = '<i data-lucide="check" class="me-1"></i> تم النسخ';
        if (typeof lucide !== 'undefined') lucide.createIcons();
        setTimeout(function() {
            btn.innerHTML = '<i data-lucide="copy" class="me-1"></i> نسخ';
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }, 2000);
    });
}

function bookmarkFromModal() {
    var a  = ayahsData[modalIdx];
    var id = surahId + '-' + a.numberInSurah;
    var bk = getBookmarks();
    var i  = bk.findIndex(function(x) { return x.id === id; });
    if (i > -1) {
        bk.splice(i, 1);
    } else {
        bk.push({ id: id, surah: surahId, ayah: a.numberInSurah, text: a.text });
    }
    localStorage.setItem('quran_bookmarks_ayahs', JSON.stringify(bk));
    // Update icon
    var icon = document.querySelector('#modalBookmarkBtn i');
    if (icon) {
        icon.setAttribute('fill', i === -1 ? 'currentColor' : 'none');
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }
}

function getBookmarks() {
    try { return JSON.parse(localStorage.getItem('quran_bookmarks_ayahs')) || []; }
    catch(e) { return []; }
}

function saveLastRead(idx) {
    var lr = { surah: surahId, ayah: ayahsData[idx].numberInSurah, ts: Date.now() };
    localStorage.setItem('quran_last_read', JSON.stringify(lr));
}

// ── Reading Settings (Font Size) ──────────────────────────────────────────────
(function initSettings() {
    var fs = parseFloat(localStorage.getItem('quran_font_size')) || 2.4;
    setFontSize(fs);
    document.getElementById('increaseFontBtn').onclick = function() { setFontSize(null, 0.2); };
    document.getElementById('decreaseFontBtn').onclick = function() { setFontSize(null, -0.2); };
})();

function setFontSize(val, delta) {
    var el  = document.getElementById('quranText');
    var cur = parseFloat(el.style.fontSize) || 2.4;
    var nxt = val !== null ? val : Math.max(1.5, Math.min(5, cur + delta));
    el.style.fontSize = nxt + 'rem';
    localStorage.setItem('quran_font_size', nxt);
}

// ── Initial Boot ──────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    if (playMode === 'full') {
        loadFullSurahAudio(<?= $listen ? 'true' : 'false' ?>);
    } else {
        loadAyahAudioEdition(readerKey, <?= $listen ? '0' : 'null' ?>);
    }
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>
