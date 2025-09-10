document.addEventListener('DOMContentLoaded', () => {
    new Swiper(".best-sellers-slider", {
        slidesPerView: "auto",
        spaceBetween: 16,
        touch: true,
        mousewheel: true,
        navigation: {
            nextEl: ".best-sellers-slider .swiper-button-next",
            prevEl: ".best-sellers-slider .swiper-button-prev",
        },
        breakpoints: {
            768: {
                spaceBetween: 32,
                mousewheel: false
            }
        }
    });
});
