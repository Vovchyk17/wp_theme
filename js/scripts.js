
// control :focus when using mouse/keyboard
document.body.addEventListener('mousedown', function() {
    document.body.classList.add('is_using_mouse');
});
document.body.addEventListener('keydown', function() {
    document.body.classList.remove('is_using_mouse');
});

document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    // variables
    const body = document.body;
    const header = document.querySelector('header');
    const menuToggle = document.querySelector('.menu__toggle');
    const menuPrimary = document.querySelector('.menu__primary');
    const menuParents = menuPrimary.querySelectorAll('.menu-item-has-children > a');

    // hamburger + menu
    menuToggle.addEventListener('click', () => {
        menuToggle.classList.toggle('is_active');
        menuPrimary.classList.toggle('is_open');
        body.classList.toggle('is_overflow');
    });

    // close menu with Esc key
    body.addEventListener('keyup', (e) => {
        if (e.key === 'Escape' && menuToggle.classList.contains('is_active')) {
            menuToggle.click();
            document.querySelector('a[href="#main"]').focus();
        }
    });

    // open/close sub-menu with Tab key
    menuParents.forEach(parent => {
        parent.addEventListener('focus', () => {
            parent.parentElement.classList.add('is_focused');
        });

        const submenu = parent.nextElementSibling;
        if (submenu && submenu.classList.contains('sub-menu')) {
            const links = submenu.querySelectorAll('li > a');
            const lastLink = links[links.length - 1];
            lastLink.addEventListener('blur', () => {
                parent.parentElement.classList.remove('is_focused');
            });
        }
    });

    // Append "plus" element in sub-menu parent item
    menuParents.forEach(parent => {
        const toggle = document.createElement('span');
        toggle.className = 'rwd_show';
        toggle.tabIndex = 0;
        toggle.setAttribute('role', 'button');
        toggle.setAttribute('aria-label', 'Sub-menu toggle');
        toggle.setAttribute('aria-expanded', 'false');
        parent.insertAdjacentElement('afterend', toggle);
    });

    function toggleSubMenu(element) {
        const expanded = element.getAttribute('aria-expanded') === 'true';
        element.setAttribute('aria-expanded', !expanded);
        element.classList.toggle('is_open');
        element.nextElementSibling.style.display = expanded ? 'none' : 'block';
    }

    menuPrimary.addEventListener('click', (e) => {
        if (e.target.matches('[aria-label="Sub-menu toggle"]')) {
            toggleSubMenu(e.target);
        }
    });

    menuPrimary.addEventListener('keyup', (e) => {
        if (e.target.matches('[aria-label="Sub-menu toggle"]') && e.key === 'Enter') {
            toggleSubMenu(e.target);
        }
    });

    // header sticky on scroll
    const toggleStickyHeader = () => {
        if (window.scrollY > 5) {
            header.classList.add('is_sticky');
        } else {
            header.classList.remove('is_sticky');
        }
    };
    window.addEventListener('scroll', toggleStickyHeader);
    toggleStickyHeader();

    // scroll to
    document.querySelectorAll('a[data-scrollto]').forEach(link => {
        link.addEventListener('click', (e) => {
            const anchor = document.querySelector(link.dataset.scrollto);
            if (anchor) {
                e.preventDefault();
                window.scrollTo({
                    top: anchor.offsetTop - header.offsetHeight,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Wrap tables for responsive design
    document.querySelectorAll('.content table').forEach(table => {
        const wrapper = document.createElement('div');
        wrapper.className = 'table_wrapper';
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    });

    // Check if paragraph is empty
    document.querySelectorAll('p').forEach(p => {
        if (p.innerHTML.replace(/\s|&nbsp;/g, '').length === 0) {
            p.classList.add('j_empty');
        }
    });

    //fancybox init
    Fancybox.bind("[data-fancybox]");

    document.querySelectorAll('.content iframe').forEach(iframe => {
        const parent = iframe.parentElement;
        if ((parent.tagName === 'P' || parent.tagName === 'SPAN') && !parent.classList.contains('full_frame')) {
            parent.classList.add('full_frame');
        }
    });

});