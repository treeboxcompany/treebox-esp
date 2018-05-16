<?php
/**
 * Studio Pro
 *
 * Template Name: Landing Page
 *
 * This file adds the landing page template to the Studio Pro Theme.
 *
 * @package   StudioPro
 * @link      https://seothemes.com/themes/studio-pro
 * @author    SEO Themes
 * @copyright Copyright © 2017 SEO Themes
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {

	die;

}

add_filter( 'body_class', 'studio_landing_page_body_class' );
/**
 * Add landing page body class to the head.
 *
 * @param  array $classes Array of body classes.
 * @return array $classes Array of body classes.
 */
function studio_landing_page_body_class( $classes ) {

	$classes[] = 'landing-page';

	return $classes;

}

add_action( 'wp_enqueue_scripts', 'studio_dequeue_skip_links' );
/**
 * Dequeue Skip Links Script.
 *
 * @return void
 */
function studio_dequeue_skip_links() {

	wp_dequeue_script( 'skip-links' );

}

add_action( 'genesis_before', 'studio_landing_page_title', 99 );
/**
 * Add page title back to entry header.
 *
 * This action is removed in the includes/header.php file. Since this
 * template doesn't use the page header section we need to add the
 * title back to it's original location inside the entry header.
 *
 * @return void
 */
function studio_landing_page_title() {

	add_action( 'genesis_entry_header', 'genesis_do_post_title' );

}

// Remove Skip Links.
remove_action( 'genesis_before_header', 'genesis_skip_links', 5 );

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove default page header.
remove_action( 'genesis_before_content_sidebar_wrap', 'studio_page_header' );

// Remove navigation.
remove_theme_support( 'genesis-menus' );

// Remove breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove footer widgets.
remove_theme_support( 'genesis-footer-widgets' );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Run the Genesis loop.
genesis();
