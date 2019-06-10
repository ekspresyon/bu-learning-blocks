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
		'add_new'            => __( 'Add Learning Module Page', 'bulearningblocks' ),
		'add_new_item'       => __( 'Add Learning Module Page', 'bulearningblocks' ),
		'edit_item'          => __( 'Edit Module Page', 'bulearningblocks' ),
		'new_item'           => __( 'New Module Page', 'bulearningblocks' ),
		'all_items'          => __( 'All Learning Modules', 'bulearningblocks' ),
		'view_item'          => __( 'View Module Page', 'bulearningblocks' ),
		'view_items'         => __( 'View Module Pages', 'bulearningblocks' ),
		'attributes'         => __( 'Learning Module Attributes', 'bulearningblocks' ),
		'search_items'       => __( 'Search Module Pages', 'bulearningblocks' ),
		'not_found'          => __( 'No Learning Modules found', 'bulearningblocks' ),
		'not_found_in_trash' => __( 'No Learning Modules found in Trash', 'bulearningblocks' ),
		'archives'           => __( 'Learning Module Archives', 'bulearningblocks' ),
		'parent_item_colon'  => __( 'Learning Module:', 'bulearningblocks' ),
	);

	// Set various pieces of information about the post type.
	$args = array(
		'labels'              => $labels,
		'description'         => __( 'Holds our Learning Modules', 'bulearningblocks' ),
		'public'              => true,
		'publicly_queryable'  => true,
		'query_var'           => true,
		'capability_type'     => 'post',
		'supports'            => array(
			'title',
			'editor',
			'author',
			'revisions',
			'page-attributes',
		),
		'taxonomies'          => array(
			'category',
			'post_tag',
		),
		'hierarchical'        => true,
		'has_archive'         => true,
		'rewrite'             => array( 'slug' => 'modules' ),
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'show_in_rest'        => true,
		'can_export'          => true,
		'menu_icon'           => 'dashicons-welcome-learn-more',
		'menu_position'       => 30,
		'exclude_from_search' => false,
	);

	register_post_type( 'bulb-learning-module', $args );
}
add_action( 'init', 'bulb_register_learning_module_post_type' );

/**
 * Flush rewrite rules for CPT
 *
 * @since 0.0.4
 */
function bulb_flush_rewrites() {
	bulb_register_learning_module_post_type();
	flush_rewrite_rules();
}
register_activation_hook( BULB_PLUGIN_FILE_PATH, 'bulb_flush_rewrites' );


/**
 * Enqueue the custom post type's single- template.
 *
 * @param string $single Template file to be filtered.
 *
 * @return string $single Filtered template.
 *
 * @since 0.0.2
 */
function bulb_cpt_template( $single ) {
	global $post;

	/* Checks for single template by post type */
	if ( 'bulb-learning-module' === $post->post_type ) {
		if ( file_exists( BULB_PLUGIN_DIR_PATH . 'src/single-bulb-learning-module.php' ) ) {
			return BULB_PLUGIN_DIR_PATH . 'src/single-bulb-learning-module.php';
		}
	}

	return $single;

}
/* Filter the single_template with our custom function*/
add_filter( 'single_template', 'bulb_cpt_template' );

/**
 * Load custom archive template.
 *
 * @param string $archive_template Template to be replaced.
 *
 * @return string $archive_template New Template.
 */
function get_custom_post_type_template( $archive_template ) {
	global $post;

	if ( is_post_type_archive( 'bulb-learning-module' ) ) {
		$archive_template = dirname( __FILE__ ) . '/bulb-learning-module-archive.php';
	}
	return $archive_template;
}
add_filter( 'archive_template', 'get_custom_post_type_template' );

/**
 * Disable Classic Editor by template
 *
 */
function bulb_disable_classic_editor() {

	$screen = get_current_screen();
	if( 'bulb-learning-module' !== $screen->id || ! isset( $_GET['post']) )
		return;

	// if( bulb_disable_editor( $_GET['post'] ) ) {
		remove_post_type_support( 'bulb-learning-module', 'editor' );
	// }

}
add_action( 'admin_head', 'bulb_disable_classic_editor' );

/**
 * Load script to kill attributes panel in Document editor panel.
 *
 * @since 0.0.3
 */
function remove_bulb_attributes_panel() {
	wp_enqueue_script(
		'remove-panel-js',
		BULB_PLUGIN_URL . 'src/remove_attributes_panel.js',
		array(),
		filemtime( plugin_dir_path( __DIR__ ) . 'src/remove_attributes_panel.js' ), // Gets file modification time for cache busting.
		true // Enqueue the script in the footer.
	);
}
if ( class_exists( 'BU_Navigation_Plugin' ) ) {
	add_action( 'enqueue_block_editor_assets', 'remove_bulb_attributes_panel' );
}
