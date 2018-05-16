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

// Register settings.
add_action( 'admin_menu', 'icon_widget_add_admin_menu' );
add_action( 'admin_init', 'icon_widget_settings_init' );

/**
 * Add settings menu item.
 *
 * @return void
 */
function icon_widget_add_admin_menu() {

	add_options_page( 'Icon Widget', 'Icon Widget', 'manage_options', 'icon_widget', 'icon_widget_options_page' );

}

/**
 * Initialize settings.
 *
 * @return void
 */
function icon_widget_settings_init() {

	register_setting( 'icon_widget_setting', 'icon_widget_settings' );

	add_settings_section(
		'icon_widget_section',
		__( 'Settings page for the Icon Widget plugin.', 'icon-widget' ),
		'icon_widget_settings_section_callback',
		'icon_widget_setting'
	);

	add_settings_field(
		'font',
		__( 'Icon font', 'icon-widget' ),
		'font_render',
		'icon_widget_setting',
		'icon_widget_section'
	);

}

/**
 * Render select dropdown.
 *
 * @return void
 */
function font_render() {

	$options  = get_option( 'icon_widget_settings' );
	$selected = $options['font'] ? $options['font'] : 'font-awesome';

	?>
	<select name='icon_widget_settings[font]'>
		<option value='font-awesome' <?php selected( $selected, 'font-awesome' ); ?>><?php esc_html_e( 'Font Awesome', 'icon-widget' ); ?></option>
		<option value='line-awesome' <?php selected( $selected, 'line-awesome' ); ?>><?php esc_html_e( 'Line Awesome', 'icon-widget' ); ?></option>
		<option value='ionicons' <?php selected( $selected, 'ionicons' ); ?>><?php esc_html_e( 'Ionicons', 'icon-widget' ); ?></option>
		<option value='streamline' <?php selected( $selected, 'streamline' ); ?>><?php esc_html_e( 'Streamline', 'icon-widget' ); ?></option>
	</select>

<?php

}

/**
 * Section description.
 *
 * @return void
 */
function icon_widget_settings_section_callback() {

	// Section description.
	echo __( '', 'icon-widget' );

}

/**
 * Display options page.
 *
 * @return void
 */
function icon_widget_options_page() {

	?>
	<div class="wrap">

	<h1>Icon Widget</h1>

	<form action='options.php' method='post'>

		<?php
		settings_fields( 'icon_widget_setting' );
		do_settings_sections( 'icon_widget_setting' );
		submit_button();
		?>

	</form>

	</div>

	<?php

}
