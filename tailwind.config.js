const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  theme: {
    extend: {
      fontFamily: {
        sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        orange: {
          '100': '#FFF7F2',
          '200': '#FDE1CD',
          '300': '#FCCBA9',
          '400': '#F6A165',
          '500': '#EB7E32',
          '600': '#DB610B',
          '700': '#C45404',
          '800': '#A74702',
          '900': '#873800',
        },
        yellow: {
          '100': '#FFFDF2',
          '200': '#FFFBCA',
          '300': '#FFF9A2',
          '400': '#FFEE56',
          '500': '#FFE11A',
          '600': '#EACB00',
          '700': '#CEB300',
          '800': '#AC9500',
          '900': '#877500',
        },
        teal: {
          '100': '#F2FFFC',
          '200': '#D0F9EF',
          '300': '#B0F3E3',
          '400': '#71E5C9',
          '500': '#42D1AE',
          '600': '#25B390',
          '700': '#1F8A70',
          '800': '#0B634E',
          '900': '#00382A',
        },
        blue: {
          '100': '#F2FBFF',
          '200': '#C6EAF8',
          '300': '#9CDAF0',
          '400': '#56BFE4',
          '500': '#23A6D3',
          '600': '#038FBD',
          '700': '#0079A1',
          '800': '#005F7E',
          '900': '#004358',
        },
      },
    },
    customForms: theme => ({
      default: {
        'input, textarea, select, multiselect, checkbox, radio': {
          borderWidth: theme('borderWidth.2'),
          lineHeight: theme('lineHeight.tight'),
          '&:focus': {
            boxShadow: theme('boxShadow.default'),
            borderColor: theme('colors.orange.500'),
          },
          '&:disabled': {
            backgroundColor: theme('colors.orange.300'),
            borderColor: theme('colors.orange.400'),
            color: theme('colors.orange.500'),
            cursor: 'not-allowed',
          },
        },
        'input, textarea, select, multiselect': {
          width: theme('width.full'),
        },
        textarea: {
          lineHeight: theme('lineHeight.normal'),
        },
        'checkbox, radio': {
          borderColor: theme('colors.gray.400'),
        },
      },
    }),
  },
  variants: {
    opacity: ['responsive', 'hover', 'focus', 'group-hover'],
    borderWidth: ['responsive', 'last'],
  },
  plugins: [require('@tailwindcss/custom-forms')],
}
