<?php
/**
 * Studio Pro Theme
 *
 * This file adds customizer settings to the Studio Pro theme.
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

/*
 * Add any theme custom colors here.
 */
$studio_colors = array(
	'gradient_left'  => 'rgba(100,66,255,0.9)',
	'gradient_right' => 'rgba(12,180,206,0.9)',
);

add_action( 'customize_register', 'studio_customize_register' );
/**
 * Sets up the theme customizer sections, controls, and settings.
 *
 * @since  1.0.0
 *
 * @param  object $wp_customize Global customizer object.
 *
 * @return void
 */
function studio_customize_register( $wp_customize ) {

	// Globals.
	global $wp_customize, $studio_colors;

	// Remove default colors, use custom instead.
	$wp_customize->remove_control( 'background_color' );
	$wp_customize->remove_control( 'header_textcolor' );

	// Load RGBA Customizer control.
	include_once( get_stylesheet_directory() . '/includes/rgba.php' );

	// Add logo size setting.
	$wp_customize->add_setting(
		'studio_logo_size',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => 100,
			'sanitize_callback' => 'studio_sanitize_number',
		)
	);

	// Add logo size control.
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'studio_logo_size',
		array(
			'label'       => __( 'Logo Size', 'studio-pro' ),
			'description' => __( 'Set the logo size in pixels. Default is 100.', 'studio-pro' ),
			'settings'    => 'studio_logo_size',
			'section'     => 'title_tagline',
			'type'        => 'number',
			'priority'    => 8,
		)
	) );

	// Add sticky header settings.
	$wp_customize->add_setting( 'studio_sticky_header',
		array(
			'capability' => 'edit_theme_options',
			'default'    => false,
		)
	);

	// Add sticky header controls.
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'studio_sticky_header',
		array(
			'label'    => __( 'Enable sticky header', 'studio-pro' ),
			'settings' => 'studio_sticky_header',
			'section'  => 'genesis_layout',
			'type'     => 'checkbox',
		)
	) );

	// Add header settings.
	$wp_customize->add_setting( 'studio_blog_layout',
		array(
			'capability' => 'edit_theme_options',
			'default'    => 'masonry',
		)
	);

	// Add header controls.
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'studio_blog_layout',
		array(
			'label'    => __( 'Blog Layout', 'studio-pro' ),
			'settings' => 'studio_blog_layout',
			'section'  => 'genesis_layout',
			'type'     => 'select',
			'choices'  => array(
				'default' => 'Default',
				'masonry' => 'Masonry',
			),
		)
	) );

	/**
	 * Custom colors.
	 *
	 * Loop through the global variable array of colors and register a customizer
	 * setting and control for each. To add additional color settings, do not
	 * modify this function, instead add your color name and hex value to
	 * the $studio_colors` array at the start of this file.
	 */
	foreach ( $studio_colors as $id => $rgba ) {

		// Format ID and label.
		$setting = "studio_{$id}_color";
		$label   = ucwords( str_replace( '_', ' ', $id ) ) . __( ' Color', 'studio-pro' );

		// Add color setting.
		$wp_customize->add_setting(
			$setting,
			array(
				'default'           => $rgba,
				'sanitize_callback' => 'sanitize_rgba_color',
			)
		);

		// Add color control.
		$wp_customize->add_control(
			new RGBA_Customize_Control(
				$wp_customize,
				$setting,
				array(
					'section'      => 'colors',
					'label'        => $label,
					'settings'     => $setting,
					'show_opacity' => true,
					'palette'      => array(
						'#000000',
						'#ffffff',
						'#dd3333',
						'#dd9933',
						'#eeee22',
						'#81d742',
						'#1e73be',
						'#8224e3',
					),
				)
			)
		);
	}
}

add_action( 'wp_enqueue_scripts', 'studio_customizer_output', 100 );
/**
 * Output customizer styles.
 *
 * Checks the settings for the colors defined in the settings. If any of these
 * values are set the appropriate CSS is output.
 *
 * @var   array $studio_colors Global theme colors.
 */
