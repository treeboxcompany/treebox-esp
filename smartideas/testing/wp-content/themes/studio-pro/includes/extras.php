<?php
/**
 * Studio Pro Theme
 *
 * This file adds extra functions used in the Studio Pro Theme.
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

add_filter( 'body_class', 'studio_body_class' );
/**
 * Conditional body classes.
 *
 * @since  1.0.0
 *
 * @param  array $classes Body classes.
 *
 * @return array
 */
function studio_body_class( $classes ) {

	if ( get_theme_mod( 'studio_sticky_header', false ) === true ) {

		$classes[] = 'has-fixed-header';

	}

	if ( has_nav_menu( 'secondary' ) ) {

		$classes[] = 'has-nav-secondary';

	}

	if ( is_active_sidebar( 'before-header' ) ) {

		$classes[] = 'has-before-header';

	}

	if ( get_theme_mod( 'studio_blog_layout', 'masonry' ) === 'masonry' && is_home() || is_search() || is_archive() || is_page_template( 'page_blog.php' ) && ! is_post_type_archive() && ! is_tax() ) {

		$classes[] = 'layout-masonry';

	}

	return $classes;

}

add_action( 'genesis_before', 'studio_js_nojs_script', 1 );
/**
 * Echo out the script that changes 'no-js' class to 'js'.
 *
 * Adds a no-js body class to the front end, and a script on the genesis_before
 * hook which immediately changes the class to js if JavaScript is enabled.
 * This is how WP does things on the back end, to allow different styles
 * for the same elements depending if JavaScript is active or not.
 *
 * Outputting the script immediately also reduces a flash of incorrectly styled
 * content, as the page does not load with no-js styles, then switch to js
 * once everything has finished loading.
 *
 * @since  0.1.0
 *
 * @return void
 */
function studio_js_nojs_script() {

	?>
	<script>
	//<![CDATA[
	(function(){
		var c = document.body.classList;
		c.remove( 'no-js' );
		c.add( 'js' );
	})();
	//]]>
	</script>
	<?php

}

add_filter( 'genesis_attr_title-area', 'studio_title_area_schema' );
/**
 * Add schema microdata to title-area.
 *
 * @since  1.0.0
 *
 * @param  array $attr Array of attributes.
 *
 * @return array
 */
function studio_title_area_schema( $attr ) {

	$attr['itemscope'] = 'itemscope';
	$attr['itemtype']  = 'http://schema.org/Organization';

	return $attr;

}

add_filter( 'genesis_attr_site-title', 'studio_site_title_schema' );
/**
 * Correct site title schema.
 *
 * @since  1.0.0
 *
 * @param  array $attr Array of attributes.
 *
 * @return array
 */
function studio_site_title_schema( $attr ) {

	$attr['itemprop'] = 'name';

	return $attr;

}

add_action( 'genesis_admin_before_metaboxes', 'studio_remove_metaboxes' );
/**
 * Remove unused Theme Settings metaboxes.
 *
 * Remove unused metaboxes from the Genesis Theme Settings admin screen. This
 * theme removes the navigation extras, since this should not be displayed
 * in Genesis versions 2.1 and up. See link below for more information.
 *
 * @since  1.0.0
 *
 * @param  string $hook The metabox hook.
 *
 * @return void
 */
function studio_remove_metaboxes( $hook ) {

	remove_meta_box( 'genesis-theme-settings-nav', $hook, 'main' );

}

add_action( 'genesis_entry_header', 'studio_display_featured_image' );
/**
 * Display featured image on single portfolio items.
 *
 * Checks if single portfolio item has a featured image set and if so then displays
 * it before the entry content. This can be used for additional post types
 * by adding an array to the is_singular post type conditional check.
 *
 * @since  1.0.0
 *
 * @return void
 */
function studio_display_featured_image() {

	if ( ! is_singular( 'portfolio' ) ) {

		return;

	}

	if ( ! has_post_thumbnail() ) {

		return;

	}

	genesis_image( array(
		'size' => 'large',
	) );

}

add_action( 'genesis_entry_footer', 'studio_single_cpt_pagination' );
/**
 * Enable prev/next links on single portfolio items.
 *
 * @since  1.0.0
 *
 * @return void
 */
