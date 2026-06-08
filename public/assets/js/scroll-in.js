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