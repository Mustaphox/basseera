/**
 * Quran Audio Player and Settings Manager
 */
class QuranManager {
    constructor() {
        this.audioPlayer = document.getElementById('quranAudio');
        this.currentAyahIndex = 0;
        this.audioData = [];
        this.isRepeating = false;
        this.autoPlayNextSurah = true;
        this.playbackSpeed = 1.0;
        
        // Settings defaults
        this.settings = {
            fontSize: 2.5, // rem
            lineHeight: 2.5,
            theme: localStorage.getItem('theme') || 'light'
        };

        this.bookmarks = JSON.parse(localStorage.getItem('quran_bookmarks')) || {
            ayahs: [],
            surahs: [],
            lastRead: null
        };

        this.init();
    }

    init() {
        this.loadSettings();
        this.setupAudioListeners();
        this.setupSettingsListeners();
    }

    // --- Audio Player --- //

    setAudioData(data, startIndex = 0) {
        this.audioData = data;
        this.currentAyahIndex = startIndex;
        if(this.audioData.length > 0) {
            this.loadAyahAudio(startIndex);
        }
    }

    loadAyahAudio(index) {
        if (!this.audioData[index]) return;
        this.currentAyahIndex = index;
        this.audioPlayer.src = this.audioData[index].audio;
        this.audioPlayer.playbackRate = this.playbackSpeed;
        this.highlightAyah(index);
        this.updateMiniPlayerInfo();
    }

    play() {
        if (this.audioPlayer.src) {
            this.audioPlayer.play();
            this.updatePlayPauseUI(true);
        }
    }

    pause() {
        this.audioPlayer.pause();
        this.updatePlayPauseUI(false);
    }

    togglePlay() {
        if (this.audioPlayer.paused) this.play();
        else this.pause();
    }

    nextAyah() {
        if (this.currentAyahIndex < this.audioData.length - 1) {
            this.loadAyahAudio(this.currentAyahIndex + 1);
            this.play();
        } else if (this.autoPlayNextSurah) {
            // Logic to redirect to next surah
            const currentSurah = parseInt(document.body.dataset.surahId) || 1;
            if (currentSurah < 114) {
                window.location.href = `?id=\${currentSurah + 1}&listen=true`;
            }
        }
    }

    prevAyah() {
        if (this.currentAyahIndex > 0) {
            this.loadAyahAudio(this.currentAyahIndex - 1);
            this.play();
        }
    }

    setSpeed(speed) {
        this.playbackSpeed = speed;
        this.audioPlayer.playbackRate = speed;
    }

    toggleRepeat() {
        this.isRepeating = !this.isRepeating;
        // Update UI button state here
    }

    setupAudioListeners() {
        if (!this.audioPlayer) return;

        this.audioPlayer.addEventListener('ended', () => {
            if (this.isRepeating) {
                this.play();
            } else {
                this.nextAyah();
            }
        });

        this.audioPlayer.addEventListener('timeupdate', () => {
            const progress = (this.audioPlayer.currentTime / this.audioPlayer.duration) * 100;
            const bar = document.getElementById('audioProgressBar');
            if(bar) bar.style.width = `\${progress}%`;
            
            const timeStr = this.formatTime(this.audioPlayer.currentTime) + ' / ' + this.formatTime(this.audioPlayer.duration);
            const timeDisplay = document.getElementById('audioTimeDisplay');
            if(timeDisplay) timeDisplay.textContent = timeStr;
        });
    }

    formatTime(seconds) {
        if(isNaN(seconds)) return "0:00";
        const m = Math.floor(seconds / 60);
        const s = Math.floor(seconds % 60);
        return `\${m}:\${s < 10 ? '0' : ''}\${s}`;
    }

    updatePlayPauseUI(isPlaying) {
        document.querySelectorAll('.play-pause-btn i').forEach(icon => {
            icon.setAttribute('data-lucide', isPlaying ? 'pause' : 'play');
        });
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    highlightAyah(index) {
        document.querySelectorAll('.ayah-box').forEach(el => el.classList.remove('active-audio'));
        const el = document.getElementById(`ayah-\${index}`);
        if (el) {
            el.classList.add('active-audio');
            // Smooth scroll to element, centering it
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Save last read
            const surahId = document.body.dataset.surahId;
            const ayahNum = el.dataset.numberInSurah;
            if(surahId) this.saveLastRead(surahId, ayahNum);
        }
    }

    updateMiniPlayerInfo() {
        const titleEl = document.getElementById('miniPlayerTitle');
        if (titleEl && this.audioData[this.currentAyahIndex]) {
            titleEl.textContent = `الآية \${this.audioData[this.currentAyahIndex].numberInSurah}`;
        }
    }

    // --- Bookmarks & Storage --- //

    saveLastRead(surahId, ayahNumber) {
        this.bookmarks.lastRead = { surah: surahId, ayah: ayahNumber, timestamp: new Date().getTime() };
        this.saveBookmarks();
    }

    toggleAyahBookmark(surahId, ayahNumber, text) {
        const id = `\${surahId}-\${ayahNumber}`;
        const existing = this.bookmarks.ayahs.findIndex(b => b.id === id);
        
        if (existing > -1) {
            this.bookmarks.ayahs.splice(existing, 1);
        } else {
            this.bookmarks.ayahs.push({ id, surah: surahId, ayah: ayahNumber, text, timestamp: new Date().getTime() });
        }
        this.saveBookmarks();
        return existing === -1; // returns true if added
    }

    isAyahBookmarked(surahId, ayahNumber) {
        const id = `\${surahId}-\${ayahNumber}`;
        return this.bookmarks.ayahs.some(b => b.id === id);
    }

    saveBookmarks() {
        localStorage.setItem('quran_bookmarks', JSON.stringify(this.bookmarks));
    }

    getRecentlyRead() {
        return this.bookmarks.lastRead;
    }

    // --- Reading Settings --- //

    loadSettings() {
        const savedSettings = localStorage.getItem('quran_settings');
        if (savedSettings) {
            this.settings = { ...this.settings, ...JSON.parse(savedSettings) };
        }
        this.applySettings();
    }

    saveSettings() {
        localStorage.setItem('quran_settings', JSON.stringify(this.settings));
        this.applySettings();
    }

    applySettings() {
        const container = document.getElementById('quranTextContainer');
        if (container) {
            container.style.fontSize = `\${this.settings.fontSize}rem`;
            container.style.lineHeight = this.settings.lineHeight;
        }
        
        // Theme is handled by main.js but we can trigger it if needed
        if (this.settings.theme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
        }
    }

    changeFontSize(delta) {
        this.settings.fontSize = Math.max(1.5, Math.min(5.0, this.settings.fontSize + delta));
        this.saveSettings();
    }

    setupSettingsListeners() {
        const increaseBtn = document.getElementById('increaseFontBtn');
        const decreaseBtn = document.getElementById('decreaseFontBtn');
        
        if (increaseBtn) increaseBtn.addEventListener('click', () => this.changeFontSize(0.2));
        if (decreaseBtn) decreaseBtn.addEventListener('click', () => this.changeFontSize(-0.2));
    }
}

// Global instance
window.quranApp = new QuranManager();
