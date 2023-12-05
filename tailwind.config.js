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
                success: '#2ecc71',
                primary: 'rgba(81,122,222,0.97)',
                hoverPrimary: 'rgba(60,108,224,0.97)',
                warring: '#f7b731',
                danger: {
                    100:'#fcb5b3',
                    200:'#ff9a98',
                    300:'#fa8684',
                    400:'#fa6563',
                    500:'#fc4a47',
                    600:'#fa3835',
                    700:'#fc2320',
                    900: '#ff0f00'
                },
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

