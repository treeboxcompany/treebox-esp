<?php
/**
 * Business Pro Theme
 *
 * This file adds Customizer settings to the Business Pro theme.
 *
 * @package   BusinessProTheme
 * @link      https://seothemes.com/themes/business-pro
 * @author    SEO Themes
 * @copyright Copyright © 2017 SEO Themes
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {

	die;

}

// Add theme customizer colors here.
$business_colors = array(
	'accent'  => '#fb2056',
	'overlay' => 'rgba(35,44,57,0.9)',
);

add_action( 'customize_register', 'business_customize_register' );
/**
 * Sets up the theme customizer sections, controls, and settings.
 *
 * @since  1.0.0
 *
 * @param  object $wp_customize Global customizer object.
 * @return void
 */
function business_customize_register( $wp_customize ) {

	// Globals.
	global $wp_customize, $business_colors;

	// Add logo size setting.
	$wp_customize->add_setting(
		'business_logo_size',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => 100,
			'sanitize_callback' => 'business_sanitize_number',
		)
	);

	// Add logo size control.
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'business_logo_size',
		array(
			'label'       => __( 'Logo Size', 'business-pro-theme' ),
			'description' => __( 'Set the logo size in pixels. Default is 100.', 'business-pro-theme' ),
			'settings'    => 'business_logo_size',
			'section'     => 'title_tagline',
			'type'        => 'number',
			'priority'    => 8,
		)
	) );

	// Add fixed header settings.
	$wp_customize->add_setting( 'business_fixed_header',
		array(
			'capability' => 'edit_theme_options',
			'default'    => false,
		)
	);

	// Add fixed header controls.
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'business_fixed_header',
		array(
			'label'    => __( 'Enable fixed header', 'business-pro-theme' ),
			'settings' => 'business_fixed_header',
			'section'  => 'genesis_layout',
			'type'     => 'checkbox',
		)
	) );

	// Remove default colors, use custom instead.
	$wp_customize->remove_control( 'background_color' );
	$wp_customize->remove_control( 'header_textcolor' );

	// Load RGBA Customizer control.
	include_once( get_stylesheet_directory() . '/includes/rgba.php' );

	/**
	 * Custom colors.
	 *
	 * Loop through the global variable array of colors and register a customizer
	 * setting and control for each. To add additional color settings, do not
	 * modify this function, instead add your color name and hex value to
	 * the $business_colors` array at the start of this file.
	 */
	foreach ( $business_colors as $id => $rgba ) {

		// Format ID and label.
		$setting = "business_{$id}_color";
		$label   = ucwords( str_replace( '_', ' ', $id ) ) . __( ' Color', 'business-pro-theme' );

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

add_action( 'wp_enqueue_scripts', 'business_customizer_output', 100 );
/**
 * Output customizer styles.
 *
 * Checks the settings for the colors defined in the settings. If
 * any of these value are set the appropriate CSS is output.
 *
 * @since  1.0.0
 *
 * @var    array $business_colors Global theme colors.
 * @return void
 */
function business_customizer_output() {

	// Set in customizer-settings.php.
	global $business_colors;

	// Other customizer settings.
	$logo_size = get_theme_mod( 'business_logo_size', 100 );

	/**
	 * Loop though each color in the global array of theme colors and create a new
	 * variable for each. This is just a shorthand way of creating multiple
	 * variables that we can reuse. The benefit of using a foreach loop
	 * over creating each variable manually is that we can just
	 * declare the colors once in the `$business_colors`
	 * array and they can be used in multiple ways.
	 */
	foreach ( $business_colors as $id => $hex ) {
		${"$id"} = get_theme_mod( "business_{$id}_color",  $hex );
	}

	// Ensure $css var is empty.
	$css = '';

	/**
	 * Build the CSS.
	 *
	 * We need to concatenate each one of our colors to the $css variable,
	 * but first check if the color has been changed by the user from
	 * the theme customizer. If the theme mod is not equal to the
	 * default color then the string is appended to $css.
	 */
	$css .= ( $business_colors['accent'] !== $accent ) ? sprintf( '

		button.accent,
		.button.accent,
		button.accent:hover,
		.button.accent:hover,
		button.accent:focus,
		.button.accent:focus,
		.menu-item.button > a > span,
		.archive-pagination a:hover,
		.archive-pagination a:focus,
		.archive-pagination .active a,
		.pricing-table .featured .button,
		.pricing-table .featured button,
		.archive-pagination a:hover,
		.archive-pagination .active a,
		.front-page-3 .widget_custom_html:first-of-type hr,
		.front-page-5 .widget_custom_html:first-of-type hr {
			background-color: %1$s;
		}

		.front-page-2 .fa {
			color: %1$s;
		}

		', $accent ) : '';

	$css .= ( $business_colors['overlay'] !== $overlay ) ? sprintf( '

		.page-header:before,
		.front-page-4:before,
		.before-footer:before {
			background-color: %1$s;
		}

		', $overlay ) : '';

	$css .= ( 100 !== $logo_size ) ? sprintf( '
	
		.wp-custom-logo .title-area {
			max-width: %1$spx;
		
		}

		', $logo_size ) : '';

	// WooCommerce only styles.
	if ( class_exists( 'WooCommerce' ) && business_is_woocommerce_page() ) {

		$css .= ( $business_colors['accent'] !== $accent ) ? sprintf( '

			.woocommerce a.button:hover,
			.woocommerce a.button:focus,
			.woocommerce a.button,
			.woocommerce a.button.alt:hover,
			.woocommerce a.button.alt:focus,
			.woocommerce a.button.alt,
			.woocommerce button.button:hover,
			.woocommerce button.button:focus,
			.woocommerce button.button,
			.woocommerce button.button.alt:hover,
			.woocommerce button.button.alt:focus,
			.woocommerce button.button.alt,
			.woocommerce input.button:hover,
			.woocommerce input.button:focus,
			.woocommerce input.button,
			.woocommerce input.button.alt:hover,
			.woocommerce input.button.alt:focus,
			.woocommerce input.button.alt,
			.woocommerce input[type="submit"]:hover,
			.woocommerce input[type="submit"]:focus,
			.woocommerce input[type="submit"],
			.woocommerce #respond input#submit:hover,
			.woocommerce #respond input#submit:focus,
			.woocommerce #respond input#submit,
			.woocommerce #respond input#submit.alt:hover,
			.woocommerce #respond input#submit.alt:focus,
			.woocommerce #respond input#submit.alt,
			.woocommerce input.button[type=submit]:focus,
			.woocommerce input.button[type=submit],
			.woocommerce input.button[type=submit]:hover,
			.woocommerce.widget_price_filter .ui-slidui-slider-handle,
			.woocommerce.widget_price_filter .ui-slidui-slider-range {
				background-color: %1$s;
			}

			', $accent ) : '';

	}

	// Style handle is the name of the theme.
	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	// Output CSS if not empty.
	if ( ! empty( $css ) ) {

		// Add the inline styles, also minify CSS first.
		wp_add_inline_style( $handle, business_minify_css( $css ) );

	}
}
