// document.addEventListener("DOMContentLoaded", function () {
//     const demo = new Moovie({
//         selector: "#videoPlayer",
//         dimensions: {
//             width: "100%"
//         },
//         config: {
//             controls: {
//                 playtime: true,
//                 fullscreen: true,
//                 volume: false,
//                 mute: false,
//                 subtitles: false,
//                 config: false,
//                 submenuCaptions: false,
//                 submenuOffset: false,
//                 submenuSpeed: false,
//                 allowLocalSubtitles: false
//             }
//         },
//         icons: {
//             path: "../assets/icons/videoPlayer/"
//         }
//     });
// });


document.addEventListener("DOMContentLoaded", function () {
    const accordionHeaderElements = document.querySelectorAll(".accordion-header");
    const accordionBodyElements = document.querySelectorAll(".accordion-body");
    const accordionArrows = document.querySelectorAll(".accordion-arrow");
    const accordionBurgerIcons = document.querySelectorAll(".accordion-burger-icon");
    accordionHeaderElements.forEach((header, index) => {
        header.addEventListener('click', () => {
            accordionBodyElements.forEach((body, i) => {
                if (i !== index) {
                    body.classList.remove("active");
                    body.style.maxHeight = "0";
                }
            });
            accordionBurgerIcons[index].classList.toggle('white', !header.classList.contains('active'));
            if (accordionBodyElements[index].classList.contains("active")) {
                accordionBodyElements[index].classList.remove("active");
                accordionBodyElements[index].style.maxHeight = "0";
                accordionArrows[index].src = "/assets/icons/plus-circle.svg";
            } else {
                accordionBodyElements[index].classList.add("active");
                accordionArrows[index].src = "/assets/icons/minus-circle.svg";
                setTimeout(() => {
                    accordionBodyElements[index].style.maxHeight = accordionBodyElements[index].scrollHeight + "px";
                }, 50);
            }

            accordionHeaderElements.forEach((h, i) => {
                if (i !== index) {
                    h.classList.remove("active");
                }
            });

            header.classList.toggle("active");
        });
    });
});

const cards = document.querySelectorAll(".attribute-card");
const motionMatchMedia = window.matchMedia("(prefers-reduced-motion)");
const THRESHOLD = 15;

/*
 * Read the blog post here:
 * https://letsbuildui.dev/articles/a-3d-hover-effect-using-css-transforms
 */
function handleHover(e, card) {
    const { clientX, clientY, currentTarget } = e;
    const { clientWidth, clientHeight, offsetLeft, offsetTop } = currentTarget;

    const horizontal = (clientX - offsetLeft) / clientWidth;
    const vertical = (clientY - offsetTop) / clientHeight;
    const rotateX = (THRESHOLD / 2 - horizontal * THRESHOLD).toFixed(2);
    const rotateY = (vertical * THRESHOLD - THRESHOLD / 2).toFixed(2);

    card.style.transform = `perspective(${clientWidth}px) rotateX(${rotateY}deg) rotateY(${rotateX}deg) scale3d(1, 1, 1)`;
}

function resetStyles(e, card) {
    card.style.transform = `perspective(${e.currentTarget.clientWidth}px) rotateX(0deg) rotateY(0deg)`;
}

cards.forEach((card) => {
    if (!motionMatchMedia.matches) {
        card.addEventListener("mousemove", (e) => handleHover(e,card));
        card.addEventListener("mouseleave", (e) => resetStyles(e,card));
    }
})