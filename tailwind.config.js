module.exports = {
  content: [
    "./app/Views/**/*.php",
    "./public/assets/src/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        // Markeza public theme: neutral base with teal brand accents.
        orange: {
          100: "#e7f2ef",
          200: "#b9d8d1",
          600: "#124f48",
        },
        stone: {
          700: "#404040",
          800: "#262626",
          900: "#171717",
        },
      },
      fontFamily: {
        "YekanBakh-Light": ["YekanBakh-Light"],
        "YekanBakh-Regular": ["YekanBakh-Regular"],
        "YekanBakh-SemiBold": ["YekanBakh-SemiBold"],
        "YekanBakh-Bold": ["YekanBakh-Bold"],
        "YekanBakh-ExtraBold": ["YekanBakh-ExtraBold"],
        "YekanBakh-ExtraBlack": ["YekanBakh-ExtraBlack"],
      },
    },
  },
  daisyui: {
    themes: ["light"],
    rtl: true,
  },
  plugins: [require("daisyui")],
};
