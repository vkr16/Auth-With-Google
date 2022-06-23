/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/**/*.{html,js,php}"],
  theme: {
    extend: {
      colors: {
        "tea-green": "#DCF8C6",
      },
      fontFamily: {
        ProductSans: ["Product Sans", "sans"],
        Poppins: ["Poppins", "sans"],
      },
      keyframes: {
        pencet: {
          "0%, 100%": { transform: "scale(1)" },
          "50%": { transform: "rotate(.85)" },
        },
      },
    },
  },
  plugins: [],
};
