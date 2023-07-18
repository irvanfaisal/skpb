const colors = require('tailwindcss/colors');
module.exports = {
   purge: [
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
   ],  
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      boxShadow: {
        paleblue: '0 0px 14px 0 rgba(63,131,141,.5)',
      },
      fontSize: {
       'xxs': '.6rem',
      }, 

      colors: {
        transparent: 'transparent',
        current: 'currentColor',
        black: colors.black,
        white: colors.white,
        gray: colors.slate,
        green: colors.emerald,
        purple: colors.violet,
        yellow: colors.amber,
        pink: colors.fuchsia,
        orange: colors.orange,
        lime: colors.lime,
      }
    },    

  },
  variants: {
      extend: {
          display: ["group-hover"],
      },
  },
  plugins: [],
  // plugins: [require('@tailwindcss/forms')],
}
