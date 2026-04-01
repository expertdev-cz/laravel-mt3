import preset from './vendor/filament/support/tailwind.config.preset';
import colors from 'tailwindcss/colors';

export default {
  presets: [preset],
  content: [
    './app/Filament/**/*.php',
    './resources/views/**/*.blade.php',
    './vendor/filament/**/*.blade.php',
  ],
  safelist: ["max-h-[330px]", "max-h-[600px]", "h-[330px]", "h-[600px]"],
  theme: {
    fontFamily: {
      alt: ['"Baloo 2"', "sans-serif"],
      handwrite: ['"Caveat"', "sans-serif"],
    },
    container: {
      center: true,
      padding: {
        DEFAULT: "1.25rem",
        md: "0",
      },
      screens: {
        xl: "1220px",
        xxl: "1380px",
        "2.5xl": "1440px",
      },
    },
    screens: {
      xs: "360px",
      sm: "568px",
      md: "768px",
      lg: "1024px",
      xl: "1280px",
      xxl: "1440px",
      "3xl": "1920px",
      "max-xs": { max: "359px" },
      "max-sm": { max: "579px" },
      "max-md": { max: "767px" },
      "max-lg": { max: "1023px" },
      "max-xl": { max: "1279px" },
      "max-xxl": { max: "1439px" },
      "max-2xl": { max: "1919px" },
      "lt-450": {max: "450px" },
      "lt-400": {max: "400px" },
    },
    extend: {
      fontSize: {
        xsm: ["0.625rem", { lineHeight: "1rem" }], // 10px / 16px
        sm: ["0.875rem", { lineHeight: "1.125rem" }], // 14px / 18px
        md: ["1.125rem", { lineHeight: "1.375rem" }], // 18px / 22px
        lg: ["1.375rem", { lineHeight: "1.5rem" }], // 22px / 24px
        "2xl": ["1.5rem", { lineHeight: "1.563rem" }], // 24px / 26px
        "3xl": ["1.75rem", { lineHeight: "1.875rem" }], // 28px / 30px
        "4xl": ["2.125rem", { lineHeight: "2.25rem" }], // 34px / 36px
        "5xl": ["2.5rem", { lineHeight: "1" }], // 40px / normal
        "5.5xl": ["2.875rem", { lineHeight: "1" }], // 46px / normal
        "6xl": ["3.375rem", { lineHeight: "1" }], // 54px / normal
        "7xl": ["4.375rem", { lineHeight: "1" }], // 70px / normal
        "8xl": ["5.258rem", { lineHeight: "1" }], // 84px / normal
        "1.25x": ["1.25rem", { lineHeight: "1.5rem" }], // 20px / 24px
        "1.75x": ["1.75rem", { lineHeight: "1.875rem" }], // 28px / 30px
        "2x": ["2rem", { lineHeight: "2.25rem" }], // 32px / 36px
        "2.25x": ["2.25rem", { lineHeight: "2.375rem" }], // 36px / 38px
      },
      colors: {
        current: "currentColor",
        transparent: "transparent",
        white: "#FFFFFF",

        dark: "#1D2430",
        primary: "#FF0066",
        secondary: "#272727",
        third: "#FFE6F0",

        yellow: "#F7A412",
        purple: "#A05EF1",
        blue: {
          ...colors.blue,
          dark: "#3b5998",
          light: "#1DA1F2",
          md: "#0077b5",
        },
        green: "#049422",
        red: {
          DEFAULT: "#FF0000",
          dark: "#bd081c",
        },
        orange: "#ea4335",
        "body-color": {
          DEFAULT: "#7A7A7A",
        },
        stroke: {
          stroke: "#E3E8EF",
          dark: "#353943",
        },
        gray: {
          ...colors.gray,
          xdark: "#0d0d0d",
          darker: "#333",
          dark: "#3B3B3B",

          light: {
            DEFAULT: "#dadada",
            md: "#aaaaaa",
          },
          md: "#afafaf",
          bright: "#54595f",
        },
      },
      backgroundImage: {
        "circle-tab": "linear-gradient(0deg, #FF0066, #f294b9)",
        "banner-gradient": 'linear-gradient(to bottom, #EEEEEE 0%, #F4F4F4 50%, #F9F9F9 100%)',
      },

      borderColor: {
        DEFAULT: "#D5D5D5",
        light: "#d5d8dc",
      },

      borderWidth: {
        1: "1px",
      },
      width: {
        0.25: "0.063rem", // 1px
        2.25: "0.625rem", // 10px
        9: "2.25rem", // 36px
        13.5: "3.375rem", // 54px
        17: "4.25rem", // 68 px
        18: "4.5rem", // 72px
        19: "4.75rem", // 76px
        20: "5rem", // 80px
        24: "6rem", // 96px
      },
      height: {
        0.25: "0.063rem", // 1px
        2.25: "0.625rem", // 10px
        9: "2.25rem", // 36px
        13.5: "3.375rem", // 54px
        17: "4.25rem", // 68px
        18: "4.5rem", // 72px
        19: "4.75rem", // 76px
        20: "5rem", // 80px
        24: "6rem", // 96px
        52.5: "13.125rem", // 210px
        60: "15rem", // 240px
      },
      maxWidth: {
        uxga: "1600px",
        fhd: "1920px",
        "screen-2xl/2": "720px",
      },

      spacing: {
        0: "0rem", // 0px
        1: "0.25rem", // 4px
        1.5: "0.375rem", // 6px
        2: "0.5rem", // 8px
        3: "0.75rem", // 12px
        4: "1rem", //16px
        5: "1.25rem", //20px
        6: "1.5rem", //24px
        6.25: "1.563rem", //25px
        7: "1.75rem", //28px
        8: "2rem", // 32px
        9: "2.25rem", // 36px
        10: "2.5rem", // 40px
        11: "2.75rem", // 44px
        12: "3rem", // 48px
        12.5: "3.125rem", // 50px
        14: "3.5rem", // 56px
        15: "3.75rem", // 60px
        15.25: "4.063rem", // 65px
        18: "4.5rem", // 72px
        20: "5rem", // 80px
        22: "5.5rem", // 88px
        25: "6.25rem", // 100px
        30: "7.5rem", // 120px
        52: "13rem", // 208px
        90: "22.5rem", // 360px
        100: "25rem", // 400px
        120: "30rem", // 480px
      },

      boxShadow: {
        base: "0px 0px 38px -21px rgba(0, 0, 0, 0.5);",
        sticky: "0px 0px 38px -21px rgba(0, 0, 0, 0.5)",
        dialog: "2px 8px 23px 3px rgba(0, 0, 0, 0.2)",
        signUp: "0px 5px 10px rgba(4, 10, 34, 0.2)",
        one: "0px 2px 3px rgba(7, 7, 77, 0.05)",
        two: "0px 5px 10px rgba(6, 8, 15, 0.1)",
        three: "0px 5px 15px rgba(6, 8, 15, 0.05)",
        "sticky-dark": "inset 0 -1px 0 0 rgba(255, 255, 255, 0.1)",
        "feature-2": "0px 10px 40px rgba(48, 86, 211, 0.12)",
        submit: "0px 5px 20px rgba(4, 10, 34, 0.1)",
        "submit-dark": "0px 5px 20px rgba(4, 10, 34, 0.1)",
        btn: "0px 1px 2px rgba(4, 10, 34, 0.15)",
        "btn-hover": "0px 1px 2px rgba(0, 0, 0, 0.15)",
        "btn-light": "0px 1px 2px rgba(0, 0, 0, 0.1)",
        box: "0 0 44px 0 rgba(160, 160, 160, 0.5)",
        boxLighter: "0px 0px 44px 0px rgba(160, 160, 160, 0.3)",
        boxReduced: "0px 0px 30px 0px rgba(160, 160, 160, 0.3)",
        highlight: "0px 0px 35px -5px rgba(254, 0, 102, 0.3)",
      },
      dropShadow: {
        three: "0px 5px 15px rgba(6, 8, 15, 0.05)",
      },
      borderRadius: {
        xs: "8px",
        sm: "40px",
        md: "60px ",
        lg: "80px",
        xl: "100px",
        "2xl": "120px",
        5: "20px",
        6: "24px",
      },
      transitionDuration: {
        2000: "2000ms",
      },
      minWidth: {
        "1/3": "33.333%",
        "1/2": "50%",
      },
      rotate: {
        11: "11%",
      },
    },
    animation: {
      fadeIn: "fadeIn 0.5s ease-in-out forwards",
      imageMove: "imageMove 6s ease-in-out infinite",
      fadeInUp: "fadeInUp 300ms linear 1 forwards",
      "spin-slow": "spin 12s linear infinite",
    },
    keyframes: {
      fadeIn: {
        "0%": { opacity: "0" },
        "100%": { opacity: "1" },
      },
      imageMove: {
        "0%, 100%": { transform: "translateY(0%)" },
        "50%": { transform: "translateY(-50%)" },
      },
      fadeInUp: {
        "0%": { opacity: "0", transform: "translateY(30px)" },
        "100%": { opacity: "1", transform: "translateY(0)" },
      },
    },
  },
  plugins: [],
};
