const { colors } = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        extend: {
            colors: {
                gray: {
                    ...colors.gray,
                    '990': '#212124',
                },
            },
            screens: {
                'max-md': {max: '768px'},
            },
            fontFamily: {
                mono: [
                    '"Iosevka Web"',
                    'Menlo',
                    'Monaco',
                    'Consolas',
                    '"Liberation Mono"',
                    '"Courier New"',
                    'monospace',
                ],
            },
        },
    },
    variants: {},
    plugins: []
};
