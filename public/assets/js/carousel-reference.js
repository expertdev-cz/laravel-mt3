 // Carousel – skutečný nekonečný loop
                // Struktura track: [klon4, klon5, item1, item2, item3, item4, item5, klon1, klon2]
                const numClonesBefore = 2; // počet klonů na začátku
                const numRealItems = 5;    // počet reálných položek
                let currentIndex = numClonesBefore; // začínáme na první reálné položce

                const track = document.querySelector('.carousel-track');
                const items = document.querySelectorAll('.carousel-item-custom');

                function moveCarousel(direction) {
                    currentIndex += direction;
                    updateCarousel();

                    // Po dokončení animace tiše přeskočíme na reálnou položku (pokud jsme na klonu)
                    setTimeout(() => {
                        if (currentIndex >= numClonesBefore + numRealItems) {
                            track.style.transition = 'none';
                            currentIndex -= numRealItems;
                            updateCarousel();
                            setTimeout(() => { track.style.transition = 'transform 0.5s ease'; }, 50);
                        } else if (currentIndex < numClonesBefore) {
                            track.style.transition = 'none';
                            currentIndex += numRealItems;
                            updateCarousel();
                            setTimeout(() => { track.style.transition = 'transform 0.5s ease'; }, 50);
                        }
                    }, 500);
                }

                function updateCarousel() {
                    const itemWidth = items[0].offsetWidth;
                    const gap = 32; // 2rem gap
                    const containerWidth = track.parentElement.parentElement.offsetWidth;
                    const centerOffset = (containerWidth - itemWidth) / 2;
                    const offset = centerOffset - (currentIndex * (itemWidth + gap));
                    track.style.transform = `translateX(${offset}px)`;
                }

                document.addEventListener('DOMContentLoaded', function () {
                    updateCarousel();
                    window.addEventListener('resize', updateCarousel);
                });