function studio_customizer_output() {

	// Defined at the top of this file.
	global $studio_colors;

	// Other customizer settings.
	$logo_size = get_theme_mod( 'studio_logo_size', 100 );

	/**
	 * Loop though each color in the global array of theme colors and create a new
	 * variable for each. This is just a shorthand way of creating multiple
	 * variables that we can reuse. The benefit of using a foreach loop
	 * over creating each variable manually is that we can just
	 * declare the colors once in the `$studio_colors` array,
	 * and they can be used in multiple ways.
	 */
	foreach ( $studio_colors as $id => $hex ) {

		${"$id"} = get_theme_mod( "studio_{$id}_color", $hex );

	}

	// Load color class.
	include_once( get_stylesheet_directory() . '/includes/colors.php' );

	// Initialize accent color.
	$accent = new Studio_Color( studio_rgba_to_hex( $gradient_left ) );
	$mix    = '#' . $accent->mix( studio_rgba_to_hex( $gradient_right ) );

	// Ensure $css var is empty.
	$css = '';

	/**
	 * Build the CSS.
	 *
	 * We need to concatenate each one of our colors to the $css variable, but
	 * first check if the color has been changed by the user from the theme
	 * customizer. If the theme mod is not equal to the default color then
	 * the string is appended to $css.
	 */
	$css .= ( $studio_colors['gradient_left'] !== $gradient_left || $studio_colors['gradient_right'] !== $gradient_right ) ? "
				
		.page-header:before,
		.before-footer:before,
		.front-page-4:before {
			background: {$gradient_left};
			background: -moz-linear-gradient(-45deg,  {$gradient_left} 0%, {$gradient_right} 100%);
			background: -webkit-linear-gradient(-45deg,  {$gradient_left} 0%,{$gradient_right} 100%);
			background: linear-gradient(135deg,  {$gradient_left} 0%,{$gradient_right} 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$gradient_left}', endColorstr='{$gradient_right}',GradientType=1 );
		}

		a,
		.button.white,
		button.white,
		input[type='button'].white,
		input[type='reset'].white,
		input[type='submit'].white,
		.entry-title a:hover,
		.entry-title a:focus,
		.site-footer .menu-item a:hover,
		.site-footer .menu-item a:focus,
		.archive-pagination a:hover,
		.archive-pagination .active a,
		.archive-pagination a:focus {
			color: {$mix};
		}

		input:focus,
		select:focus,
		textarea:focus {
			border-color: {$mix};
		}

		.has-fixed-header .site-header.shrink,
		.button.secondary,
		button.secondary,
		input[type='button'].secondary,
		input[type='reset'].secondary,
		input[type='submit'].secondary,
		.footer-widgets .enews input[type='submit'] {
			background-color: {$mix};
		}

		" : '';

	$css .= ( 100 !== $logo_size ) ? sprintf( '

		.wp-custom-logo .title-area {
			max-width: %1$spx;
		}

		', $logo_size ) : '';

	// WooCommerce only styles.
	if ( class_exists( 'WooCommerce') && studio_is_woocommerce_page() ) {

		$css .= ( $studio_colors['gradient_left'] !== $gradient_left || $studio_colors['gradient_right'] !== $gradient_right ) ? "

		.woocommerce .widget_layered_nav_filters ul li a:before,
		.woocommerce .widget_layered_nav ul li.chosen a:before,
		.woocommerce .widget_rating_filter ul li.chosen a:before,
		.woocommerce .woocommerce-breadcrumb a:focus,
		.woocommerce .woocommerce-breadcrumb a:hover,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:focus,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
		.woocommerce ul.products li.product:focus h2,
		.woocommerce ul.products li.product:hover h2,
		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce #respond input#submit.white,
		.woocommerce a.button.alt.white,
		.woocommerce a.button.white,
		.woocommerce button.button.alt.white,
		.woocommerce button.button.white,
		.woocommerce input.button.alt.white,
		.woocommerce input.button.white,
		.woocommerce input.button[type=submit].alt.white,
		.woocommerce input.button[type=submit].white {
			color: {$mix};
		}

		.woocommerce span.onsale,
		.woocommerce .woocommerce-pagination .page-numbers .active a,
		.woocommerce .woocommerce-pagination .page-numbers a:focus,
		.woocommerce .woocommerce-pagination .page-numbers a:hover,
		.woocommerce #respond input#submit.secondary,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-handle,
		.woocommerce a.button.alt.secondary,
		.woocommerce a.button.secondary,
		.woocommerce button.button.alt.secondary,
		.woocommerce button.button.secondary,
		.woocommerce input.button.alt.secondary,
		.woocommerce input.button.secondary,
		.woocommerce input.button[type=submit].alt.secondary,
		.woocommerce input.button[type=submit].secondary {
			background-color: {$mix};
		}

		" : '';

	}

	// Style handle is the name of the theme.
	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	// Output CSS if not empty.
	if ( ! empty( $css ) ) {

		// Add the inline styles, also minify CSS first.
		wp_add_inline_style( $handle, studio_minify_css( $css ) );

	}

}
