/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      boxShadow: {
        'card-shadow': '4px 4px 4px 2px rgba(0, 0, 0, 0.04)',
      },
      fontFamily: {
        "rubik": ['Rubik', 'sans-serif']
      },
      flexBasis: {
        "1/3-gap-4": "calc(33.3% - (2/3 * 1rem))"
      }
    },
  },
  plugins: [],
}

