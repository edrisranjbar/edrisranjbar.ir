document.addEventListener('DOMContentLoaded', function () {
    let splide = new Splide('.splide', {
        perPage: 'auto',
        direction: 'rtl',
        gap: '16px',
        arrows: false,
        pagination: false,
        perMove: 1,
    });
    splide.mount();
});
document.addEventListener('DOMContentLoaded', function () {
    let splide = new Splide('.blog-right.splide', {
        perPage: 'auto',
        direction: 'rtl',
        gap: '16px',
        arrows: false,
        pagination: false,
        perMove: 1,
    });
    splide.mount();
});