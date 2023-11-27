document.addEventListener("DOMContentLoaded", function () {
    const demo = new Moovie({
        selector: "#videoPlayer",
        dimensions: {
            width: "100%"
        },
        config: {
            controls: {
                playtime: true,
                fullscreen: true,
                volume: false,
                mute: false,
                subtitles: false,
                config: false,
                submenuCaptions: false,
                submenuOffset: false,
                submenuSpeed: false,
                allowLocalSubtitles: false
            }
        },
        icons: {
            path: "../assets/icons/videoPlayer/"
        }
    });
});