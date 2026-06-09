// Carousel – nekonečný loop
document.addEventListener('DOMContentLoaded', function () {
    const track = document.querySelector('.carousel-track');
    if (!track) return;

    const realItems = Array.from(track.querySelectorAll('.carousel-item-custom'));
    const numReal = realItems.length;
    if (numReal === 0) return;

    // Klonujeme všechny reálné položky na obě strany
    for (let i = 0; i < numReal; i++) {
        const clone = realItems[i].cloneNode(true);
        clone.setAttribute('aria-hidden', 'true');
        track.appendChild(clone);
    }
    for (let i = numReal - 1; i >= 0; i--) {
        const clone = realItems[i].cloneNode(true);
        clone.setAttribute('aria-hidden', 'true');
        track.insertBefore(clone, track.firstChild);
    }

    const allItems = Array.from(track.querySelectorAll('.carousel-item-custom'));
    let current = numReal; // začínáme na první reálné položce
    let locked = false;

    function calcOffset() {
        const itemWidth = allItems[0].offsetWidth;
        const gap = 32; // 2rem
        const containerWidth = track.parentElement.offsetWidth;
        const center = (containerWidth - itemWidth) / 2;
        return center - current * (itemWidth + gap);
    }

    function setPosition(animated) {
        const offset = calcOffset();
        if (!animated) {
            track.style.transition = 'none';
            track.style.transform = `translateX(${offset}px)`;
            // Dvojitý requestAnimationFrame zajistí že prohlížeč překreslí snímek
            // s transition:none ještě před tím, než ji znovu zapneme
            requestAnimationFrame(() => requestAnimationFrame(() => {
                track.style.transition = 'transform 0.5s ease';
            }));
        } else {
            track.style.transition = 'transform 0.5s ease';
            track.style.transform = `translateX(${offset}px)`;
        }
    }

    track.addEventListener('transitionend', function () {
        // Po dokončení animace opravíme index pokud jsme v oblasti klonů
        if (current >= numReal + numReal) {
            current -= numReal;
            setPosition(false);
        } else if (current < numReal) {
            current += numReal;
            setPosition(false);
        }
        locked = false;
    });

    window.moveCarousel = function (direction) {
        if (locked) return;
        locked = true;
        current += direction;
        setPosition(true);
    };

    setPosition(false);
    window.addEventListener('resize', () => setPosition(false));
});
