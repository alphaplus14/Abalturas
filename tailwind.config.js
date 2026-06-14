/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./*.php',
		'./template-parts/**/*.php',
		'./woocommerce/**/*.php',
		'./inc/**/*.php',
	],
	theme: {
		extend: {
			colors: {
				industrial: '#1A365D',
				safety: '#F56523',
				carbon: '#2D3748',
				charcoal: '#1A202C',
				mist: '#F7FAFC',
			},
			fontFamily: {
				sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
			},
		},
	},
	plugins: [require('@tailwindcss/typography')],
};
