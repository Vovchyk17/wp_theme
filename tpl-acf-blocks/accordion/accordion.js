document.addEventListener('DOMContentLoaded', () => {
    const toggleAccordion = (elem) => {
        const isExpanded = elem.getAttribute('aria-expanded') === 'true';
        const isHidden = elem.nextElementSibling.getAttribute('aria-hidden') === 'true';

        elem.setAttribute('aria-expanded', !isExpanded);
        elem.nextElementSibling.setAttribute('aria-hidden', !isHidden);
        elem.classList.toggle('is_open');
        elem.nextElementSibling.style.display = isHidden ? 'block' : 'none';
        elem.querySelector('.block__accordion_title__icon').classList.toggle('i_chevron_up');
        elem.querySelector('.block__accordion_title__icon').classList.toggle('i_chevron_down');
    };

    document.querySelectorAll('.acc_title').forEach((title) => {
        title.addEventListener('click', () => {
            toggleAccordion(title);
        });

        title.addEventListener('keyup', (e) => {
            if (e.keyCode === 13) {
                toggleAccordion(title);
            }
        });
    });
});