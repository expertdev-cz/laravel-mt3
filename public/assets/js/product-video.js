
            let _animaceTimeouts = [];

            function startAnimace() {
                const heading = document.querySelector(".video-heading");
                const description = document.querySelector(".video-description-right");
                const scroll = document.querySelector(".video-scroll");
                const video = document.querySelector(".video-bg");

                // Reset stavu
                heading.classList.remove("show", "hide");
                description.classList.remove("show");
                scroll.classList.remove("show", "pulsing");
                document.querySelectorAll(".video-icon-extra").forEach(el => el.classList.remove("show"));

                // Restart videa
                video.currentTime = 0;
                video.play();

                // Sekvence animací
                _animaceTimeouts.push(setTimeout(() => {
                    heading.classList.add("show");
                }, 100));

                _animaceTimeouts.push(setTimeout(() => {
                    heading.classList.remove("show");
                    heading.classList.add("hide");
                }, 3500));

                _animaceTimeouts.push(setTimeout(() => {
                    description.classList.add("show");
                }, 6000));

                _animaceTimeouts.push(setTimeout(() => {
                    scroll.classList.add("show", "pulsing");
                    document.querySelectorAll(".video-icon-extra").forEach(el => el.classList.add("show"));
                }, 12000));
            }

            let _fadeTimeout = null;

            function restartAnimace() {
                // Zrušení probíhajících timeoutů
                _animaceTimeouts.forEach(id => clearTimeout(id));
                _animaceTimeouts = [];
                if (_fadeTimeout) { clearTimeout(_fadeTimeout); _fadeTimeout = null; }

                const fadeDuration = 550;

                // Sbír všech viditelných prvků
                const elements = [];
                ['.video-heading', '.video-description-right', '.video-scroll'].forEach(sel => {
                    const el = document.querySelector(sel);
                    if (el && (el.classList.contains('show') || el.classList.contains('hide'))) {
                        elements.push(el);
                    }
                });
                document.querySelectorAll('.video-icon-extra').forEach(el => {
                    if (el.classList.contains('show')) elements.push(el);
                });

                if (elements.length === 0) {
                    startAnimace();
                    return;
                }

                // Fade out všech viditelných prvků
                elements.forEach(el => {
                    el.style.transition = `opacity ${fadeDuration}ms ease`;
                    el.style.opacity = '0';
                });

                // Po fade outu restartni animaci
                _fadeTimeout = setTimeout(() => {
                    elements.forEach(el => {
                        el.style.transition = '';
                        el.style.opacity = '';
                    });
                    _fadeTimeout = null;
                    startAnimace();
                }, fadeDuration + 50);
            }

            document.addEventListener("DOMContentLoaded", startAnimace);
  
            document.addEventListener('DOMContentLoaded', function () {
                const video = document.querySelector('.video-bg');

                // Prevent the browser from auto-pausing the video
                video.addEventListener('pause', function (e) {
                    // Only prevent pause if it wasn't manually paused and video hasn't ended
                    if (!video.ended && !video.seeking) {
                        video.play();
                    }
                });

                // Also handle visibility changes (when tab becomes inactive)
                document.addEventListener('visibilitychange', function () {
                    if (!document.hidden && video.paused && !video.ended) {
                        video.play();
                    }
                });

                // Handle scroll-based pausing
                let scrollTimeout;
                document.addEventListener('scroll', function () {
                    clearTimeout(scrollTimeout);
                    scrollTimeout = setTimeout(() => {
                        if (video.paused && !video.ended) {
                            video.play();
                        }
                    }, 50);
                });
            });
   