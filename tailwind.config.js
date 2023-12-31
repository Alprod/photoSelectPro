const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    content: [
        './assets/**/*.{js,jsx}',
        './templates/**/*.html.twig'
    ],
    theme: {
        screens: {
            'iphone': '393px',
            'xs': '480px',
            ...defaultTheme.screens,
        },
        extend: {
            screens:{
                'fullHD': '1920px',
                'ultra4K': '3840px'
            },
            colors: {
                verify_email_error:{
                    100: '#92e5d2',
                    200: '#77d3be',
                    300: '#61c9b1',
                    400: '#4ac0a5',
                    500: '#37bb9d',
                    600: '#24b493',
                    700: '#12ab88',
                    900: '#02a680'
                },
                success: {
                    100: '#9decbc',
                    200: '#77e1a1',
                    300: '#5ad98d',
                    400: '#43d07c',
                    500: '#2fc76d',
                    600: '#22c264',
                    700: '#15b657',
                    900: '#0cab4d'
                }
                ,
                primary: 'rgba(81,122,222,0.97)',
                hoverPrimary: 'rgba(60,108,224,0.97)',
                warning: '#f7b731',
                hoverWarning: '#f8c458',
                danger: {
                    100: '#fcb5b3',
                    200: '#ff9a98',
                    300: '#fa8684',
                    400: '#fa6563',
                    500: '#fc4a47',
                    600: '#fa3835',
                    700: '#fc2320',
                    900: '#ff0f00'
                },
                secondary: '#696a6b'
            }
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio')
    ],
}

