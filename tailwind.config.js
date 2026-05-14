/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.php',
    './assets/js/**/*.js',
    '!./node_modules/**',
  ],
  darkMode: ['class', '[data-theme="dark"]'],
  theme: {
    extend: {
      colors: {
        primary:   { DEFAULT: '#FF7A2D', dark: '#E5631A' },
        navy:      { DEFAULT: '#0B2545', 2: '#13315C' },
        yellow:    '#FFC857',
        success:   '#22C55E',
        surface: {
          DEFAULT:  '#FFFFFF',
          soft:     '#F7F8FA',
          dark:     '#0F172A',
          darkcard: '#1E293B',
        },
        border: {
          DEFAULT: '#E5E7EB',
          dark:    '#334155',
        },
        text: {
          DEFAULT: '#1F2937',
          muted:   '#6B7280',
          dark:    '#F1F5F9',
          'dark-muted': '#94A3B8',
        },
      },
      fontFamily: {
        head: ['Poppins', 'Inter', 'sans-serif'],
        body: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
      },
      borderRadius: {
        card:   '14px',
        sm:     '8px',
        full:   '9999px',
      },
      boxShadow: {
        card:   '0 10px 30px rgba(11,37,69,.08)',
        'card-lg': '0 20px 50px rgba(11,37,69,.15)',
        btn:    '0 10px 25px rgba(255,122,45,.35)',
      },
      maxWidth: {
        container: '1200px',
      },
      screens: {
        xs: '480px',
        sm: '640px',
        md: '768px',
        lg: '1024px',
        xl: '1280px',
        '2xl': '1536px',
      },
      transitionTimingFunction: {
        smooth: 'cubic-bezier(.4,0,.2,1)',
      },
      keyframes: {
        slideDown: {
          from: { transform: 'translateY(-100%)' },
          to:   { transform: 'translateY(0)' },
        },
        fadeUp: {
          from: { opacity: '0', transform: 'translateY(30px)' },
          to:   { opacity: '1', transform: 'translateY(0)' },
        },
        shimmer: {
          '0%':   { backgroundPosition: '-400px 0' },
          '100%': { backgroundPosition: '400px 0' },
        },
        scaleIn: {
          from: { opacity: '0', transform: 'scale(.95)' },
          to:   { opacity: '1', transform: 'scale(1)' },
        },
      },
      animation: {
        'slide-down':  'slideDown .3s ease',
        'fade-up':     'fadeUp .6s ease forwards',
        shimmer:       'shimmer 1.4s infinite linear',
        'scale-in':    'scaleIn .2s ease',
      },
    },
  },
  plugins: [],
};
