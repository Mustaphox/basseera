<?php 
require_once __DIR__ . '/../../includes/QuranApiService.php';
$quranApi = new QuranApiService();

$surah_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
if ($surah_id < 1 || $surah_id > 114) $surah_id = 1;

$listen  = isset($_GET['listen']) && $_GET['listen'] === 'true';
$reader  = isset($_GET['reader']) && !empty($_GET['reader']) ? $_GET['reader'] : 'ar.alafasy';

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
        <h5 class="fw-bold mb-0"><i data-lucide="settings" class="me-2"></i>إعدادات القراءة</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <label class="form-label fw-bold text-muted mb-3">حجم الخط</label>
        <div class="d-flex gap-2 mb-4">
            <button class="btn btn-outline-secondary flex-grow-1 fs-5 fw-bold" id="decreaseFontBtn">A-</button>
            <button class="btn btn-outline-primary flex-grow-1 fs-5 fw-bold" id="increaseFontBtn">A+</button>
        </div>
        <label class="form-label fw-bold text-muted mb-3">الوضع</label>
        <button class="btn btn-outline-dark w-100 py-3 rounded-3" onclick="document.getElementById('theme-toggle').click(); bootstrap.Offcanvas.getInstance(document.getElementById('settingsSidebar')).hide();">
            <i data-lucide="moon" class="me-2"></i>تبديل الوضع الليلي
        </button>
    </div>
</div>

<!-- Page Header -->
<section class="py-4 bg-light-primary border-bottom">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
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

