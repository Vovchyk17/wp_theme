document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.block__custom_slider').forEach(swiperWrapper => {
        const swiperContainer = swiperWrapper.querySelector('.swiper');
        const next = swiperWrapper.querySelector('.sw_next');
        const prev = swiperWrapper.querySelector('.sw_prev');
        const pagination = swiperWrapper.querySelector('.sw_pagination');

        const swiper = new Swiper(swiperContainer, {
            navigation: {
                nextEl: next,
                prevEl: prev
            },
            pagination: {
                el: pagination,
                type: 'bullets',
                clickable: true
            },
            loop: true,
            speed: 600,
            grabCursor: true,
            effect: "creative",
            creativeEffect: {
                prev: {
                    translate: ["-20%", 0, -1],
                },
                next: {
                    translate: ["100%", 0, 0],
                },
            },
        });
    });
});
