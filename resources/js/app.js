import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

const scrollLocks = new Set();

const updateScrollLock = () => {
    const locked = scrollLocks.size > 0;

    document.documentElement.classList.toggle('overflow-hidden', locked);
    document.body.classList.toggle('overflow-hidden', locked);
};

Alpine.directive('scroll-lock', (el, { expression }, { cleanup, effect, evaluate }) => {
    const lockId = Symbol('scroll-lock');
    let locked = false;

    const setLocked = (shouldLock) => {
        if (shouldLock === locked) {
            return;
        }

        locked = shouldLock;

        if (locked) {
            scrollLocks.add(lockId);
        } else {
            scrollLocks.delete(lockId);
        }

        updateScrollLock();
    };

    effect(() => {
        setLocked(Boolean(evaluate(expression)));
    });

    cleanup(() => {
        scrollLocks.delete(lockId);
        updateScrollLock();
    });
});

Alpine.start();
