document.addEventListener('DOMContentLoaded', function () {
    let splide = new Splide('.splide', {
        type: 'loop',
        perPage: 'auto',
        direction: 'rtl',
        gap: '16px',
        arrows: false,
        pagination: false,
        perMove: 1,
        snap: true,
        omitEnd: true,
    });
    splide.mount();
});
document.addEventListener('DOMContentLoaded', function () {
    let splide = new Splide('.blog-right.splide', {
        type: 'loop',
        perPage: 'auto',
        direction: 'rtl',
        gap: '16px',
        arrows: false,
        pagination: false,
        perMove: 1,
        snap: true,
        omitEnd: true,
    });
    splide.mount();
});