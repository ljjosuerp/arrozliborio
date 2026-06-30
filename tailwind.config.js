import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            // Tipografías del DS (Athelas→Lora títulos, Nunito Sans cuerpo)
            fontFamily: {
                sans: ['Nunito Sans', ...defaultTheme.fontFamily.sans],
                display: ['Lora', 'Georgia', 'serif'],
                serif: ['Lora', 'Georgia', 'serif'],
            },

            // Paleta oficial del GUIDELINE DE MARCA LIBORIO (design system)
            colors: {
                liborio: {
                    red: '#B2292E',
                    blue: '#0F206C',
                    celeste: '#87D1E6',
                    yellow: '#E0CC00',
                    wheat: '#D7A461',
                },
                red: {
                    50: '#FBEDED', 100: '#F5D3D4', 200: '#E8A3A5', 300: '#D97276', 400: '#C84A4F',
                    500: '#B2292E', 600: '#951F24', 700: '#76181C', 800: '#571215', 900: '#3A0C0E',
                },
                blue: {
                    50: '#E9ECF6', 100: '#C8CFE6', 200: '#97A2CC', 300: '#6373B0', 400: '#38498F',
                    500: '#0F206C', 600: '#0C1A58', 700: '#091344', 800: '#060D30', 900: '#04081D',
                },
                celeste: {
                    50: '#F2FAFD', 100: '#DEF3F9', 200: '#BFE8F3', 300: '#A3DDED', 400: '#87D1E6',
                    500: '#5BBBD7', 600: '#389FBE', 700: '#2A7C95',
                },
                yellow: { 100: '#FBF4BF', 300: '#F0E25C', 500: '#E0CC00', 700: '#A89800' },
                wheat: { 100: '#F6EADB', 300: '#E7C79C', 500: '#D7A461', 700: '#A9762F' },
                paper: '#FBF8F3',
                grey: {
                    50: '#F6F4F0', 100: '#ECE8E1', 200: '#DAD4CA', 300: '#BDB6AA', 400: '#948C7F',
                    500: '#6E665B', 600: '#514B43', 700: '#3A352F', 800: '#262320',
                },
                ink: '#1A1715',
            },

            borderRadius: {
                card: '18px',
                pill: '999px',
            },

            boxShadow: {
                'lb-sm': '0 2px 6px rgba(58,12,14,0.08)',
                'lb-md': '0 6px 18px rgba(58,12,14,0.10)',
                'lb-lg': '0 16px 40px rgba(58,12,14,0.14)',
                'lb-brand': '0 10px 28px rgba(178,41,46,0.28)',
            },

            maxWidth: {
                site: '1180px',
            },
        },
    },

    plugins: [forms, typography],
};
