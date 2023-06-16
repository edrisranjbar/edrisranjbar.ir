document.addEventListener('DOMContentLoaded', function () {
    let splide = new Splide('.splide', {
        perPage: 'auto',
        direction: 'rtl',
        gap: '16px',
        arrows: false,
        pagination: false
    });

    splide.mount();
});