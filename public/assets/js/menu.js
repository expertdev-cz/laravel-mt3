// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
// Header behavior script
const navbar = document.querySelector('.navbar-custom');
const submenu = document.getElementById('submenu-level2');
const blurOverlay = document.querySelector('.blur-overlay');
const vyrobkyDropdown = document.getElementById('vyrobkyDropdown');

let lastScrollTop = 0;
let isSubmenuOpen = false;

// Function to disable scroll
function disableScroll() {
    // Simply prevent scrolling without changing position
    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';
    
    // Prevent scroll on mobile devices
    document.body.style.touchAction = 'none';
    
    // Add event listener to prevent scroll
    document.addEventListener('wheel', preventScroll, { passive: false });
    document.addEventListener('touchmove', preventScroll, { passive: false });
    document.addEventListener('keydown', preventScrollKeys, { passive: false });
}

// Function to enable scroll
function enableScroll() {
    // Re-enable scrolling
    document.documentElement.style.overflow = '';
    document.body.style.overflow = '';
    document.body.style.touchAction = '';
    
    // Remove event listeners
    document.removeEventListener('wheel', preventScroll);
    document.removeEventListener('touchmove', preventScroll);
    document.removeEventListener('keydown', preventScrollKeys);
}

// Prevent scroll events
function preventScroll(e) {
    e.preventDefault();
    return false;
}

// Prevent scroll with keyboard
function preventScrollKeys(e) {
    const keys = [32, 33, 34, 35, 36, 37, 38, 39, 40]; // spacebar, page up/down, home, end, arrows
    if (keys.includes(e.keyCode)) {
        e.preventDefault();
        return false;
    }
}

// Handle submenu toggle
vyrobkyDropdown.addEventListener('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    isSubmenuOpen = !isSubmenuOpen;
    
    if (isSubmenuOpen) {
        submenu.classList.add('show');
        blurOverlay.classList.add('show');
        navbar.classList.remove('transparent');
        navbar.classList.add('white-bg');
        vyrobkyDropdown.classList.add('fw-bold');
        document.getElementById('vyrobky-arrow').style.transform = 'rotate(180deg)';
        disableScroll(); // Disable scroll when submenu opens
    } else {
        closeSubmenu();
    }
});

// Close submenu when clicking outside
document.addEventListener('click', function(e) {
    if (isSubmenuOpen && !submenu.contains(e.target) && !vyrobkyDropdown.contains(e.target)) {
        closeSubmenu();
    }
});

// Close submenu function
function closeSubmenu() {
    isSubmenuOpen = false;
    submenu.classList.remove('show');
    blurOverlay.classList.remove('show');
    vyrobkyDropdown.classList.remove('fw-bold');
    document.getElementById('vyrobky-arrow').style.transform = 'rotate(0deg)';
    enableScroll(); // Re-enable scroll when submenu closes
    
    // Return to transparent if at top of page
    if (window.scrollY === 0) {
        navbar.classList.add('transparent');
        navbar.classList.remove('white-bg');
    }
}

// Scroll behavior
window.addEventListener('scroll', function() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    // Make header white when scrolled
    if (scrollTop > 0) {
        navbar.classList.remove('transparent');
        navbar.classList.add('white-bg');
    } else if (!isSubmenuOpen) {
        navbar.classList.add('transparent');
        navbar.classList.remove('white-bg');
    }
    
    // Hide/show header based on scroll direction
    if (scrollTop > lastScrollTop && scrollTop > 100) {
        // Scrolling down - hide header
        navbar.classList.add('hidden');
    } else {
        // Scrolling up - show header
        navbar.classList.remove('hidden');
    }
    
    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
}, false);

// Language dropdown
let currentLang = 'CZ';
function updateLangDropdown() {
    document.querySelectorAll('.dropdown-item').forEach(item => {
        const val = item.getAttribute('data-value');
        item.parentElement.style.display = val === currentLang ? 'none' : '';
    });
}
// Hide current language on initial load
updateLangDropdown();
document.querySelectorAll('.dropdown-item').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        currentLang = this.getAttribute('data-value');
        const btn = document.getElementById('langDropdown');
        btn.style.opacity = '0';
        setTimeout(function() {
            btn.innerHTML = currentLang + '  <img src="media/icons/select_icon.svg" alt="Select" class="ms-1 mb-1" style="height: 8px;">';
            updateLangDropdown();
            btn.style.opacity = '1';
        }, 180);
    });
});

// Scroll-in animation observer
// This should work now without conflicts
const scrollObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('scroll-in-visible');
            // Optional: unobserve after animation
            // scrollObserver.unobserve(entry.target);
        }
    });
}, {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
});

// Observe all scroll-in elements
document.querySelectorAll('.scroll-in').forEach(el => {
    scrollObserver.observe(el);
});

// Icon hover swap interaction
document.querySelectorAll('.icon-hover-group').forEach(group => {
    const items = group.querySelectorAll('.icon-hover-item');
    items.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.querySelector('img').src = this.dataset.hover;
            items.forEach(other => {
                if (other !== this) other.classList.add('icon-faded');
            });
        });
        item.addEventListener('mouseleave', function() {
            this.querySelector('img').src = this.dataset.default;
            items.forEach(other => other.classList.remove('icon-faded'));
        });
    });
});

}); 