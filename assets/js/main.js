document.addEventListener('DOMContentLoaded', () => {
    // Initialize AOS animations
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            offset: 50,
        });
    }

    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // ── Theme Toggle ─────────────────────────────────────────────────────────
    const themeToggleBtn = document.getElementById('theme-toggle');
    if (themeToggleBtn) {
        const themeIcon = themeToggleBtn.querySelector('i[data-lucide]');

        /**
         * Apply the given theme ('light' or 'dark') to the document.
         * Updates the icon accordingly.
         */
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            if (themeIcon) {
                // Sun icon = currently in dark mode (click to go light)
                // Moon icon = currently in light mode (click to go dark)
                themeIcon.setAttribute('data-lucide', theme === 'dark' ? 'sun' : 'moon');
            }
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }

        // Determine initial theme:
        // 1. User's saved preference
        // 2. System preference
        // 3. Default: light (day mode)
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark' || savedTheme === 'light') {
            applyTheme(savedTheme);
        } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            applyTheme('dark');
        } else {
            applyTheme('light');
        }

        // Toggle on click
        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            applyTheme(newTheme);
            localStorage.setItem('theme', newTheme);
        });
    }
});
