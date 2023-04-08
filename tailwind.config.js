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
                    twitter: '#00aced',
                    pinterest: '#bd081c',
                    reddit: '#ff4500',
                    rss: '#f26522',
                },

                grey: {
                    DEFAULT: '#666',
                    light: '#f7f7f7',
                    lightest: '#fbfbfb',
                    dark: '#787878',
                    darker: '#595959',
                    darkest: '#222',
                    off: '#ccc',
                    'off-light': '#e8e8e8',
                    'off-dark': '#bbb',
                },
            },

            maxWidth: {
                '8xl': '94rem',
            },

            screens: {
                xs: '500px',
                xmd: '860px',
            }
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
