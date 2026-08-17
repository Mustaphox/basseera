<?php $page_title = 'السيرة النبوية'; ?>

<section class="py-5 bg-light-primary border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary mb-3">السيرة النبوية</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            رحلة إيمانية في سيرة خير الأنام محمد ﷺ، نتعلم منها الدروس والعبر لحياتنا.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            
            <!-- Video Player Area -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="ratio ratio-16x9">
                        <div id="ytplayer"></div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h2 class="h4 fw-bold mb-2" id="currentVideoTitle">جاري التحميل...</h2>
                    <p class="text-muted mb-0" id="currentVideoDesc">فضيلة الشيخ عثمان الخميس</p>
                </div>
            </div>
            
            <!-- Playlist Sidebar -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 d-flex flex-column">
                    <div class="card-header border-bottom p-4" style="background: rgba(255,255,255,0.05);">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="h5 fw-bold mb-0">الحلقات</h3>
                            <span class="badge bg-light-primary text-primary px-3 py-2 rounded-pill" id="playlistCount">0 / 0</span>
                        </div>
                    </div>
                    
                    <div class="card-body p-0" style="max-height: 600px; overflow-y: auto;" id="playlistContainer">
                        <!-- Items rendered via JS -->
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<style>
.playlist-item {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    gap: 15px;
    align-items: center;
}
.playlist-item:hover {
    background-color: rgba(255, 138, 0, 0.10);
}
.playlist-item.active {
    background-color: rgba(255, 138, 0, 0.18);
    border-right: 4px solid var(--bs-primary);
    box-shadow: inset 0 0 20px rgba(255,138,0,0.08);
}
.playlist-thumb {
    position: relative;
    width: 120px;
    height: 68px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}
.playlist-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.playlist-thumb .duration {
    position: absolute;
    bottom: 4px;
    left: 4px;
    background: rgba(0,0,0,0.8);
    color: white;
    font-size: 0.7rem;
    padding: 2px 4px;
    border-radius: 4px;
}
.playlist-thumb .overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,138,0,0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    opacity: 0;
    transition: var(--transition);
}
.playlist-item.active .playlist-thumb .overlay {
    opacity: 1;
}
</style>

<!-- Load YouTube IFrame Player API code asynchronously -->
<script src="https://www.youtube.com/iframe_api"></script>
<script>
// Real playlist data with video IDs — titles fetched dynamically via YouTube oEmbed
const playlistData = [
    { id: 'ye1YsyrETsQ', title: 'جاري التحميل...', duration: '' },
    { id: 'Qd_Hu8cWF5E', title: 'جاري التحميل...', duration: '' },
    { id: '5aJP9RfamCE', title: 'جاري التحميل...', duration: '' },
    { id: '6-6Y_rTCMG8', title: 'جاري التحميل...', duration: '' },
    { id: 'sEYnW4H5Q7o', title: 'جاري التحميل...', duration: '' },
    { id: 'agKw55HdQAY', title: 'جاري التحميل...', duration: '' },
    { id: 'm1_ifuObDSA', title: 'جاري التحميل...', duration: '' },
    { id: 'uPIk885w6fQ', title: 'جاري التحميل...', duration: '' },
    { id: 'm72nQjH8OsU', title: 'جاري التحميل...', duration: '' },
    { id: 'UoHrAdhZs-g', title: 'جاري التحميل...', duration: '' }
];

let player;
let currentIndex = 0;
let titlesLoaded = false;

// Fetch all real titles from YouTube oEmbed (no API key needed)
async function fetchRealTitles() {
    const fetches = playlistData.map((video, i) =>
        fetch(`https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=${video.id}&format=json`)
            .then(r => r.json())
            .then(data => {
                playlistData[i].title = data.title;
            })
            .catch(() => {
                playlistData[i].title = 'السيرة النبوية - الحلقة ' + (i + 5);
            })
    );
    await Promise.all(fetches);
    titlesLoaded = true;
    renderPlaylist();
    updateUI();
}

function onYouTubeIframeAPIReady() {
    player = new YT.Player('ytplayer', {
        height: '100%',
        width: '100%',
        videoId: playlistData[0].id,
        playerVars: { 'playsinline': 1, 'rel': 0, 'hl': 'ar' },
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}

function onPlayerReady(event) {
    renderPlaylist();
    updateUI();
    fetchRealTitles(); // Load real titles asynchronously
}

function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.ENDED && currentIndex < playlistData.length - 1) {
        playVideo(currentIndex + 1);
    }
}

function playVideo(index) {
    currentIndex = index;
    player.loadVideoById(playlistData[index].id);
    updateUI();
}

function updateUI() {
    document.getElementById('currentVideoTitle').textContent = playlistData[currentIndex].title;
    document.getElementById('playlistCount').textContent = (currentIndex + 1) + ' / ' + playlistData.length;
    document.querySelectorAll('.playlist-item').forEach((el, idx) => {
        el.classList.toggle('active', idx === currentIndex);
        if (idx === currentIndex) el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });
}

function renderPlaylist() {
    const container = document.getElementById('playlistContainer');
    container.innerHTML = '';
    playlistData.forEach((video, index) => {
        const item = document.createElement('div');
        item.className = 'playlist-item' + (index === currentIndex ? ' active' : '');
        item.onclick = () => playVideo(index);
        item.innerHTML =
            '<div class="playlist-thumb">' +
                '<img src="https://img.youtube.com/vi/' + video.id + '/mqdefault.jpg" alt="' + video.title + '">' +
                '<div class="overlay"><i data-lucide="play-circle"></i></div>' +
            '</div>' +
            '<div>' +
                '<h4 class="h6 mb-1 fw-bold text-dark" style="line-height:1.4;">' + video.title + '</h4>' +
                '<small class="text-muted">الشيخ عثمان الخميس</small>' +
            '</div>';
        container.appendChild(item);
    });
    if (typeof lucide !== 'undefined') lucide.createIcons();
}
</script>
