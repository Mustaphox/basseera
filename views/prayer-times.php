<?php $page_title = 'مواقيت الصلاة'; ?>

<section class="py-5 bg-light-primary border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary mb-3">مواقيت الصلاة</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            ﴿ إِنَّ الصَّلَاةَ كَانَتْ عَلَى الْمُؤْمِنِينَ كِتَابًا مَّوْقُوتًا ﴾
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">

        <!-- Location Status -->
        <div class="row justify-content-center mb-4" id="statusRow">
            <div class="col-lg-7 text-center">
                <div id="statusBox" class="alert alert-info border-0 shadow-sm rounded-4 py-3">
                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                    جاري تحديد موقعك الجغرافي...
                </div>
            </div>
        </div>

        <!-- Manual city search (shown when geolocation is denied) -->
        <div class="row justify-content-center mb-5 d-none" id="manualSearchRow">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-3 text-center">🔍 ابحث عن مدينتك</h5>
                    <div class="input-group">
                        <input type="text" id="cityInput" class="form-control form-control-lg border-0 bg-light"
                               placeholder="مثال: الجزائر، الرياض، القاهرة..."
                               onkeydown="if(event.key==='Enter') searchCity()">
                        <button class="btn btn-primary px-4 fw-bold" onclick="searchCity()">بحث</button>
                    </div>
                    <p class="text-muted small text-center mt-2 mb-0">أو
                        <button class="btn btn-link btn-sm text-primary p-0 fw-bold"
                                onclick="retryGeo()">اسمح بتحديد الموقع تلقائياً</button>
                    </p>
                </div>
            </div>
        </div>

        <!-- Dashboard (hidden until data loads) -->
        <div id="prayerDashboard" style="display:none;">

            <!-- Hero Card: Next Prayer Countdown -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-9 text-center" data-aos="zoom-in">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-white"
                         style="background: linear-gradient(135deg, #FF8A00 0%, #e65c00 100%);">
                        <div class="card-body p-5 position-relative">
                            <i data-lucide="clock" class="position-absolute opacity-10"
                               style="width:200px;height:200px;top:-40px;right:-40px;"></i>
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
                                <i data-lucide="map-pin" style="width:18px;height:18px;"></i>
                                <span id="cityName" class="fw-bold fs-5">---</span>
                            </div>
                            <p class="mb-2 fs-5 opacity-85">الصلاة القادمة</p>
                            <h2 class="display-4 fw-bold mb-2" id="nextPrayerName">---</h2>
                            <p class="mb-3 opacity-85">تبدأ بعد</p>
                            <div class="display-3 fw-bold mb-0" id="countdown"
                                 style="font-family:monospace; letter-spacing: -1px;">--:--:--</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's 6 Prayers -->
            <div class="row g-3 justify-content-center mb-5" id="todayPrayers"></div>

            <!-- Calculation Method Selector -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <div class="d-flex align-items-center gap-3">
                            <i data-lucide="sliders" class="text-primary" style="width:20px;height:20px;"></i>
                            <label class="fw-bold mb-0">طريقة الحساب:</label>
                            <select id="methodSelect" class="form-select border-0 bg-light"
                                    onchange="reloadWithMethod()">
                                <option value="4">أم القرى (مكة المكرمة)</option>
                                <option value="2">الرابطة الإسلامية العالمية</option>
                                <option value="3">معهد العلوم الإسلامية (أمريكا)</option>
                                <option value="5">مجمع الفقه الإسلامي (كراتشي)</option>
                                <option value="1">الهيئة العامة للمساحة (مصر)</option>
                                <option value="7">الاتحاد الإسلامي لأمريكا الشمالية</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Table -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold mb-0">📅 جدول الشهر الجاري</h4>
                    <span id="monthLabel" class="badge bg-light-primary text-primary px-3 py-2 rounded-pill fw-bold fs-6"></span>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless mb-0 text-center align-middle" id="monthlyTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3 ps-4">التاريخ</th>
                                <th class="py-3">الفجر</th>
                                <th class="py-3">الشروق</th>
                                <th class="py-3">الظهر</th>
                                <th class="py-3">العصر</th>
                                <th class="py-3">المغرب</th>
                                <th class="py-3 pe-4">العشاء</th>
                            </tr>
                        </thead>
                        <tbody id="monthlyBody"></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>

