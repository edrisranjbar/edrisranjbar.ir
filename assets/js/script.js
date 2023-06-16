document.addEventListener('DOMContentLoaded', function () {
    let splide = new Splide('.splide', {
        perPage: 2,
        direction: 'rtl',
        gap: '16px',
        arrows: false,
        pagination: false
    });

    splide.mount();
});