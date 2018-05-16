<?php
/**
 * Business Pro Theme
 *
 * This file adds the page builder template to the Business Pro theme.
 * It removes everything between the site header and footer leaving
 * a blank template perfect for page builder plugins.
 *
 * Template Name: Page Builder
 *
 * @package      Business Pro
 * @link         https://seothemes.com/themes/business-pro
 * @author       SEO Themes
 * @copyright    Copyright © 2017 SEO Themes
 * @license      GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {

	die;

}

// Remove default page header.
remove_action( 'genesis_after_header', 'business_page_header_open', 20 );
remove_action( 'genesis_after_header', 'business_page_header_title', 24 );
remove_action( 'genesis_after_header', 'business_page_header_close', 28 );

// Remove before footer widget area.
remove_action( 'genesis_footer', 'business_before_footer_widget_area', 5 );

// Get site-header.
get_header();

// Custom loop, remove all hooks except entry content.
if ( have_posts() ) :

	the_post();

	do_action( 'genesis_entry_content' );

endif; // End loop.

// Get site-footer.
get_footer();