<style>
.prayer-card { transition: transform 0.2s, box-shadow 0.2s; cursor: default; }
.prayer-card:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(255,138,0,0.12) !important; }
.prayer-card.active-prayer { background: linear-gradient(135deg, #FF8A00, #e65c00) !important; color: white !important; }
.prayer-card.active-prayer .prayer-time { color: white !important; }
.prayer-card.active-prayer .prayer-icon { background: rgba(255,255,255,0.2) !important; }
.today-row { background: rgba(255,138,0,0.08); font-weight: 600; color: #FF8A00; }
</style>

<script>
var lat, lng, currentMethod = 4;

// ── Icons per prayer ──────────────────────────────────────────────────────────
var PRAYER_ICONS = {
    Fajr: 'sunrise', Sunrise: 'sun', Dhuhr: 'sun',
    Asr: 'sun-medium', Maghrib: 'sunset', Isha: 'moon'
};
var PRAYER_NAMES = {
    Fajr: 'الفجر', Sunrise: 'الشروق', Dhuhr: 'الظهر',
    Asr: 'العصر', Maghrib: 'المغرب', Isha: 'العشاء'
};

function cleanTime(t) { return t ? t.split(' ')[0] : '--:--'; }

// ── Startup: Try geolocation ──────────────────────────────────────────────────
(function init() {
    if (!navigator.geolocation) {
        showManualSearch('متصفحك لا يدعم تحديد الموقع. ابحث عن مدينتك يدوياً.');
        return;
    }
    navigator.geolocation.getCurrentPosition(
        function(pos) {
            lat = pos.coords.latitude;
            lng = pos.coords.longitude;
            getCityNameAndLoad(lat, lng);
        },
        function(err) {
            showManualSearch('لم يُسمح بتحديد الموقع. ابحث عن مدينتك يدوياً.');
        },
        { timeout: 8000 }
    );
})();

function retryGeo() {
    document.getElementById('manualSearchRow').classList.add('d-none');
    document.getElementById('statusRow').classList.remove('d-none');
    document.getElementById('statusBox').innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div> جاري تحديد موقعك...';
    navigator.geolocation.getCurrentPosition(
        function(pos) { lat = pos.coords.latitude; lng = pos.coords.longitude; getCityNameAndLoad(lat, lng); },
        function()    { showManualSearch('تعذّر تحديد الموقع. ابحث عن مدينتك يدوياً.'); }
    );
}

function showManualSearch(msg) {
    var sb = document.getElementById('statusBox');
    sb.className = 'alert alert-warning border-0 shadow-sm rounded-4 py-3';
    sb.textContent = msg;
    document.getElementById('manualSearchRow').classList.remove('d-none');
}

// ── Search city by name via Aladhan timingsByCity ─────────────────────────────
function searchCity() {
    var city = document.getElementById('cityInput').value.trim();
    if (!city) return;

    document.getElementById('statusBox').innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div> جاري البحث عن ' + city + '...';
    document.getElementById('statusBox').className = 'alert alert-info border-0 shadow-sm rounded-4 py-3';
    document.getElementById('manualSearchRow').classList.add('d-none');

    var now   = new Date();
    var year  = now.getFullYear();
    var month = now.getMonth() + 1;
    var url   = 'https://api.aladhan.com/v1/calendarByCity/' + year + '/' + month
                + '?city=' + encodeURIComponent(city) + '&country=&method=' + currentMethod;

    fetch(url)
        .then(function(r) { return r.json(); })
        .then(function(json) {
            if (json.code !== 200 || !json.data) {
                showManualSearch('لم يُعثر على مدينة "' + city + '". جرّب اسماً آخر.');
                document.getElementById('manualSearchRow').classList.remove('d-none');
                return;
            }
            document.getElementById('cityName').textContent = city;
            renderAll(json.data, now.getDate() - 1);
            document.getElementById('statusRow').classList.add('d-none');
            document.getElementById('prayerDashboard').style.display = 'block';
            if (typeof AOS !== 'undefined') AOS.refresh();
        })
        .catch(function() {
            showManualSearch('خطأ في الاتصال. تحقق من الإنترنت وأعد المحاولة.');
            document.getElementById('manualSearchRow').classList.remove('d-none');
        });
}

// ── Get city name then load by coordinates ────────────────────────────────────
function getCityNameAndLoad(la, ln) {
    fetch('https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=' + la + '&longitude=' + ln + '&localityLanguage=ar')
        .then(function(r) { return r.json(); })
        .then(function(d) {
            var city = d.city || d.locality || d.principalSubdivision || 'موقعك الحالي';
            document.getElementById('cityName').textContent = city;
        }).catch(function() {
            document.getElementById('cityName').textContent = 'موقعك الحالي';
        });

    loadByCoords(la, ln);
}

function loadByCoords(la, ln) {
    var now   = new Date();
    var year  = now.getFullYear();
    var month = now.getMonth() + 1;
    var url   = 'https://api.aladhan.com/v1/calendar/' + year + '/' + month
                + '?latitude=' + la + '&longitude=' + ln + '&method=' + currentMethod;

    fetch(url)
        .then(function(r) { return r.json(); })
        .then(function(json) {
            if (json.code !== 200) throw new Error('API');
            document.getElementById('statusRow').style.display = 'none';
            document.getElementById('prayerDashboard').style.display = 'block';
            renderAll(json.data, now.getDate() - 1);
            if (typeof AOS !== 'undefined') AOS.refresh();
        })
        .catch(function() {
            showManualSearch('تعذّر جلب مواقيت الصلاة. ابحث عن مدينتك يدوياً.');
            document.getElementById('manualSearchRow').classList.remove('d-none');
        });
}

function reloadWithMethod() {
    currentMethod = parseInt(document.getElementById('methodSelect').value);
    if (lat && lng) { loadByCoords(lat, lng); }
}

// ── Render ────────────────────────────────────────────────────────────────────
function renderAll(data, todayIdx) {
    var todayData = data[todayIdx];
    renderMonthLabel(todayData);
    renderToday(todayData.timings);
    renderMonthly(data, todayIdx);
    startCountdown(todayData.timings);
}

function renderMonthLabel(day) {
    var label = document.getElementById('monthLabel');
    if (label) label.textContent = day.date.hijri.month.ar + ' ' + day.date.hijri.year + ' هـ';
}

function renderToday(timings) {
    var container = document.getElementById('todayPrayers');
    container.innerHTML = '';
    var order = ['Fajr', 'Sunrise', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
    order.forEach(function(key, i) {
        var t = cleanTime(timings[key]);
        container.innerHTML +=
            '<div class="col-xl-2 col-lg-4 col-md-4 col-6" data-aos="fade-up" data-aos-delay="' + (i*60) + '">' +
                '<div class="card border-0 shadow-sm rounded-4 text-center p-4 prayer-card" id="pc-' + key + '">' +
                    '<div class="prayer-icon bg-light-primary text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:52px;height:52px;">' +
                        '<i data-lucide="' + PRAYER_ICONS[key] + '" style="width:22px;height:22px;"></i>' +
                    '</div>' +
                    '<h5 class="fw-bold mb-2">' + PRAYER_NAMES[key] + '</h5>' +
                    '<div class="prayer-time fs-4 fw-bold text-primary" style="font-family:monospace;">' + t + '</div>' +
                '</div>' +
            '</div>';
    });
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function renderMonthly(data, todayIdx) {
    var tbody = document.getElementById('monthlyBody');
    tbody.innerHTML = '';
    data.forEach(function(day, i) {
        var tr = document.createElement('tr');
        if (i === todayIdx) tr.className = 'today-row';
        tr.innerHTML =
            '<td class="ps-4 fw-bold">' + day.date.readable + '<br><small class="text-muted fw-normal">' + day.date.hijri.day + ' ' + day.date.hijri.month.ar + '</small></td>' +
            '<td>' + cleanTime(day.timings.Fajr)   + '</td>' +
            '<td>' + cleanTime(day.timings.Sunrise) + '</td>' +
            '<td>' + cleanTime(day.timings.Dhuhr)   + '</td>' +
            '<td>' + cleanTime(day.timings.Asr)     + '</td>' +
            '<td>' + cleanTime(day.timings.Maghrib) + '</td>' +
            '<td class="pe-4">' + cleanTime(day.timings.Isha) + '</td>';
        tbody.appendChild(tr);
    });
    // Scroll to today
    var todayRow = tbody.querySelectorAll('tr')[todayIdx];
    if (todayRow) setTimeout(function() { todayRow.scrollIntoView({ behavior:'smooth', block:'center' }); }, 600);
}

// ── Countdown ─────────────────────────────────────────────────────────────────
var countdownTimer;
function startCountdown(timings) {
    clearInterval(countdownTimer);

    var PRAYERS = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
    var now = new Date();

    var times = PRAYERS.map(function(k) {
        var parts = cleanTime(timings[k]).split(':');
        var d = new Date(now.getFullYear(), now.getMonth(), now.getDate(),
                         parseInt(parts[0]), parseInt(parts[1]), 0);
        return { key: k, name: PRAYER_NAMES[k], time: d };
    });

    var next = times.find(function(p) { return p.time > now; });
    if (!next) {
        // Tomorrow's Fajr
        next = { key: times[0].key, name: times[0].name, time: new Date(times[0].time) };
        next.time.setDate(next.time.getDate() + 1);
    }

    document.getElementById('nextPrayerName').textContent = 'صلاة ' + next.name;

    // Highlight active card
    PRAYERS.forEach(function(k) {
        var card = document.getElementById('pc-' + k);
        if (card) card.classList.remove('active-prayer');
    });
    var activeCard = document.getElementById('pc-' + next.key);
    if (activeCard) activeCard.classList.add('active-prayer');

    countdownTimer = setInterval(function() {
        var diff = next.time - new Date();
        if (diff <= 0) { clearInterval(countdownTimer); location.reload(); return; }
        var h = Math.floor(diff / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var s = Math.floor((diff % 60000) / 1000);
        document.getElementById('countdown').textContent =
            pad(h) + ':' + pad(m) + ':' + pad(s);
    }, 1000);
}

function pad(n) { return n < 10 ? '0' + n : n; }
</script>
