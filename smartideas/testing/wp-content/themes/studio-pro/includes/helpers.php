<?php
/**
 * Studio Pro Theme
 *
 * This file adds helper functions used in the Studio Pro Theme.
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

/**
 * Sanitize number values.
 *
 * Ensure number is an absolute integer (whole number, zero or greater). If
 * input is an absolute integer, return it. Otherwise, return default.
 *
 * @since  2.0.0
 *
 * @param  string $number The rgba color to sanitize.
 * @param string $setting Sanitized value.
 *
 * @return string
 */
function studio_sanitize_number( $number, $setting ) {

	$number = absint( $number );

	return ( $number ? $number : $setting->default );

}

/**
 * Sanitize RGBA values.
 *
 * If string does not start with 'rgba', then treat as hex then
 * sanitize the hex color and finally convert hex to rgba.
 *
 * @since  2.0.0
 *
 * @param  string $color The rgba color to sanitize.
 *
 * @return string $color Sanitized value.
 */
function sanitize_rgba_color( $color ) {

	// Return invisible if empty.
	if ( empty( $color ) || is_array( $color ) ) {

		return 'rgba(0,0,0,0)';

	}

	// Return sanitized hex if not rgba value.
	if ( false === strpos( $color, 'rgba' ) ) {

		return sanitize_hex_color( $color );

	}

	// Finally, sanitize and return rgba.
	$color = str_replace( ' ', '', $color );
	sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

	return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';

}

/**
 * Convert hex to rgba value.
 *
 * This function takes a hex code (e.g. #eeeeee) and returns array of RGBA
 * values. Used in studio_customizer_output to handle transparency.
 *
 * @since  0.1.0
 *
 * @param  string $color  Hex color to convert.
 * @param  int    $opacity Opacity amount.
 *
 * @return string
 */
function studio_hex_to_rgba( $color, $opacity ) {

	if ( '#' === $color[0] ) {

		$color = substr( $color, 1 );

	}

	if ( strlen( $color ) === 6 ) {

		list( $r, $g, $b ) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );

	} elseif ( strlen( $color ) === 3 ) {

		list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );

	} else {

		return false;

	}

	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );

	$rgb  = array(
		'red' => $r,
		'green' => $g,
		'blue' => $b,
	);

	$rgba = implode( $rgb, ',' ) . ',' . $opacity;

	return $rgba;

}

/**
 * Convert rgba to hex value.
 *
 * This function takes an rgba code (e.g. rgba(100,200,300,1)) and returns
 * array of RGBA values. First checks if the string is a hex value and
 * converts it into and RGBA using studio_hex_to_rgba if necessary.
 *
 * @since  0.1.0
 *
 * @param  string $string RGBA color to convert.
 *
 * @return string
 */
function studio_rgba_to_hex( $string ) {

	$rgba  = array();
	$hex   = '';
	$regex = '#\((([^()]+|(?R))*)\)#';

	if ( strpos( $string, ',' ) != true ) {

		$string = 'rgba(' . studio_hex_to_rgba( $string, '1' ) . ')';

	}

	if ( preg_match_all( $regex, $string ,$matches ) ) {

		$rgba = explode( ',', implode( ' ', $matches[1] ) );

	} else {

		$rgba = explode( ',', $string );

	}

	$rr = str_pad( dechex( $rgba['0'] ), 2, '0', STR_PAD_LEFT );
	$gg = str_pad( dechex( $rgba['1'] ), 2, '0', STR_PAD_LEFT );
	$bb = str_pad( dechex( $rgba['2'] ), 2, '0', STR_PAD_LEFT );
	$aa = '';

	if ( array_key_exists( '3', $rgba ) ) {

		$aa = dechex( $rgba['3'] * 255 );

	}

	return strtoupper( "#$rr$gg$bb" );

}

/**
 * Minify CSS helper function.
 *
 * @since  2.0.0
 *
 * @author Gary Jones
 * @link   https://github.com/GaryJones/Simple-PHP-CSS-Minification
 * @param  string $css The CSS to minify.
 *
 * @return string Minified CSS.
 */
