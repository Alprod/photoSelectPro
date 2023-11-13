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
                'success': '#2ecc71',
                'primary': '#3867d6',
                'warring': '#f7b731',
                'danger': '#ff3f34',
                'secondary': '#dcdde1'
            }
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio')
    ],
}