<!-- Sticky Audio Player -->
<div id="audioPlayerBar" class="bg-white border-bottom shadow-sm py-3 sticky-top" style="top: 72px; z-index: 900;">
    <div class="container">
        <audio id="quranAudio" preload="none"></audio>
        <div class="row align-items-center g-3">

            <!-- Controls -->
            <div class="col-auto d-flex gap-2 align-items-center">
                <button class="btn btn-light rounded-circle p-2" onclick="prevAyah()" title="السابق">
                    <i data-lucide="skip-back" style="width:20px;height:20px;"></i>
                </button>
                <button id="playPauseBtn" class="btn btn-primary rounded-circle shadow-sm" onclick="togglePlay()"
                    style="width:52px;height:52px; display:flex;align-items:center;justify-content:center;">
                    <i data-lucide="play" fill="white" style="width:22px;height:22px;"></i>
                </button>
                <button class="btn btn-light rounded-circle p-2" onclick="nextAyah()" title="التالي">
                    <i data-lucide="skip-forward" style="width:20px;height:20px;"></i>
                </button>
            </div>

            <!-- Info + Progress -->
            <div class="col">
                <div class="d-flex justify-content-between mb-1">
                    <small class="fw-bold text-dark" id="playerTitle">اختر آية للاستماع</small>
                    <small class="text-muted" id="playerTime" style="font-family:monospace;">0:00 / 0:00</small>
                </div>
                <div class="progress rounded-pill bg-light" style="height:6px; cursor:pointer;" id="progressBar" onclick="seekAudio(event)">
                    <div class="progress-bar bg-primary" id="progressFill" style="width:0%;transition:width .1s linear;"></div>
                </div>
            </div>

            <!-- Extra controls -->
            <div class="col-auto d-flex gap-2 align-items-center">
                <!-- Reader selector -->
                <select id="readerSelect" class="form-select form-select-sm border-0 bg-light" style="max-width:160px;"
                    onchange="changeReader(this.value)">
                    <option value="ar.alafasy" <?= $reader==='ar.alafasy'?'selected':'' ?>>مشاري العفاسي</option>
                    <option value="ar.abdulbasitmurattal" <?= $reader==='ar.abdulbasitmurattal'?'selected':'' ?>>عبد الباسط</option>
                    <option value="ar.husary" <?= $reader==='ar.husary'?'selected':'' ?>>الحصري</option>
                    <option value="ar.minshawi" <?= $reader==='ar.minshawi'?'selected':'' ?>>المنشاوي</option>
                    <option value="ar.sudais" <?= $reader==='ar.sudais'?'selected':'' ?>>السديس</option>
                </select>

                <!-- Speed -->
                <div class="dropdown">
                    <button class="btn btn-light btn-sm rounded-pill px-3" data-bs-toggle="dropdown">
                        <span id="speedLabel">1x</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-start border-0 shadow-sm">
                        <li><button class="dropdown-item" onclick="setSpeed(0.5)">0.5x بطيء</button></li>
                        <li><button class="dropdown-item" onclick="setSpeed(1.0)">1.0x طبيعي</button></li>
                        <li><button class="dropdown-item" onclick="setSpeed(1.5)">1.5x سريع</button></li>
                        <li><button class="dropdown-item" onclick="setSpeed(2.0)">2.0x أسرع</button></li>
                    </ul>
                </div>

                <!-- Repeat -->
                <button id="repeatBtn" class="btn btn-light btn-sm rounded-circle p-2" onclick="toggleRepeat()" title="تكرار">
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

                <!-- Navigation -->
                <div class="d-flex justify-content-between gap-3">
                    <?php if($surah_id > 1): ?>
                    <a href="<?= BASE_URL ?>quran/surah?id=<?= $surah_id-1 ?>&reader=<?= urlencode($reader) ?>"
                       class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                        <i data-lucide="chevron-right" class="me-1"></i> السابقة
                    </a>
                    <?php else: ?><div></div><?php endif; ?>

                    <a href="<?= BASE_URL ?>quran" class="btn btn-light rounded-pill px-4 fw-bold">
                        <i data-lucide="list" class="me-1"></i> الفهرس
                    </a>

                    <?php if($surah_id < 114): ?>
                    <a href="<?= BASE_URL ?>quran/surah?id=<?= $surah_id+1 ?>&reader=<?= urlencode($reader) ?>"
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
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-primary" id="modalLabel">خيارات الآية</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <div class="rounded-4 p-3 mb-4 text-center" style="background:rgba(255,138,0,0.06); font-family:'Amiri',serif; font-size:1.4rem; line-height:2;" id="modalAyahText">
                    &mdash;
                </div>
                <div class="row text-center text-muted small mb-4">
                    <div class="col-4"><span class="fw-bold text-dark d-block fs-5" id="modalJuz">-</span>الجزء</div>
                    <div class="col-4"><span class="fw-bold text-dark d-block fs-5" id="modalPage">-</span>الصفحة</div>
                    <div class="col-4"><span class="fw-bold text-dark d-block fs-5" id="modalRuku">-</span>الركوع</div>
                </div>
                <div id="modalSajda" class="text-center mb-3"></div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary flex-grow-1 rounded-pill py-2 fw-bold" id="modalPlayBtn" onclick="playFromModal()">
                        <i data-lucide="play" class="me-1"></i> استمع
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
    transition: background-color 0.2s;
    display: inline;
}
.ayah-word:hover { background: rgba(255,138,0,0.08); }
.ayah-word.playing { background: rgba(255,138,0,0.18); color: #FF8A00; }
.ayah-num {
    display: inline-flex; align-items: center; justify-content: center;
    width: 34px; height: 34px;
    font-size: 1rem; font-family: 'Cairo', sans-serif;
    color: #FF8A00; font-weight: 700;
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M50 2 L98 26 L98 74 L50 98 L2 74 L2 26 Z' fill='none' stroke='%23FF8A00' stroke-width='4'/%3E%3C/svg%3E") center/contain no-repeat;
    vertical-align: middle; margin: 0 8px;
}
[data-theme="dark"] .ayah-word:hover { background: rgba(255,255,255,0.06); }
[data-theme="dark"] #audioPlayerBar { background: #1a1a1a !important; }
</style>

<script>
// ── Data ──────────────────────────────────────────────────────────────────────
var surahId   = <?= $surah_id ?>;
var readerKey = '<?= addslashes($reader) ?>';
var ayahsData = <?= json_encode($ayahsForJs, JSON_UNESCAPED_UNICODE) ?>;

// ── State ─────────────────────────────────────────────────────────────────────
var audio        = document.getElementById('quranAudio');
var audioData    = [];   // filled after fetching audio edition
var curIdx       = -1;   // currently playing ayah index
var isRepeat     = false;
var speed        = 1.0;
var modalIdx     = -1;
var ayahModal    = new bootstrap.Modal(document.getElementById('ayahModal'));

// ── Load audio URLs ───────────────────────────────────────────────────────────
function loadAudioEdition(readerVal, thenPlayIndex) {
    fetch('https://api.alquran.cloud/v1/surah/' + surahId + '/' + readerVal)
        .then(function(r) { return r.json(); })
        .then(function(json) {
            if (json.code !== 200) throw new Error('bad');
            audioData = json.data.ayahs;
            if (typeof thenPlayIndex === 'number') {
                playAyah(thenPlayIndex);
            }
        })
        .catch(function() {
            console.warn('Audio fetch failed for', readerVal);
        });
}

// ── Playback ──────────────────────────────────────────────────────────────────
function playAyah(idx) {
    if (!audioData[idx]) {
        // Audio not yet loaded — load now then play
        loadAudioEdition(readerKey, idx);
        return;
    }
    curIdx = idx;
    audio.src = audioData[idx].audio;
    audio.playbackRate = speed;
    audio.play()
         .then(function() { updatePlayUI(true); })
         .catch(function(e) { console.warn('play() blocked:', e); });
    highlightAyah(idx);
    updatePlayerTitle(idx);
    saveLastRead(idx);
}

function togglePlay() {
    if (audio.paused) {
        if (curIdx < 0) { playAyah(0); return; }
        audio.play().then(function() { updatePlayUI(true); });
    } else {
        audio.pause();
        updatePlayUI(false);
    }
}

function nextAyah() {
    var next = curIdx + 1;
    if (next < ayahsData.length) {
        playAyah(next);
    } else if (surahId < 114) {
        window.location.href = '<?= BASE_URL ?>quran/surah?id=' + (surahId + 1) + '&listen=true&reader=' + readerKey;
    }
}

function prevAyah() {
    if (curIdx > 0) playAyah(curIdx - 1);
}

function seekAudio(e) {
    if (!audio.duration) return;
    var bar  = document.getElementById('progressBar');
    var rect = bar.getBoundingClientRect();
    var pct  = (e.clientX - rect.left) / rect.width;
    audio.currentTime = pct * audio.duration;
}

function setSpeed(val) {
    speed = val;
    audio.playbackRate = val;
    document.getElementById('speedLabel').textContent = val + 'x';
}

function toggleRepeat() {
    isRepeat = !isRepeat;
    document.getElementById('repeatBtn').classList.toggle('btn-primary', isRepeat);
    document.getElementById('repeatBtn').classList.toggle('btn-light', !isRepeat);
}

function changeReader(val) {
    readerKey = val;
    audioData = [];
    var wasPlaying = curIdx >= 0;
    loadAudioEdition(val, wasPlaying ? curIdx : null);
}

// ── Audio events ──────────────────────────────────────────────────────────────
audio.addEventListener('ended', function() {
    if (isRepeat) { audio.play(); return; }
    nextAyah();
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

function updatePlayerTitle(idx) {
    document.getElementById('playerTitle').textContent =
        'الآية ' + ayahsData[idx].numberInSurah + ' — سورة <?= $surahName ?>';
}

function highlightAyah(idx) {
    document.querySelectorAll('.ayah-word').forEach(function(el) {
        el.classList.remove('playing');
    });
    var el = document.getElementById('ayah-' + idx);
    if (el) {
        el.classList.add('playing');
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// ── Ayah Click / Modal ────────────────────────────────────────────────────────
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
    playAyah(modalIdx);
}

function copyFromModal() {
    var a = ayahsData[modalIdx];
    var txt = a.text + ' ﴿' + a.numberInSurah + '﴾ [سورة <?= $surahName ?>]';
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

// ── Reading Settings ──────────────────────────────────────────────────────────
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

// ── Auto-load audio on page load & auto-play if ?listen=true ─────────────────
document.addEventListener('DOMContentLoaded', function() {
    loadAudioEdition(readerKey, null);
    <?php if($listen): ?>
    setTimeout(function() { playAyah(0); }, 1200);
    <?php endif; ?>
});
</script>
