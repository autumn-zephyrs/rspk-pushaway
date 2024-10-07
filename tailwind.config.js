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
