# Studio Pro Theme Changelog

## [2.2.2] - 2018-03-08
* Fix missing pages in demo import
* Fix Genesis Simple FAQ typo in recommended plugins
* Remove 404 template

## [2.2.1] - 2018-03-07
* Add one-click demo importer
* Add 404 page template (until Genesis 2.6)
* Add icon widget defaults
* Add styling for Genesis Simple FAQs

## [2.2.0] - 2018-02-01
* Add basic support and styling for Gutenberg
* Add support for WooCommerce gallery features
* Add asset concatenation gulp task/combine front-end JS into single file
* Add sourcemaps for WooCommerce styles
* Add Customizer data and jsbeautify config
* Add support and styling for after entry widget
* Add temp workaround for Testimonial Slider plugin and Genesis 2.6 conflict
* Fix page-header removal in all page templates
* Fix page-header CSS being output when no header image is set
* Fix strings in functions for gulp rename issue
* Fix page-header height when nav-secondary is active
* Fix comment formatting and consistency
* Remove theme support for title-tag to fix SEO settings conflict
* Remove Gravity Forms CSS override
* Remove custom portfolio archive in favor of standard loop
* Remove 404 page since it's not needed in Genesis 2.6
* Remove theme support for post-thumbnails (handled by Genesis)

## [2.1.4] - 2017-09-09
* Add archive title function
* Fix sub menu toggle on mobile
* Fix Archive Headline and Intro Text in hero section
* Fix title alignment
* Fix front page 2 widget alignment
* Fix WooCommerce categories using masonry template
* Fix post image sizes in front page 5 section

## [2.1.3] - 2017-08-14
* Update theme demo content to match new version
* Remove call to `home.php` from `front-page.php`
* Remove postMessage Customizer settings for WP core settings
* Remove 'all' selector from before footer.
* Fix masonry template check for CPT archives

## [2.1.2] - 2017-08-09
* Add theme support for portfolio custom headers
* Add Simple Social Icons to recommended plugins
* Update use Simple Social Icons for Header Right and Before Footer
* Update masonry blog can now be used as front page
* Update masonry template now used for archives

## [2.1.1] - 2017-08-04
* Update to use Custom Header Extended instead of featured images
* Remove custom header function to avoid confusion
* Fix custom header image size object-fit
* Fix Front Page 1 widget area overflow

## [2.1.0] - 2017-08-03
* Add RGBA Customizer color controls
* Add default setting to show Excerpt metabox
* Update Sass files to reduce file size
* Update blog layout - masonry now default
* Update and simplify front page template
* Update demo content for WordPress version 4.8.1
* Update seothemes URL from .net to .com
* Remove sidebars.php to simplify widget area functions
* Remove postMessage transport from Customizer controls
* Remove unnecessary woocommerce modifications
* Fix bug where post image is used for hero on front page
* Fix check for masonry template for the hero section
* Fix bug in customizer color gradient live preview
* Fix sub menu not breaking word
* Fix loading of WP Featherlight scripts and styles

## [2.0.2] - 2017-07-24
* Add .editorconfig file
* Add inline comments throughout theme
* Add `languages/` directory
* Add table of contents to stylesheet
* Add `do_shortcode` filter to `widget_text`
* Add publish task to gulpfile and update to work with https
* Update change priority of enqueue functions
* Update moved hooks and filters into functions.php
* Update switch to non-minified stylesheet
* Update separate front page widgets registered
* Update demo content to match new version
* Fix spacing, typos and .gitignore
* Fix check for WooCommerce
* Fix images fail to load in a subdirectory install
* Fix masonry template post titles
* Fix positioning of portfolio item title on Safari
* Fix google fonts typo (Monstserrat)
* Fix icon gradient Customizer output
* Fix styling for back to top button and before footer text
* Fix compatibility with Genesis Testimonial Slider update

## [2.0.1] - 2017-06-26
* Clean up doc comments and update readme
* Organize helpers.php and functions.php
* Move languages pot file to sub directory
* Remove unused images

## [2.0.0] - 2017-06-20
* Remove customizer toolkit dependency
* Remove Easy Widget Columns and Widgetized Page Template dependency
* Remove clean-up functionality, use Roots Soil instead
* Clean up directory structure
* General updates for Gulp, Sass, i18n

## [1.5.0] - 2017-04-02
* Add video background feature
* Add WooCommerce support
* Add customizer colors
* Add customizer fonts
* Add sticky header customizer option
* Add one-click demo import
* Add new page templates
* Add 'i18n' gulp task
* Add back to top scroll button
* Add cleaner-gallery
* Add cleaner-body classes
* Add jquery cdn with local fallback
* Add support for Genesis Testimonials plugin
* Add support for Easy Widget Columns plugin
* Add custom logo schema microdata
* Update clean-up functions
* Update hero-section class
* Update gulp (postcss, cssnano & mqpacker)
* Update Sass, split-up partials
* Update assets, moved to /assets/ direcrory
* Update list of recommended plugins
* Remove front-page.php (now uses widgetized template)
* Remove front page widget areas (now uses Easy Widget Columns)
* Remove backstretch
* Remove compression class to avoid plugin conflicts
* Other minor improvements

## [1.4.0] - 2017-03-03
* Add backstretch
* Add autoprefix for more browsers
* Add 'zip' task to gulpfile
* Convert all custom functionality into theme features
* Move everything out of functions.php into correct file in /lib.
* Combine customize.php and output.php into custom-colors.php
* Rename theme-compression and plugin-activation classes

## [1.3.1] - 2017-02-26
* Add readme & changelog
* Update gulpfile.js to enable theme packaging
* Remove font variables in functions.php

## [1.3.0] - 2017-02-26
* Remove WP-SCSS support
* Remove register-plugins.php (moved to class-plugin-activation.php)
* Remove Google Fonts Customizer support
* Add helper-functions.php
* Add output.php
* Add theme-defaults.php

## [1.2.0] - 2017-02-21
* Fix header image issues

## [1.0.0] - 2017-04-02
* Initial release