function studio_minify_css( $css ) {

	// Normalize whitespace.
	$css = preg_replace( '/\s+/', ' ', $css );

	// Remove spaces before and after comment.
	$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );

	// Remove comment blocks, everything between /* and */, unless preserved with /*! ... */ or /** ... */.
	$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );

	// Remove ; before }.
	$css = preg_replace( '/;(?=\s*})/', '', $css );

	// Remove space after , : ; { } */ >.
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

	// Remove space before , ; { } ( ) >.
	$css = preg_replace( '/ (,|;|\{|}|\(|\)|>)/', '$1', $css );

	// Strips leading 0 on decimal values (converts 0.5px into .5px).
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

	// Strips units if value is 0 (converts 0px to 0).
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

	// Converts all zeros value into short-hand.
	$css = preg_replace( '/0 0 0 0/', '0', $css );

	// Shorten 6-character hex color codes to 3-character where possible.
	$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

	return trim( $css );

}

/**
 * Helper function to check if we're on a WooCommerce page.
 *
 * @since  2.0.0
 *
 * @link   https://docs.woocommerce.com/document/conditional-tags/.
 *
 * @return bool
 */
function studio_is_woocommerce_page() {

	if ( ! class_exists( 'WooCommerce' ) ) {

		return false;

	}

	if ( is_woocommerce() || is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() ) {

		return true;

	} else {

		return false;

	}

}

add_filter( 'display_posts_shortcode_post_class', 'studio_dps_column_classes', 10, 4 );
/**
 * Column Classes
 *
 * Columns Extension for Display Posts Shortcode plugin makes it easy for
 * users to display posts in columns using [display-posts columns="2"]
 *
 * @since  1.0.0
 *
 * @author Bill Erickson <bill@billerickson.net>
 * @link   http://www.billerickson.net/shortcode-to-display-posts/
 * @param  array  $classes Current CSS classes.
 * @param  object $post    The post object.
 * @param  object $listing The WP Query object for the listing.
 * @param  array  $atts    Original shortcode attributes.
 *
 * @return array  $classes Modified CSS classes.
 */
function studio_dps_column_classes( $classes, $post, $listing, $atts ) {

	if ( ! isset( $atts['columns'] ) ) {

		return $classes;

	}

	$columns = intval( $atts['columns'] );

	if ( $columns < 2 || $columns > 6 ) {

		return $classes;

	}

	$column_classes = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );

	$classes[] = $column_classes[ $columns ];

	if ( 0 == $listing->current_post % $columns ) {

		$classes[] = 'first';

	}

	return $classes;

}

/**
 * Custom header image callback.
 *
 * Loads custom header or featured image depending on what is set on a per
 * page basis. If a featured image is set for a page, it will override
 * the default header image. It also gets the image for custom post
 * types by looking for a page with the same slug as the CPT e.g
 * the Portfolio CPT archive will pull the featured image from
 * a page with the slug of 'portfolio', if the page exists.
 *
 * @since  0.1.0
 *
 * @return string
 */
function studio_custom_header() {

	$id = '';

	// Get the current page ID.
	if ( class_exists( 'WooCommerce' ) && is_shop() ) {

		$id = wc_get_page_id( 'shop' );

	} elseif ( is_post_type_archive() ) {

		$id = get_page_by_path( get_query_var( 'post_type' ) );

	} elseif ( is_front_page() ) {

		$id = get_option( 'page_on_front' );

	} elseif ( is_home() ) {

		$id = get_option( 'page_for_posts' );

	} elseif ( is_search() ) {

		$id = get_page_by_path( 'search' );

	} elseif ( is_404() ) {

		$id = get_page_by_path( 'error' );

	} elseif ( is_singular() ) {

		$id = get_the_id();

	}

	$url = get_the_post_thumbnail_url( $id, 'slider' );

	if ( ! $url ) {

		$url = get_header_image();

	}

	return has_header_image() ? printf( '<style type="text/css">.page-header{background-image: url(%s);}</style>' . "\n", esc_url( $url ) ) : '';

}
