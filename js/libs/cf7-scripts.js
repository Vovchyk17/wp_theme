// Contact Form 7 interactions
const body = document.body;
body.addEventListener('click', (e) => {
    if (e.target.classList.contains('wpcf7-not-valid-tip')) {
        e.target.previousElementSibling.focus();
        e.target.remove();
        body.querySelector('.wpcf7-response-output')?.classList.add('is_temp_hidden');
    }
});

body.addEventListener('focusin', (e) => {
    if (e.target.classList.contains('wpcf7-not-valid')) {
        e.target.nextElementSibling?.remove();
        body.querySelector('.wpcf7-response-output')?.classList.add('is_temp_hidden');
    }
});

document.addEventListener('wpcf7submit', () => {
    body.querySelector('.wpcf7-response-output')?.classList.remove('is_temp_hidden');
});