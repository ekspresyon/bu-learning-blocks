<?php
/**
 * Register the Learning Module custom post type.
 *
 * @since   0.0.1
 * @package BU Learning Blocks
 */

/**
 * Calls register_post_type
 *
 * @since 0.0.1
 */
function bulb_register_learning_module_post_type() {
	// Set various pieces of text, $labels is used inside the $args array.
	$labels = array(
		'name'               => __( 'Learning Modules', 'bulearningblocks' ),
		'singular_name'      => __( 'Learning Module', 'bulearningblocks' ),
		'add_new'            => __( 'Add New Learning Module', 'bulearningblocks' ),
		'add_new_item'       => __( 'Add New Learning Module', 'bulearningblocks' ),
		'edit_item'          => __( 'Edit Learning Module', 'bulearningblocks' ),
		'new_item'           => __( 'New Learning Module', 'bulearningblocks' ),
		'all_items'          => __( 'All Learning Modules', 'bulearningblocks' ),
		'view_item'          => __( 'View Learning Module', 'bulearningblocks' ),
		'view_items'         => __( 'View Learning Modules', 'bulearningblocks' ),
		'attributes'         => __( 'Learning Module Attributes', 'bulearningblocks' ),
		'search_items'       => __( 'Search Learning Modules', 'bulearningblocks' ),
		'not_found'          => __( 'No Learning Modules found', 'bulearningblocks' ),
		'not_found_in_trash' => __( 'No Learning Modules found in Trash', 'bulearningblocks' ),
		'archives'           => __( 'Learning Module Archives', 'bulearningblocks' ),
		'parent_item_colon'  => __( 'Learning Module:', 'bulearningblocks' ),
	);

	// Set various pieces of information about the post type.
	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Holds our Learning Modules', 'bulearningblocks' ),
		'public'             => true,
		'publicly_queryable' => true,
		'query_var'          => true,
		'supports'           => array(
			'title',
			'editor',
			'author',
			'thumbnail',
			'excerpt',
			'revisions',
			'page-attributes',
		),
		'taxonomies'         => array(
			'category',
			'post_tag',
		),
		'hierarchical'       => true,
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'modules' ),
		'show_in_admin_bar'  => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true,
		'can_export'         => true,
		'menu_icon'          => 'dashicons-welcome-learn-more',
	);

	register_post_type( 'bulb_learning_module', $args );
}
add_action( 'init', 'bulb_register_learning_module_post_type' );
