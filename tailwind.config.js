const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    theme: {
        extend: {
            spacing: {
                "7": "1.75rem",
                "35": "8.75rem",
                "38": "9.5rem",
                "43": "10.75rem",
                "44": "11rem",
                "45": "11.25rem",
                "72": "18rem",
                "84": "21rem",
                "96": "24rem"
            },
            fontFamily: {
                sans: [
                    "Graphik",
                    "Helvetica Neue",
                    "helvetica",
                    "Apple Color Emoji",
                    ...defaultTheme.fontFamily.sans
                ]
            },
            colors: {
                indigo: {
                    "900": "#191e38",
                    "800": "#2f365f",
                    "600": "#5661b3",
                    "500": "#6574cd",
                    "400": "#7886d7",
                    "300": "#b2b7ff",
                    "100": "#e6e8ff"
                },
                primary: "rgb(40, 60, 70)",
                silver: {
                    "100": "#4a4c4d",
                    "200": "#3e3f40"
                }
            },
            fill: theme => theme("colors")
        }
    },
    variants: {
        fill: ["responsive", "hover", "focus", "group-hover"],
        textColor: ["responsive", "hover", "focus", "group-hover", "active"],
        zIndex: ["responsive", "focus"],
        backgroundColor: ["responsive", "hover", "focus", "active"]
    },
    plugins: [require("@tailwindcss/custom-forms")]
};
