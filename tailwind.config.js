/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './storage/framework/views/*.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        fontFamily: {
            sans: ['Raleway', 'ui-sans-serif'],
            coeliac: ['Note This', 'ui-sans-serif'],
        },

        extend: {
            colors: {
                primary: {
                    DEFAULT: '#80CCFC',
                    light: '#addaf9',
                    lightest: '#e7f4fe',
                    dark: '#29719f',
                    darkest: '#237cbd',
                    other: '#186ba3',
                    shopping: '#f4f9fd',
                },

                secondary: {
                    light: '#ecd14a',
                    DEFAULT: '#DBBC25',
                },

                social: {
                    facebook: '#3b5998',
                    'facebook-light': 'rgba(59,89,152, 0.5)',
                    twitter: '#00aced',
                    'twitter-light': 'rgba(0,172,237, 0.5)',
                    pinterest: '#bd081c',
                    reddit: '#ff4500',
                    rss: '#f26522',
                },
            },

            screens: {
                xmd: '860px',
            }
        },
    },

    plugins: [
        require('@tailwindcss/typography'),
    ],
}
