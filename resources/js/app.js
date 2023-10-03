try {
    window.$ = window.jQuery = require("jquery");
} catch (e) {}

// slick js
require("slick-carousel/slick/slick");

import AOS from "aos";

AOS.init({
    once: true,
    duration: 500,
    easing: "ease-in-out",
    delay: 0,
});

// hero slider

$(".hero-slider").slick({
    dots: true,
    infinite: true,
    arrows: true,
    autoplay: true,
    speed: 500,
    autoplaySpeed: 5000,
    slidesToShow: 1,
    slidesToScroll: 1,
    responsive: [
        {
            breakpoint: 767,
            settings: {
                arrows: false,
            },
        },
    ],
});
