const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    theme: {
        extend: {
            fontFamily: {
                'sans': ['Inter var', ...defaultTheme.fontFamily.sans],
                'title': ['HANZEEXR', 'HANZEEXR', 'sans-serif']
            },
            backgroundImage: {
                'blastoise': "url('/images/blast.png')",
                'tyranitar': "url('/images/ttar.png')",
                'raichu': "url('/images/raichu.png')",
                'reporter': "url('/images/tv.png')",
                'holon': "url('/images/hrt.jpg')",
            },
            "colors": {
                "holon": {
                50: "#F8FBFB",
                100: "#F2F7F8",
                200: "#E5EEF0",
                300: "#D8E6E9",
                400: "#C7DBE0",
                500: "#BBD3D9",
                600: "#86B1BB",
                700: "#588F9D",
                800: "#3B5F69",
                900: "#1D3034",
                950: "#0F181A"
                }
            }
        },
    },
    variants: {
        extend: {
            backgroundColor: ['active'],
        }
    },
    content: [
        './app/**/*.php',
        './resources/**/*.html',
        './resources/**/*.js',
        './resources/**/*.jsx',
        './resources/**/*.ts',
        './resources/**/*.tsx',
        './resources/**/*.php',
        './resources/**/*.vue',
        './resources/**/*.twig',
    ],
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