function studio_single_cpt_pagination() {

	if ( ! is_singular( 'portfolio' ) && ! is_singular( 'product' ) ) {

		return;

	}

	genesis_markup( array(
		'html5'   => '<div %s>',
		'context' => 'adjacent-entry-pagination',
	) );

		echo '<div class="pagination-previous alignleft">';
			previous_post_link( '<b>←%link</b>' );
		echo '</div>';
		echo '<div class="pagination-next alignright">';
			next_post_link( '<b>%link→</b>' );
		echo '</div>';

	echo '</div>';

}

add_action( 'genesis_before', 'studio_narrow_content_layout' );
/**
 * Force full-width page layout for narrow layout.
 *
 * Removes the primary and secondary sidebars that are automatically
 * displayed on the narrow layout by forcing a full width layout.
 *
 * @since  0.1.0
 *
 * @return string
 */
function studio_narrow_content_layout() {

	$layout = genesis_site_layout();

	if ( 'narrow-content' !== $layout ) {

		return;

	}

	add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

}

add_filter( 'genesis_site_layout', 'studio_page_template_layout' );
/**
 * Set page layout for special page templates.
 *
 * This function allows users to easily set the page layout for special page
 * templates such as the search and error 404 pages. Since we are giving
 * users control of the header image and excerpts in the same way, it
 * makes sense to also give them control of the page's layout too.
 * It works by checking if a page exists with a specific slug
 * and if so, uses the page layout setting for that page.
 *
 * @since  2.2.0
 *
 * @return string
 */
function studio_page_template_layout() {

	if ( is_search() ) {

		$page   = get_page_by_path( 'search' );
		$field  = $page ? genesis_get_custom_field( '_genesis_layout', $page->ID ) : false;
		$layout = $field ? $field : genesis_get_option( 'site_layout' );

		return $layout;

	}

	if ( is_404() ) {

		$page   = get_page_by_path( 'error' );
		$field  = $page ? genesis_get_custom_field( '_genesis_layout', $page->ID ) : false;
		$layout = $field ? $field : genesis_get_option( 'site_layout' );

		return $layout;

	}

}

add_action( 'genesis_entry_header', 'studio_reposition_post_meta', 0 );
/**
 * Reposition post info and remove excerpts on archives.
 *
 * Small customization to reposition the post info and remove the excerpt links
 * on all archive pages including search results, blog page, categories etc.
 *
 * @since 0.1.0
 *
 * @return void
 */
function studio_reposition_post_meta() {

	if ( is_home() || is_search() || is_archive() || is_page_template( 'page_blog.php' ) && ! is_post_type_archive() && ! is_tax() ) {

		// Remove the entry footer markup (requires HTML5 theme support).
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

		// Remove the entry meta in the entry footer (requires HTML5 theme support).
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

		// Remove read more link on archives.
		add_filter( 'get_the_content_more_link', '__return_empty_string' );

	}

}

add_filter( 'genesis_post_info', 'studio_post_info_date' );
/**
 * Change the default post info on archives.
 *
 * Replaces the default post info (author, comments, edit link) with just the
 * date of the post, which is then repositioned above the entry title with
 * the studio_reposition_post_meta() function above on archive pages.
 *
 * @since  0.1.0
 *
 * @param  string $post_info The default post information.
 *
 * @return string
 */
function studio_post_info_date( $post_info ) {

	if ( is_archive() || is_home() || is_search() || is_post_type_archive() ) {

		$post_info = '[post_date]';

	}

	return $post_info;

}

add_action( 'wp_head', 'studio_remove_ssi_inline_styles', 1 );
/**
 * Remove Simple Social Icons inline CSS.
 *
 * No longer needed because we are generating custom CSS instead, removing this
 * means that we don't need to use !important rules in the above function.
 *
 * @since  1.0.0
 *
 * @return void
 */
function studio_remove_ssi_inline_styles() {

	if ( class_exists( 'Simple_Social_Icons_Widget' ) ) {

		global $wp_widget_factory;

		remove_action( 'wp_head', array( $wp_widget_factory->widgets['Simple_Social_Icons_Widget'], 'css' ) );

	}

}

add_action( 'wp_head', 'studio_simple_social_icons_css' );
/**
 * Simple Social Icons multiple instances workaround.
 *
 * By default, Simple Social Icons only allows you to create one style for your
 * icons, even if you have multiple on one page. This function allows us to
 * output different styles for each widget that is output on the front end.
 *
 * @since  1.0.0
 *
 * @return void
 */
