//process.env.DISABLE_NOTIFIER = true; // Disable all notifications.

/**
 * Business Pro.
 *
 * This file adds gulp tasks to the Business Pro theme.
 *
 * @author SEO themes
 */

// Require our dependencies.
var	args         = require('yargs').argv,
	autoprefixer = require('autoprefixer'),
	browsersync  = require('browser-sync'),
	bump         = require('gulp-bump'),
	changecase   = require('change-case'),
	del          = require('del'),
	mqpacker     = require('css-mqpacker'),
	fs           = require('fs'),
	gulp         = require('gulp'),
	beautify     = require('gulp-cssbeautify'),
	cache        = require('gulp-cached'),
	cleancss     = require('gulp-clean-css'),
	concat       = require('gulp-concat'),
	csscomb      = require('gulp-csscomb'),
	cssnano      = require('gulp-cssnano'),
	filter       = require('gulp-filter'),
	imagemin     = require('gulp-imagemin'),
	notify       = require('gulp-notify'),
	pixrem       = require('gulp-pixrem'),
	plumber      = require('gulp-plumber'),
	postcss      = require('gulp-postcss'),
	rename       = require('gulp-rename'),
	replace      = require('gulp-replace'),
	sass         = require('gulp-sass'),
	sort         = require('gulp-sort'),
	sourcemaps   = require('gulp-sourcemaps'),
	uglify       = require('gulp-uglify'),
	wpPot        = require('gulp-wp-pot'),
	zip          = require('gulp-zip'),
	focus        = require('postcss-focus');

// Set assets paths.
var paths = {
	concat:  ['assets/scripts/menus.js', 'assets/scripts/superfish.js'],
	images:  ['assets/images/*', '!assets/images/*.svg'],
	php:     ['./*.php', './**/*.php', './**/**/*.php'],
	scripts: ['assets/scripts/*.js', '!assets/scripts/min/'],
	woo:     ['assets/styles/woocommerce.scss'],
	styles:  ['assets/styles/*.scss', '!assets/styles/min/']
};

/**
 * Autoprefixed browser support.
 *
 * https://github.com/ai/browserslist
 */
const AUTOPREFIXER_BROWSERS = [
	'last 2 versions',
	'> 0.25%',
	'ie >= 8',
	'ie_mob >= 9',
	'ff >= 28',
	'chrome >= 40',
	'safari >= 6',
	'opera >= 22',
	'ios >= 6',
	'android >= 4',
	'bb >= 9'
];

/**
 * Compile Sass.
 *
 * https://www.npmjs.com/package/gulp-sass
 */
gulp.task('woo', function () {

	/**
	 * Process WooCommerce styles.
	 */
	gulp.src('assets/styles/woocommerce.scss')

		// Notify on error
		.pipe(plumber({
			errorHandler: notify.onError("Error: <%= error.message %>")
		}))

		// Process sass
		.pipe(sass({
			outputStyle: 'expanded'
		}))

		// Pixel fallbacks for rem units.
		.pipe(pixrem())

		// Parse with PostCSS plugins.
		.pipe(postcss([
			autoprefixer({
				browsers: AUTOPREFIXER_BROWSERS
			}),
			mqpacker({
				sort: true
			}),
		]))

		// Format CSS.
		.pipe(csscomb())

		// Add .min suffix.
		.pipe(rename({
			suffix: '.min'
		}))

		// Output non minified css to theme directory.
		.pipe(gulp.dest('assets/styles/min/'))

		// Filtering stream to only css files.
		.pipe(filter('**/*.css'))

		// Inject changes via browsersync.
		.pipe(browsersync.reload({
			stream: true
		}))

		// Notify on successful compile (uncomment for notifications).
		.pipe(notify("Compiled: <%= file.relative %>"));

});

/**
 * Compile Sass.
 *
 * https://www.npmjs.com/package/gulp-sass
 */
