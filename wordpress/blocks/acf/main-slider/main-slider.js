document.addEventListener('DOMContentLoaded', () => {
    const initMainSlider = () => {
        const mainSliderWrapper = document.querySelector('[data-main-slider]');
        if (!mainSliderWrapper) return;

        const preloaderIcon = `
            <div class="autoplay-progress">
                <svg viewBox="0 0 48 48"><circle cx="24" cy="24" r="20"></circle></svg>
            </div>
        `;

        const swiper = new Swiper(mainSliderWrapper, {
            loop: true,
            effect: 'fade',
            autoplay: {
                delay: 7000,
                disableOnInteraction: false,
            },
            pagination: {
                el: "[data-main-slider-pagination]",
                clickable: false,
                renderBullet: function (index, className) {
                    return `
                        <span class="${className}">
                            <strong>${index + 1}</strong>
                            ${preloaderIcon}
                        </span>
                    `;
                }
            },
            on: {
                slideChangeTransitionStart: function () {
                    document.querySelectorAll(".animate-item").forEach(item => {
                        item.style.opacity = "0";
                        item.style.transform = "translateY(30px)";
                    });
                },
                slideChangeTransitionEnd: function () {
                    const activeSlide = document.querySelector(".swiper-slide-active");
                    activeSlide.querySelectorAll(".animate-item").forEach((item, index) => {
                        setTimeout(() => {
                            item.style.opacity = "1";
                            item.style.transform = "translateY(0)";
                        }, index * 100);
                    });
                },
                autoplayTimeLeft: function (swiper, time, progress) {
                    const progressCircles = document.querySelectorAll(".autoplay-progress svg");
                    if (!progressCircles) return;
                    progressCircles.forEach(progressCircle => {
                        progressCircle.style.setProperty("--progress", 1 - progress);
                    });
                }
            }
        });

        const cursor = document.createElement('div');
        cursor.classList.add('custom-cursor');

        cursor.innerHTML = `
            <svg class="arrow-icon left" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <path d="M15 6L9 12L15 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <svg class="arrow-icon right" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <path d="M9 6L15 12L9 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            ${preloaderIcon}
        `;

        mainSliderWrapper.appendChild(cursor);

        mainSliderWrapper.addEventListener('click', (event) => {
            const { left, width } = mainSliderWrapper.getBoundingClientRect();
            const middle = left + width / 2;

            if (event.clientX < middle) {
                swiper.slidePrev();
            } else {
                swiper.slideNext();
            }
        });

        mainSliderWrapper.addEventListener('mousemove', (event) => {
            const slide = event.target.closest('[data-main-slider-slide]');
            const pagination = event.target.closest('[data-main-slider-pagination]');
            const link = event.target.closest('a');

            if (pagination || link) {
                cursor.style.opacity = '0';
                return;
            }

            if (!slide) return;

            const { left, width } = slide.getBoundingClientRect();
            const middle = left + width / 2;

            cursor.style.top = `${event.clientY - mainSliderWrapper.getBoundingClientRect().top}px`;
            cursor.style.left = `${event.clientX - mainSliderWrapper.getBoundingClientRect().left}px`;

            if (event.clientX < middle) {
                cursor.querySelector('.left').style.display = 'block';
                cursor.querySelector('.right').style.display = 'none';
            } else {
                cursor.querySelector('.left').style.display = 'none';
                cursor.querySelector('.right').style.display = 'block';
            }

            cursor.style.opacity = '1';
        });

        mainSliderWrapper.addEventListener('mouseleave', () => {
            cursor.style.opacity = '0';
        });

        document.querySelectorAll('[data-main-slider-slide]').forEach(slide => {
            slide.style.cursor = 'none';
        });
    };

    initMainSlider();
});
