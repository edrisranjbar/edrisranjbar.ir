// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()

document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelectorAll('.tutorialsInSidebar').length > 0) {
        let tutorialsSliderInSidebar = new Splide('.tutorialsInSidebar', { pagination: true, arrows: true });
        tutorialsSliderInSidebar.mount();
    }
    if (document.querySelectorAll('.splide').length > 0) {
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
    }
    if (document.querySelectorAll('.blog-right.splide').length > 0) {
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
    }
});