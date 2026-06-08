       let _animaceTimeouts = [];

            function startAnimace() {
                const heading = document.querySelector(".video-heading");
                const description = document.querySelector(".video-description");
                const scroll = document.querySelector(".video-scroll");
                const video = document.querySelector(".video-bg");

                heading.classList.remove("show", "hide");
                description.classList.remove("show");
                scroll.classList.remove("show", "pulsing");
                document.querySelectorAll(".video-icon-extra").forEach(el => el.classList.remove("show"));

                video.currentTime = 0;
                video.play();

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
                _animaceTimeouts.forEach(id => clearTimeout(id));
                _animaceTimeouts = [];
                if (_fadeTimeout) { clearTimeout(_fadeTimeout); _fadeTimeout = null; }

                const fadeDuration = 550;

                const elements = [];
                [".video-heading", ".video-description", ".video-scroll"].forEach(sel => {
                    const el = document.querySelector(sel);
                    if (el && (el.classList.contains("show") || el.classList.contains("hide"))) {
                        elements.push(el);
                    }
                });
                document.querySelectorAll(".video-icon-extra").forEach(el => {
                    if (el.classList.contains("show")) elements.push(el);
                });

                if (elements.length === 0) {
                    startAnimace();
                    return;
                }

                elements.forEach(el => {
                    el.style.transition = `opacity ${fadeDuration}ms ease`;
                    el.style.opacity = "0";
                });

                _fadeTimeout = setTimeout(() => {
                    elements.forEach(el => {
                        el.style.transition = "";
                        el.style.opacity = "";
                    });
                    _fadeTimeout = null;
                    startAnimace();
                }, fadeDuration + 50);
            }

            document.addEventListener("DOMContentLoaded", startAnimace);

            document.addEventListener("DOMContentLoaded", function () {
                const video = document.querySelector(".video-bg");

                video.addEventListener("pause", function () {
                    if (!video.ended && !video.seeking) {
                        video.play();
                    }
                });

                document.addEventListener("visibilitychange", function () {
                    if (!document.hidden && video.paused && !video.ended) {
                        video.play();
                    }
                });

                let scrollTimeout;
                document.addEventListener("scroll", function () {
                    clearTimeout(scrollTimeout);
                    scrollTimeout = setTimeout(() => {
                        if (video.paused && !video.ended) {
                            video.play();
                        }
                    }, 50);
                });
            });