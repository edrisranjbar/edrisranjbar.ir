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
    let splide2 = new Splide('.blog-right.splide', {
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
    splide2.mount();
});