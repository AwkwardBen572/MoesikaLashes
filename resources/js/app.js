const menuToggle = document.getElementById('menu-toggle');
const menuClose = document.getElementById('menu-close');
const mobileMenu = document.getElementById('mobile-menu');

function openMenu() {
    mobileMenu.classList.remove('-translate-y-full');
}

function closeMenu() {
    mobileMenu.classList.add('-translate-y-full');
}

menuToggle?.addEventListener('click', openMenu);
menuClose?.addEventListener('click', closeMenu);
mobileMenu?.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeMenu));

const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.15 });

document.querySelectorAll('.reveal').forEach((el) => revealObserver.observe(el));

// Animate <details class="smooth-details"> open and closed instead of snapping
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

document.querySelectorAll('details.smooth-details').forEach((details) => {
    const summary = details.querySelector('summary');
    const content = summary.nextElementSibling;
    let animation = null;

    details.classList.toggle('is-open', details.open);

    summary.addEventListener('click', (event) => {
        event.preventDefault();

        const opening = !details.classList.contains('is-open');
        details.classList.toggle('is-open', opening);

        if (prefersReducedMotion.matches) {
            details.open = opening;
            return;
        }

        // Start from wherever we are, so a click mid-animation reverses smoothly.
        // A closed <details> still reports its content's full size, so treat closed as zero.
        const startHeight = details.open ? `${content.offsetHeight}px` : '0px';
        const startOpacity = details.open ? getComputedStyle(content).opacity : 0;
        animation?.cancel();

        details.open = true;
        const endHeight = opening ? `${content.scrollHeight}px` : '0px';

        animation = content.animate(
            [{ height: startHeight, opacity: startOpacity }, { height: endHeight, opacity: opening ? 1 : 0 }],
            { duration: 500, easing: 'cubic-bezier(0.4, 0, 0.2, 1)', fill: 'forwards' },
        );
        animation.onfinish = () => {
            details.open = opening;
            animation.cancel();
            animation = null;
        };
    });
});

// Review carousel: fade to the next review every 5 seconds, pausing while hovered or focused
document.querySelectorAll('.review-carousel').forEach((carousel) => {
    const slides = [...carousel.querySelectorAll('[data-slide]')];
    const dots = [...carousel.querySelectorAll('[data-dot]')];
    let current = 0;
    let timer = null;

    if (slides.length < 2) {
        return;
    }

    const show = (index) => {
        current = (index + slides.length) % slides.length;

        slides.forEach((slide, i) => {
            const active = i === current;
            slide.classList.toggle('opacity-0', !active);
            slide.classList.toggle('pointer-events-none', !active);
            slide.inert = !active;
        });

        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-linen-light', i === current);
            dot.classList.toggle('bg-linen-light/30', i !== current);
            dot.setAttribute('aria-current', String(i === current));
        });
    };

    const stop = () => clearInterval(timer);
    const start = () => {
        stop();

        if (!prefersReducedMotion.matches) {
            timer = setInterval(() => show(current + 1), 5000);
        }
    };

    dots.forEach((dot, i) => dot.addEventListener('click', () => {
        show(i);
        start();
    }));

    carousel.addEventListener('mouseenter', stop);
    carousel.addEventListener('mouseleave', start);
    carousel.addEventListener('focusin', stop);
    carousel.addEventListener('focusout', start);

    start();
});
