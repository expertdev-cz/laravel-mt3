(function () {
    function initFooterLangSwitcher() {
        const langSwitcherBtn = document.getElementById('footer-lng-switcher-btn');
        const langIconsContainer = document.getElementById('footer-lang-icons');

        if (!langSwitcherBtn || !langIconsContainer) return;

        langSwitcherBtn.addEventListener('click', function () {
            langIconsContainer.classList.toggle('open');
        });

        // Close when clicking outside
        document.addEventListener('click', function (e) {
            if (!langIconsContainer.contains(e.target) && e.target !== langSwitcherBtn) {
                langIconsContainer.classList.remove('open');
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFooterLangSwitcher);
    } else {
        initFooterLangSwitcher();
    }
})();
