(function () {
    'use strict';

    function initProfileMenu() {
        var root = document.querySelector('[data-admin-profile-menu]');
        if (!root) return;

        var trigger = root.querySelector('[data-admin-profile-trigger]');
        var menu = root.querySelector('[data-admin-profile-dropdown]');
        if (!trigger || !menu) return;

        // Keep the fixed popover outside the transformed mobile nav stacking context.
        document.body.appendChild(menu);

        function positionMenu() {
            var rect = trigger.getBoundingClientRect();
            var width = menu.getBoundingClientRect().width || Math.min(320, window.innerWidth - 24);
            var right = Math.max(12, window.innerWidth - rect.right);
            if (right + width > window.innerWidth - 8) right = 8;
            menu.style.right = right + 'px';

            var viewportHeight = Math.max(120, window.innerHeight - 16);
            menu.style.maxHeight = viewportHeight + 'px';
            var menuHeight = Math.min(menu.scrollHeight, viewportHeight);
            var top = rect.bottom + 8;
            if (top + menuHeight > window.innerHeight - 8 && rect.top > menuHeight + 16) {
                top = rect.top - menuHeight - 8;
            }
            menu.style.top = Math.max(8, Math.min(top, window.innerHeight - menuHeight - 8)) + 'px';
        }

        function openMenu() {
            menu.hidden = false;
            trigger.setAttribute('aria-expanded', 'true');
            positionMenu();
        }

        function closeMenu(returnFocus) {
            menu.hidden = true;
            trigger.setAttribute('aria-expanded', 'false');
            if (returnFocus) trigger.focus();
        }

        trigger.addEventListener('click', function (event) {
            event.preventDefault();
            if (menu.hidden) openMenu(); else closeMenu(false);
        });

        document.addEventListener('click', function (event) {
            if (!menu.hidden && !root.contains(event.target) && !menu.contains(event.target)) closeMenu(false);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !menu.hidden) closeMenu(true);
        });

        window.addEventListener('resize', function () {
            if (!menu.hidden) positionMenu();
        });
        window.addEventListener('scroll', function () {
            if (!menu.hidden) positionMenu();
        }, true);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProfileMenu);
    } else {
        initProfileMenu();
    }
}());
