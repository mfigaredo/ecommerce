const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                trueGray: colors.trueGray,
                orange: colors.orange,
                greenLime: colors.lime,
                // limon: colors.lime,
                // dea: '#ddeeaa',
            },
            variants: {
                backgroundColor: ['disabled'],
                borderColor: ['disabled'],
                textColor: ['disabled'],
                opacity: ['disabled'],
                shadow: ['disabled'],
                cursor: ['disabled'],
            },
        },
        
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
    variants: {
        extend: {
            backgroundColor: ['disabled'],
            borderColor: ['disabled'],
            textColor: ['disabled'],
            opacity: ['disabled'],
            shadow: ['disabled'],
            cursor: ['disabled'],
        }
    }
    
};
