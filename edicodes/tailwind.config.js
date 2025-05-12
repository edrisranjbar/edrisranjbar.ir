/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#7C96F7',
        'primary-dark': '#6C63FF',
        secondary: '#FFBA08',
        'secondary-light': '#FEDB80',
        dark: '#121212',
        'semi-dark': '#323230',
        'smoky-white': '#f0f0f0',
        'white': '#fafafa',
        'pure-white': '#ffffff',
      },
      fontFamily: {
        sans: ['Vazirmatn FD', 'sans-serif'],
      },
    },
  },
  plugins: [],
} 