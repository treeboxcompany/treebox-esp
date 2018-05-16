<?php
/**
 * Studio Pro Theme
 *
 * This file registers the default settings for the Studio Pro theme.
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

add_filter( 'genesis_theme_settings_defaults', 'studio_theme_defaults' );
/**
 * Update Theme Settings upon reset.
 *
 * @since  1.0.0
 *
 * @param  array $defaults Default theme settings.
 *
 * @return array Custom theme settings.
 */
function studio_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive']           = 'excerpt';
	$defaults['content_archive_limit']     = 300;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignnone';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['image_size']                = 'large';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

add_action( 'after_switch_theme', 'studio_theme_setting_defaults' );
/**
 * Update Theme Settings upon activation.
 *
 * @since 1.0.0
 *
 * @return void
 */
function studio_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,
			'content_archive'           => 'excerpt',
			'content_archive_limit'     => 300,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignnone',
			'image_size'                => 'large',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );

	}

	update_option( 'posts_per_page', 8 );

}

add_filter( 'simple_social_default_styles', 'studio_social_default_styles' );
/**
 * Studio Pro Simple Social Icon Defaults.
 *
 * @since  2.0.0
 * 
 * @param  array $defaults Default Simple Social Icons settings.
 *
 * @return array Custom settings.
 */
function studio_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#eeeeee',
		'background_color_hover' => '#333333',
		'border_radius'          => 0,
		'border_color'           => '#ffffff',
		'border_color_hover'     => '#ffffff',
		'border_width'           => 0,
		'icon_color'             => '#333333',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 40,
		'new_window'             => 1,
		'facebook'               => '#',
		'gplus'                  => '#',
		'instagram'              => '#',
		'dribbble'               => '#',
		'twitter'                => '#',
		'youtube'                => '#',
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}

add_filter( 'icon_widget_default_font', 'studio_icon_widget_default_font' );
/**
 * Set the default icon widget font.
 *
 * @since  2.2.1
 *
 * @return string
 */
function studio_icon_widget_default_font() {

	return 'streamline';

}

add_filter( 'icon_widget_default_color', 'studio_icon_widget_default_color' );
/**
 * Set the default icon widget font.
 *
 * @since  2.2.1
 *
 * @return string
 */
function studio_icon_widget_default_color() {

	return '#1885ec';

}

add_filter( 'icon_widget_default_size', 'studio_icon_widget_default_size' );
/**
 * Set the default icon widget font.
 *
 * @since  2.2.1
 *
 * @return string
 */
function studio_icon_widget_default_size() {

	return '3x';

}

add_filter( 'icon_widget_default_align', 'studio_icon_widget_default_align' );
/**
 * Set the default icon widget font.
 *
 * @since  2.2.1
 *
 * @return string
 */
function studio_icon_widget_default_align() {

	return 'center';

}

add_action( 'after_switch_theme', 'studio_excerpt_metabox' );
/**
 * Display excerpt metabox by default.
 *
 * Studio Pro adds support for excerpts on pages to be used as subtitles on the
 * front end of the site. The excerpt metabox is hidden by default on the
 * page edit screen which can cause some confusion for users when they
 * want to edit or remove the excerpt. To make it easier, we want to
 * show the excerpt metabox by default. It only runs after a theme
 * switch so the current user's screen options are updated,
 * allowing them to hide the metabox if not used.
 *
 * @since  2.2.1
 *
 * @return void
 */
function studio_excerpt_metabox() {

	// Get current user ID.
	$user_id = get_current_user_id();

	// Create array of post types to include.
	$post_types = array(
		'page',
		'post',
		'portfolio',
	);

	// Loop through each post type and update user meta.
	foreach ( $post_types as $post_type ) {

		// Create variables.
		$meta_key   = 'metaboxhidden_' . $post_type;
		$prev_value = get_user_meta( $user_id, $meta_key, true );

		// Check if value is an array.
		if ( ! is_array( $prev_value ) ) {

			$prev_value = array(
				'genesis_inpost_seo_box',
				'postcustom',
				'postexcerpt',
				'commentstatusdiv',
				'commentsdiv',
				'slugdiv',
				'authordiv',
				'genesis_inpost_scripts_box',
			);

		}

		// Empty array to prevent errors.
		$meta_value = array();

		// Remove excerpt from array.
		$meta_value = array_diff( $prev_value, array( 'postexcerpt' ) );

		// Update user meta with new value.
		update_user_meta( $user_id, $meta_key, $meta_value, $prev_value );

	}

}

add_filter( 'pt-ocdi/import_files', 'studio_demo_import' );
/**
 * One click demo import settings.
 *
 * @since  2.2.0
 *
 * @return array
 */
function studio_demo_import() {

	return array(
		array(
			'local_import_file'            => get_stylesheet_directory() . '/sample.xml',
			'local_import_widget_file'     => get_stylesheet_directory() . '/widgets.wie',
			'local_import_customizer_file' => get_stylesheet_directory() . '/customizer.dat',
			'import_file_name'             => 'Demo Import',
			'categories'                   => false,
			'local_import_redux'           => false,
			'import_preview_image_url'     => false,
			'import_notice'                => false,
		),
	);

}

add_filter( 'pt-ocdi/after_all_import_execution', 'studio_after_demo_import', 999 );
/**
 * Set default pages after demo import.
 *
 * Automatically creates and sets the Static Front Page and the Page for Posts
 * upon theme activation, only if these pages don't already exist and only
 * if the site does not already display a static page on the homepage.
 *
 * @since  2.2.0
 *
 * @uses   studio_slug_exists Helper function.
 *
 * @return void
 */
function studio_after_demo_import() {

	// Assign menus to their locations.
	$menu = get_term_by( 'name', 'Header Menu', 'nav_menu' );

	if ( $menu ) {

		set_theme_mod( 'nav_menu_locations', array(
			'primary' => $menu->term_id,
		) );

	}

	// Assign front page and posts page (blog page).
	$home = get_page_by_title( 'Home' );
	$blog = get_page_by_title( 'Blog' );

	if ( $home && $blog ) {

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home->ID );
		update_option( 'page_for_posts', $blog->ID );

	}

	// Set the WooCommerce shop page.
	$shop = get_page_by_title( 'Shop' );
	if ( $shop ) {

		update_option( 'woocommerce_shop_page_id', $shop->ID );

	}

	// Trash "Hello World" post.
	wp_delete_post( 1 );

	// Update permalink structure.
	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure( '/%postname%/' );
	$wp_rewrite->flush_rules();

}
