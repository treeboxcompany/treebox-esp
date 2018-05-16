<?php
/**
 * This file adds the plugin settings.
 *
 * @package Icon_Widget
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

add_shortcode( 'icon_widget', 'icon_widget_shortcode' );
/**
 * Add Shortcode.
 */
function icon_widget_shortcode( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'classes' => 'icon-widget',
			'title'   => 'Icon Widget',
			'content' => 'Add a short description.',
			'icon'    => apply_filters( 'icon_widget_default_shortcode_icon', 'fa-star' ),
			'size'    => apply_filters( 'icon_widget_default_size', '2x' ),
			'align'   => apply_filters( 'icon_widget_default_align', 'center' ),
			'color'   => apply_filters( 'icon_widget_default_color','#333333' ),
			'heading' => 'h4',
			'break'   => '<br>',
		),
		$atts,
		'icon_widget'
	);

	// Store variables.
	$classes = $atts['classes'];
	$title   = $atts['title'];
	$content = $atts['content'];
	$icon    = $atts['icon'];
	$size    = $atts['size'];
	$align   = $atts['align'];
	$color   = $atts['color'];
	$heading = $atts['heading'];
	$break   = $atts['break'];

	// Build HTML.
	$html = '';

	$html .= '<div class="' . $classes . '" style="text-align: ' . $align . '">';

	$html .= '<i class="fa ' . $icon . ' fa-' . $size . '" style="color: ' . $color . '"></i>';

	$html .= apply_filters( 'icon_widget_line_break', $break );

	$html .= '<' . $heading . ' class="widget-title">' . $title . '</' . $heading . '>';

	$html .= apply_filters( 'icon_widget_wpautop', true ) ? wp_kses_post( wpautop( $content ) ) : wp_kses_post( $content );

	$html .= '</div>';

	return $html;

}
