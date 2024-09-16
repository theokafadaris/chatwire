// tailwind.config.js

const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                'icon-blue': '#007BFF', 
                'icon-green': '#28A745',
                'custom-blue-200': '#BFDBFE',
                'custom-green-200': '#D1FAE5',
                'custom-yellow-200': '#FDE047',
                'custom-red-200': '#FECACA',
                'custom-purple-200': '#E9D5FF',
                'custom-pink-200': '#FBCFE8',
                'custom-teal-200': '#CCFBF1',
                'custom-orange-200': '#FDBA74',
                'custom-indigo-200': '#C3DAFE',
                'custom-gray-200': '#E2E8F0',
                'custom-lime-200': '#D9F99D',
                'custom-cyan-200': '#A5F3FC',
                'custom-rose-200': '#FECACA',
                'custom-amber-200': '#FBBF24',
                'custom-emerald-200': '#D1FAE5',
                'custom-violet-200': '#E9D5FF',
                'custom-fuchsia-200': '#F5D0FE',
                'custom-sky-200': '#BFDBFE',
                'custom-slate-200': '#CBD5E1',
                'custom-teal-100': '#D1FAE5',
                'custom-yellow-100': '#FEF08A',
                'custom-blue-100': '#Dbeafe',
                'custom-green-100': '#D1FAE5',
                'custom-red-100': '#FECACA',
                'custom-purple-100': '#E9D5FF',
                'custom-pink-100': '#FBCFE8',
                'custom-orange-100': '#FCD34D',
                'custom-teal-300': '#99F6E4',
                'custom-cyan-300': '#67E8F9',
                'custom-lime-300': '#A3E635',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
            },
            animation: {
                fadeIn: 'fadeIn 0.5s ease-out',
            },
        },
    },
    plugins: [require('@tailwindcss/forms'), require('flowbite/plugin')],
};
