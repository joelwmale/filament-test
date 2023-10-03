const plugin = require("tailwindcss/plugin");

module.exports = {
    darkMode: 'class',
    content: [
        "./resources/**/*.blade.php",
        "./vendor/livewire/livewire/src/**/*.blade.php",
        "./src/**/*.{js,jsx,ts,tsx,vue}",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Gilroy", "sans-serif"],
                serif: ["Gilroy", "sans-serif"],
                mono: ["Gilroy", "sans-serif"],
                display: ["Gilroy", "sans-serif"],
                body: ["Gilroy", "sans-serif"],
            },

            colors: {
                dark: {
                    100: "#686868",
                    200: "#404040",
                    300: "#373737",
                    400: "#1d252c",
                    500: "#171a1c",
                    600: "#171a1c",
                    700: "#0e031d",
                    800: "#0f0f0f",
                },
                light: {
                    50: "#F9F9F9",
                    100: "#fafafa",
                    200: "#cacaca",
                    300: "#eeeeee",
                    400: "#373737",
                },
                pink: "#f74ea1",
                purple: "#4f0dcf",
                blue: "#0074db",
                border: {
                    light: "rgb(29,37,44)",
                    primary:
                        "linear-gradient( 298deg, #f74ea1 3%, #9a249c 60%, #4f0dcf 97% )",
                },
            },

            maxWidth: {
                "8xl": "1440px",
                desktop: "2560px",
            },

            // [BACKGROUND Images & Gradients]
            backgroundImage: {
                primary:
                    "linear-gradient( 298deg, #f74ea1 3%, #9a249c 60%, #4f0dcf 97% )",
            },

            boxShadow: {
                "blog-box": "0px 0px 50px rgba(29,37,44,20%)",
                window: "0 30px 60px rgb(29 37 44 / 30%)",
            },

            transitionProperty: {
                width: "width",
            },
        },
    },
    plugins: [
        require("@tailwindcss/line-clamp"),
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