function studio_simple_social_icons_css() {

	if ( ! class_exists( 'Simple_Social_Icons_Widget' ) ) {

		return;

	}

	$obj = new Simple_Social_Icons_Widget();

	// Get widget settings.
	$all_instances = $obj->get_settings();

	// Loop through instances.
	foreach ( $all_instances as $key => $options ) :

		$instance = wp_parse_args( $all_instances[ $key ] );
		$font_size = round( (int) $instance['size'] / 2 );
		$icon_padding = round( (int) $font_size / 2 );

		// CSS to output.
		$css = '#' . $obj->id_base . '-' . $key . ' ul li a,
		#' . $obj->id_base . '-' . $key . ' ul li a:hover {
			background-color: ' . $instance['background_color'] . ';
			border-radius: ' . $instance['border_radius'] . 'px;
			color: ' . $instance['icon_color'] . ';
			border: ' . $instance['border_width'] . 'px ' . $instance['border_color'] . ' solid;
			font-size: ' . $font_size . 'px;
			padding: ' . $icon_padding . 'px;
		}
		
		#' . $obj->id_base . '-' . $key . ' ul li a:hover {
			background-color: ' . $instance['background_color_hover'] . ';
			border-color: ' . $instance['border_color_hover'] . ';
			color: ' . $instance['icon_color_hover'] . ';
		}';

		// Minify.
		$css = studio_minify_css( $css );

		// Output.
		printf( '<style type="text/css" media="screen">%s</style>', $css );

	endforeach;

}

add_action( 'init', 'studio_structural_wrap_hooks' );
/**
 * Add hooks immediately before and after Genesis structural wraps.
 *
 * @since   2.3.0
 *
 * @version 1.1.0
 * @author  Tim Jensen
 * @link    https://timjensen.us/add-hooks-before-genesis-structural-wraps
 *
 * @return void
 */
function studio_structural_wrap_hooks() {

	$wraps = get_theme_support( 'genesis-structural-wraps' );

	foreach ( $wraps[0] as $context ) {

		/**
		 * Inserts an action hook before the opening div and after the
		 * closing div for each of the structural wraps.
		 *
		 * @param string $output   HTML for opening or closing the structural wrap.
		 * @param string $original Either 'open' or 'close'.
		 *
		 * @return string
		 */
		add_filter( "genesis_structural_wrap-{$context}", function ( $output, $original ) use ( $context ) {

			$position = ( 'open' === $original ) ? 'before' : 'after';

			ob_start();

			do_action( "genesis_{$position}_{$context}_wrap" );

			if ( 'open' === $original ) {

				return ob_get_clean() . $output;

			} else {

				return $output . ob_get_clean();

			}

		}, 10, 2 );

	}

}

add_filter( 'genesis_markup_title-area_close', 'studio_after_title_area', 10, 2 );
/**
 * Appends HTML to the closing markup for .title-area.
 *
 * Adding something between the title + description and widget area used to require
 * re-building genesis_do_header(). However, since the title-area closing markup
 * now goes through genesis_markup(), it means we now have some extra filters
 * to play with. This function makes use of this and adds in an extra hook
 * after the title-area used for displaying the primary navigation menu.
 *
 * @since  0.1.0
 *
 * @param  string $close_html HTML tag being processed by the API.
 * @param  array  $args       Array with markup arguments.
 *
 * @return string
 */
function studio_after_title_area( $close_html, $args ) {

	if ( $close_html ) {

		ob_start();

		do_action( 'genesis_after_title_area' );

		$close_html = $close_html . ob_get_clean();

	}

	return $close_html;

}

add_filter( 'http_request_args', 'studio_dont_update_theme', 5, 2 );
/**
 * Don't Update Theme.
 *
 * If there is a theme in the repo with the same name,
 * this prevents WP from prompting an update.
 *
 * @since  1.0.0
 *
 * @param  array  $request Request arguments.
 * @param  string $url     Request url.
 *
 * @return array  request arguments
 */
function studio_dont_update_theme( $request, $url ) {

	 // Not a theme update request. Bail immediately.
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) ) {
		return $request;
	}

	$themes = unserialize( $request['body']['themes'] );

	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );

	$request['body']['themes'] = serialize( $themes );

	return $request;

}
