<?php
/**
 * This file registers the Testimonial custom post type.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Register Custom Post Type.
 */
function wpstudio_testimonials() {

	$labels = array(
		'name'                  => _x( 'Testimonials', 'Post Type General Name', 'wpstudio-testimonial-slider' ),
		'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'wpstudio-testimonial-slider' ),
		'menu_name'             => __( 'Testimonials', 'wpstudio-testimonial-slider' ),
		'name_admin_bar'        => __( 'Post Type', 'wpstudio-testimonial-slider' ),
		'archives'              => __( 'Testimonial Archives', 'wpstudio-testimonial-slider' ),
		'parent_item_colon'     => __( 'Parent Item:', 'wpstudio-testimonial-slider' ),
		'all_items'             => __( 'All Testimonials', 'wpstudio-testimonial-slider' ),
		'add_new_item'          => __( 'Add New Testimonial', 'wpstudio-testimonial-slider' ),
		'add_new'               => __( 'Add New', 'wpstudio-testimonial-slider' ),
		'new_item'              => __( 'New Testimonial', 'wpstudio-testimonial-slider' ),
		'edit_item'             => __( 'Edit Testimonial', 'wpstudio-testimonial-slider' ),
		'update_item'           => __( 'Update Item', 'wpstudio-testimonial-slider' ),
		'view_item'             => __( 'View Testimonial', 'wpstudio-testimonial-slider' ),
		'search_items'          => __( 'Search Item', 'wpstudio-testimonial-slider' ),
		'not_found'             => __( 'Not found', 'wpstudio-testimonial-slider' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'wpstudio-testimonial-slider' ),
		'featured_image'        => __( 'Testimonial Image', 'wpstudio-testimonial-slider' ),
		'set_featured_image'    => __( 'Set testimonial image', 'wpstudio-testimonial-slider' ),
		'remove_featured_image' => __( 'Remove testimonial image', 'wpstudio-testimonial-slider' ),
		'use_featured_image'    => __( 'Use as testimonial image', 'wpstudio-testimonial-slider' ),
		'insert_into_item'      => __( 'Insert into item', 'wpstudio-testimonial-slider' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'wpstudio-testimonial-slider' ),
		'items_list'            => __( 'Items list', 'wpstudio-testimonial-slider' ),
		'items_list_navigation' => __( 'Items list navigation', 'wpstudio-testimonial-slider' ),
		'filter_items_list'     => __( 'Filter items list', 'wpstudio-testimonial-slider' ),
	);
	$args   = array(
		'public'              => true,
		'label'               => __( 'Testimonial', 'wpstudio-testimonial-slider' ),
		'description'         => __( 'Testimonials', 'wpstudio-testimonial-slider' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-quote',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => false,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'rewrite'             => false,
		'capability_type'     => 'page',
		'register_rating'     => 'add_rating_metabox',
	);
	register_post_type( 'testimonial', $args );
}
add_action( 'init', 'wpstudio_testimonials', 0 );
