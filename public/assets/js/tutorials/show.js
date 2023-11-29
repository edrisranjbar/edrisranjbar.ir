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

    accordionHeaderElements.forEach((header, index) => {
        header.addEventListener('click', () => {
            accordionBodyElements.forEach((body, i) => {
                if (i !== index) {
                    body.classList.remove("active");
                    body.style.maxHeight = "0";
                }
            });

            if (accordionBodyElements[index].classList.contains("active")) {
                accordionBodyElements[index].classList.remove("active");
                accordionBodyElements[index].style.maxHeight = "0";
            } else {
                accordionBodyElements[index].classList.add("active");
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