gulp.task('styles', function () {

	/**
	 * Process main stylesheet.
	 */
	gulp.src('assets/styles/style.scss')

		// Notify on error
		.pipe(plumber({
			errorHandler: notify.onError("Error: <%= error.message %>")
		}))

		// Source maps init
		.pipe(sourcemaps.init())

		// Process sass
		.pipe(sass({
			outputStyle: 'expanded'
		}))

		// Pixel fallbacks for rem units.
		.pipe(pixrem())

		// Parse with PostCSS plugins.
		.pipe(postcss([
			autoprefixer({
				browsers: AUTOPREFIXER_BROWSERS
			}),
			mqpacker({
				sort: true
			}),
		]))

		// Format non-minified CSS.
		.pipe(csscomb())

		// Output non minified css to theme directory.
		.pipe(gulp.dest('./'))

		// Inject changes via browsersync.
		.pipe(browsersync.reload({
			stream: true
		}))

		// Process sass again.
		.pipe(sass({
			outputStyle: 'compressed'
		}))

		// Combine similar rules.
		.pipe(cleancss({
			level: {
				2: {
					all: true
				}
			}
		}))

		// Minify and optimize style.css again.
		.pipe(cssnano({
			safe: false,
			discardComments: {
				removeAll: true,
			},
		}))

		// Add .min suffix.
		.pipe(rename({
			suffix: '.min'
		}))

		// Write source map.
		.pipe(sourcemaps.write('./'))

		// Output the compiled sass to this directory.
		.pipe(gulp.dest('assets/styles/min'))

		// Filtering stream to only css files.
		.pipe(filter('**/*.css'))

		// Notify on successful compile (uncomment for notifications).
		.pipe(notify("Compiled: <%= file.relative %>"));

});

/**
 * Minify javascript files.
 *
 * https://www.npmjs.com/package/gulp-uglify
 */
gulp.task('scripts', function () {

	gulp.src(paths.scripts)

		// Notify on error.
		.pipe(plumber({
			errorHandler: notify.onError("Error: <%= error.message %>")
		}))

		// Cache files to avoid processing files that haven't changed.
		.pipe(cache('scripts'))

		// Add .min suffix.
		.pipe(rename({
			suffix: '.min'
		}))

		// Minify.
		.pipe(uglify())

		// Output the processed js to this directory.
		.pipe(gulp.dest('assets/scripts/min'))

		// Inject changes via browsersync.
		.pipe(browsersync.reload({
			stream: true
		}))

		// Notify on successful compile.
		.pipe(notify("Minified: <%= file.relative %>"));

});

/**
 * Optimize images.
 *
 * https://www.npmjs.com/package/gulp-imagemin
 */
gulp.task('images', function () {

	return gulp.src(paths.images)

		// Notify on error.
		.pipe(plumber({
			errorHandler: notify.onError("Error: <%= error.message %>")
		}))

		// Cache files to avoid processing files that haven't changed.
		.pipe(cache('images'))

		// Optimize images.
		.pipe(imagemin({
			progressive: true
		}))

		// Output the optimized images to this directory.
		.pipe(gulp.dest('assets/images'))

		// Inject changes via browsersync.
		.pipe(browsersync.reload({
			stream: true
		}))

		// Notify on successful compile.
		.pipe(notify("Optimized: <%= file.relative %>"));

});

/**
 * Scan the theme and create a POT file.
 *
 * https://www.npmjs.com/package/gulp-wp-pot
 */
gulp.task('i18n', function () {

	return gulp.src(paths.php)

		.pipe(plumber({
			errorHandler: notify.onError("Error: <%= error.message %>")
		}))

		.pipe(sort())

		.pipe(wpPot({
			domain: 'business-pro-theme',
			destFile: 'business-pro.pot',
			package: 'Business Pro',
			bugReport: 'https://seothemes.com/support',
			lastTranslator: 'Lee Anthony <help@seothemes.com>',
			team: 'SEO Themes <help@seothemes.com>'
		}))

		.pipe(gulp.dest('./languages/'));

});

/**
 * Package theme.
 *
 * https://www.npmjs.com/package/gulp-zip
 */
gulp.task('zip', function () {

	gulp.src(['./**/*', '!./node_modules/', '!./node_modules/**', '!./aws.json'])
		.pipe(zip(__dirname.split("/").pop() + '.zip'))
		.pipe(gulp.dest('../'));

});

/**
 * Process tasks and reload browsers on file changes.
 *
 * https://www.npmjs.com/package/browser-sync
 */
gulp.task('watch', function () {

	// HTTPS.
	browsersync({
		proxy: 'https://business.dev',
		port: 8000,
		notify: false,
		open: false,
		https: {
			"key": "/Users/seothemes/.valet/Certificates/business.dev.key",
			"cert": "/Users/seothemes/.valet/Certificates/business.dev.crt"
		}
	});

	/**
	 * Non-HTTPS browsersync.
	 *
	 * Use this instead if you are not using a self signed
	 * certificate on your local development environment.
	 *
	 * browsersync( {
	 *     proxy: 'business.dev'
	 * } );
	 */

	// Run tasks when files change.
	gulp.watch(paths.woo, ['woo']);
	gulp.watch(paths.styles, ['styles']);
	gulp.watch(paths.scripts, ['scripts']);
	gulp.watch(paths.images, ['images']);
	gulp.watch(paths.php).on('change', browsersync.reload);

});

/**
 * Create default task.
 */
gulp.task('default', ['watch'], function () {
	gulp.start('woo', 'styles', 'scripts', 'images');
});
