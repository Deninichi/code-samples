document.addEventListener('DOMContentLoaded', () => {
    new Swiper(".categories-slider", {
        slidesPerView: "auto",
        spaceBetween: 16,
        touch: true,
        mousewheel: true,
        navigation: {
            nextEl: ".categories-slider .swiper-button-next",
            prevEl: ".categories-slider .swiper-button-prev",
        },
        breakpoints: {
            768: {
                spaceBetween: 32,
                mousewheel: false
            }
        }
    });
});
