/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./templates/**/*.html.twig",
    "./src/**/*.{js,css}",
    "./themes/custom/Timely-Tastes-Theme/**/*.twig",
  ],
  theme: {
    extend: {
      screens: {

        'surface-duo-only': { 'raw': '(min-width: 480px) and (max-width: 767px)' },
        'sm': '640px',
        'md': '768px',
        'lg': '1024px',
        'xl': '1280px',
        '2xl': '1536px',
      },
    },
  },
  plugins: [],
}

