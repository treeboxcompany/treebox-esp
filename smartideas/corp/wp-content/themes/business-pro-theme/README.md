# Business Pro Theme

A robust and flexible WordPress theme for businesses of any kind. Demo - [https://demo.seothemes.com/business-pro](https://demo.seothemes.com/business-pro)


## Features

- Custom Colors
  
  Business Pro provides custom color settings with transparency/opacity options giving you even more control over your theme's colors

- Hero Image or Video
  
  Upload your own video or a YouTube URL for the background. Each page can also have it's own hero image by simply setting a featured image

- Widget Columns
  
  Create your own front page layouts with easy to use widget column classes

- Beyond Optimized
  
  Extensive schema microdata implementation to ensure search engines understand your content and business

- Lightbox Gallery
  
  Show of your work with the built in responsive lightbox gallery shortcode

- WooCommerce
  
  Fully integrated with the world's most popular WordPress eCommerce plugin WooCommerce

- Masonry Grid
  
  Business Pro includes a masonry portfolio and blog that looks great and works at all screen sizes

- Testimonials
  
  Display your best customer reviews with the easy to use, search engine optimized Genesis Testimonial plugin

- Google Fonts
  
  This theme uses minimal, super fast loading and great looking Google Fonts for the fastest performance

- Fully Responsive
  
  Needless to say that this theme looks great and works at any screen size on any device

- Fixed Header
  
  Enable a fixed header easily by adding one line of code to your theme

- Templates & Layouts
  
  Custom page templates and layouts provide plenty of options for displaying your content


## Recommendations

* PHP > 7.0
* WordPress > 4.8.1
* Genesis Framework > 2.4
* Node.js > 6.9
* Gulp.js > 3.9


## Installation

1. Upload and install Genesis
2. Upload, install and activate Business Pro
3. Install and activate recommended plugins
4. *Important* Delete unwanted existing posts, pages, comments & widgets
5. Import sample.xml from Tools > Import
6. Import widgets.wie from Tools > Widget Importer & Exporter


## Customization

1. Go to Appearance > Customize > Site Identity to upload a logo
2. Go to Appearamce > Customize > Header Media to upload hero image or video
3. Go to Appearance > Customize > Menus to create menus
4. Go to Appearance > Customize > Static Front Page and configure to your liking
5. Go to Appearance > Customize > Site Layout and configure to your liking
6. Go to Genesis > Theme Settings to enable Breadcrumbs on pages


## Widget Areas

* Header right
* Primary sidebar
* Before footer
* Front page
* Footer


## Structure

```shell
theme/  
├── assets/
│   ├── images/
│   ├── scripts/
│   └── styles/
├── includes/
│   ├── customize.php
│   ├── defaults.php
│   ├── helpers.php
│   └── plugins.php
├── languages/
│   └── business-pro.pot
├── templates/
│   ├── page-builder.php
│   ├── page-landing.php
│   ├── page-masonry.php
│   └── page-service.php
├── .editorconfig
├── .gitignore
├── archive-portfolio.php
├── CHANGELOG.md
├── front-page.php
├── functions.php
├── gulpfile.js
├── package.json
├── README.md
├── sample.xml
├── screenshot.png
├── style.css
└── widgets.wie
```


## Development

Business Pro uses [Gulp](http://gulpjs.com/) as a build tool and [npm](https://www.npmjs.com/) to manage front-end packages.

### Install dependencies

From the command line on your host machine, navigate to the theme directory then run `npm install`:

```shell
# @ themes/your-theme-name/
$ npm install
```

You now have all the necessary dependencies to run the build process.

### Build commands

* `gulp styles` — Compile, autoprefix and minify Sass files.
* `gulp scripts` — Minify javascript files.
* `gulp images` — Compress and optimize images.
* `gulp watch` — Compile assets when file changes are made, start BrowserSync
* `gulp` — Default task - runs all of the above tasks.


#### Additional commands

* `gulp i18n` — Scan the theme and create `languages.pot` POT file.
* `gulp zip` — Package theme into zip file for distribution, ignoring `node_modules`.


### Using BrowserSync

To use BrowserSync you need to update the proxy URL in `gulpfile.js` to reflect your local development hostname. If you are using a self-signed SSL certificate on your localhost, keep the BrowserSync settings the same, just change the URL. If not using an SSL, remove the default settings and use the commented-out settings from line 313 - 315.

If your local development URL is `my-site.dev`, update the file to read:

```javascript
...
  proxy: 'my-site.dev',
...
```


## Support

Please visit https://seothemes.com/support/ for theme support.
