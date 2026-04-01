(function () {
    // === Funkce pro scroll efekt na .page-header ===
    const header = document.querySelector('.page-header');
    const container = header?.querySelector('div'); // první child div s "container"

    function handleScroll() {
        const scrolled = window.scrollY > 50;

        if (header && container) {
            header.classList.toggle('md:py-10', !scrolled);
            header.classList.toggle('md:py-4', scrolled);

            container.classList.toggle('container', !scrolled);
            container.classList.toggle('w-full', scrolled);

            container.classList.toggle('rounded-xl', !scrolled);
            container.classList.toggle('rounded-bl-none', !scrolled);
        }
    }

    window.addEventListener('scroll', handleScroll);
    handleScroll(); // inicializace

    // === Funkce pro zobrazení submenu u "Služby" ===
    const menuItems = document.querySelectorAll('.menu-item[data-has-submenu="1"]');

    menuItems.forEach((item, index) => {
        const submenu = item.nextElementSibling;

        let showTimeout, hideTimeout;

        if (!submenu) return;

        const showSubmenu = () => {
            clearTimeout(hideTimeout);
            showTimeout = setTimeout(() => {
                submenu.classList.remove('hidden');
            }, 100);
        };

        const hideSubmenu = () => {
            clearTimeout(showTimeout);
            hideTimeout = setTimeout(() => {
                submenu.classList.add('hidden');
            }, 150);
        };

        item.addEventListener('mouseenter', showSubmenu);
        item.addEventListener('mouseleave', hideSubmenu);
        submenu.addEventListener('mouseenter', showSubmenu);
        submenu.addEventListener('mouseleave', hideSubmenu);
    });
})();
