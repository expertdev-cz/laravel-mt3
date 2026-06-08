// Carousel – skutečný nekonečný loop
// Klony jsou generovány dynamicky, Blade renderuje pouze reálné položky.

document.addEventListener('DOMContentLoaded', function () {
    const track = document.querySelector('.carousel-track');
    if (!track) return;

    const realItems = Array.from(track.querySelectorAll('.carousel-item-custom'));
    const numRealItems = realItems.length;
    if (numRealItems === 0) return;

    const numClones = Math.min(2, numRealItems);

    // Přidat klony na konec (kopie prvních N reálných položek)
    for (let i = 0; i < numClones; i++) {
        const clone = realItems[i].cloneNode(true);
        clone.setAttribute('aria-hidden', 'true');
        track.appendChild(clone);
    }

    // Přidat klony na začátek (kopie posledních N reálných položek) — v obráceném pořadí
    for (let i = numClones - 1; i >= 0; i--) {
        const clone = realItems[numRealItems - 1 - i].cloneNode(true);
        clone.setAttribute('aria-hidden', 'true');
        track.insertBefore(clone, track.firstChild);
    }

    const allItems = track.querySelectorAll('.carousel-item-custom');
    let currentIndex = numClones; // začínáme na první reálné položce

    function updateCarousel(animated) {
        if (animated === false) {
            track.style.transition = 'none';
        }
        const itemWidth = allItems[0].offsetWidth;
        const gap = 32; // 2rem
        const containerWidth = track.parentElement.parentElement.offsetWidth;
        const centerOffset = (containerWidth - itemWidth) / 2;
        const offset = centerOffset - (currentIndex * (itemWidth + gap));
        track.style.transform = `translateX(${offset}px)`;
    }

    window.moveCarousel = function (direction) {
        currentIndex += direction;
        track.style.transition = 'transform 0.5s ease';
        updateCarousel();

        setTimeout(() => {
            if (currentIndex >= numClones + numRealItems) {
                currentIndex -= numRealItems;
                updateCarousel(false);
                setTimeout(() => { track.style.transition = 'transform 0.5s ease'; }, 50);
            } else if (currentIndex < numClones) {
                currentIndex += numRealItems;
                updateCarousel(false);
                setTimeout(() => { track.style.transition = 'transform 0.5s ease'; }, 50);
            }
        }, 500);
    };

    updateCarousel(false);
    window.addEventListener('resize', () => updateCarousel(false));
});
