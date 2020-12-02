let mix = require('laravel-mix');
const SWPrecacheWebpackPlugin = require('sw-precache-webpack-plugin');
// require('laravel-mix-purgecss');

mix.js('resources/assets/admin/js/app.js', 'public/js/admin')
	.js('resources/assets/web/js/app.js', 'public/js/web')
	.styles(['resources/assets/admin/css/vendor/awesomplete.css'], 'public/css/admin/vendor/all.css')
	.styles(['resources/assets/web/css/vendor/material.min.css', 'resources/assets/web/css/vendor/mdl-select.min.css'], 'public/css/web/vendor/all.css')
	.scripts(['resources/assets/admin/js/vendor/awesomplete.min.js'], 'public/js/admin/vendor/all.js')
	.scripts(['resources/assets/web/js/vendor/material.min.js', 'resources/assets/web/js/vendor/mdl-select.min.js'], 'public/js/web/vendor/all.js')
	.sass('resources/assets/admin/sass/app.scss', 'public/css/admin')
	.sass('resources/assets/web/sass/app.scss', 'public/css/web')
	.version();
// .purgeCss();

mix.webpackConfig({
	plugins: [
		new SWPrecacheWebpackPlugin({
			cacheId: 'pwa',
			filename: 'sw.js',
			staticFileGlobs: [
				'public/css/web/**/*.css',
				'public/js/web/**/*.js',
				'public/**/*.{jpg,png}',
			],
			minify: true,
			stripPrefix: 'public/',
			staticFileGlobsIgnorePatterns: [/\.map$/, /mix-manifest\.json$/, /manifest\.json$/, /sw\.js$/],
			dynamicUrlToDependencies: {
				'/': ['resources/views/web/index.blade.php'],
			},
			runtimeCaching: [
				{
					urlPattern: /\/api\/conferences/,
					handler: 'networkFirst'
				},
				{
					urlPattern: /\/api\/articles/,
					handler: 'networkFirst'
				},
				{
					urlPattern: /\/api\/tutos/,
					handler: 'networkFirst'
				},
				{
					urlPattern: /\/api\/books/,
					handler: 'networkFirst'
				},
				{
					urlPattern: /^[tuto|conference]\/[a-zA-Z0-9_\-]+/,
					handler: 'networkFirst'
				},
				{
					urlPattern: /^https:\/\/fonts\.googleapis\.com\//,
					handler: 'cacheFirst'
				},
				{
					urlPattern: /^https:\/\/fonts.gstatic.com\/s\/roboto\/v18\//,
					handler: 'cacheFirst'
				},
				{
					urlPattern: /^https:\/\/fonts.gstatic.com\/s\/materialicons\/v30/,
					handler: 'cacheFirst'
				},
				{
					urlPattern: /^https:\/\/code.getmdl.io\/1.3.0\/material.blue_grey-deep_orange.min.css/,
					handler: 'cacheFirst'
				},
				{
					urlPattern: /^https:\/\/code.getmdl.io\/1.3.0\/material.min.js/,
					handler: 'cacheFirst'
				},
				{
					urlPattern: /^https:\/\/img.youtube.com\/vi\/(.*)\/mqdefault.jpg/,
					handler: 'cacheFirst'
				},
				{
					urlPattern: /^https:\/\/media.giphy.com\/media\/14uQ3cOFteDaU\/source.gif/,
					handler: 'cacheFirst'
				}
			],
		})
	]
})


mix.browserSync('dev.coding.fr')
