<?php
/**
 * Register the 'bulb-learning-module' custom post type.
 *
 * @since   0.0.1
 * @package BU Learning Blocks
 */

/**
 * Calls register_taxonomy
 *
 * @since 0.0.6
 */
function register_course_tax() {

	$labels  = array(
		'name'                       => _x( 'Lessons', 'Taxonomy General Name', 'bu-learning-blocks' ),
		'singular_name'              => _x( 'Lesson', 'Taxonomy Singular Name', 'bu-learning-blocks' ),
		'menu_name'                  => __( 'Lessons', 'bu-learning-blocks' ),
		'all_items'                  => __( 'All Lessons', 'bu-learning-blocks' ),
		'view_item'                  => __( 'View Lesson', 'bu-learning-blocks' ),
		'parent_item'                => __( 'Parent Lesson', 'bu-learning-blocks' ),
		'parent_item_colon'          => __( 'Parent Lesson:', 'bu-learning-blocks' ),
		'new_item_name'              => __( 'New Lesson Name', 'bu-learning-blocks' ),
		'add_new_item'               => __( 'Create Lesson', 'bu-learning-blocks' ),
		'edit_item'                  => __( 'Edit Lesson', 'bu-learning-blocks' ),
		'update_item'                => __( 'Update Lesson', 'bu-learning-blocks' ),
		'separate_items_with_commas' => __( 'Separate lessons with commas', 'bu-learning-blocks' ),
		'search_items'               => __( 'Search Lessons', 'bu-learning-blocks' ),
		'add_or_remove_items'        => __( 'Add or remove lessons', 'bu-learning-blocks' ),
		'choose_from_most_used'      => __( 'Choose from the most used lessons', 'bu-learning-blocks' ),
		'not_found'                  => __( 'Not Found', 'bu-learning-blocks' ),
	);
	$rewrite = array(
		'slug'       => 'lesson',
		'with_front' => false,
	);
	$args    = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_in_rest'      => true,
		'show_tagcloud'     => true,
		'rewrite'           => $rewrite,
		'has_archive'       => true,
	);
	register_taxonomy( 'bulb-courses', 'bulb-learning-module', $args );
}
add_action( 'init', 'register_course_tax' );

/**
 * Calls register_post_type
 *
 * @since 0.0.1
 */
function bulb_register_learning_module_post_type() {
	// Set various pieces of text, $labels is used inside the $args array.
	$labels  = array(
		'name'               => __( 'Lesson Pages', 'bu-learning-blocks' ),
		'singular_name'      => __( 'Lesson Page', 'bu-learning-blocks' ),
		'menu_name'          => __( 'BULB Lessons', 'bu-learning-blocks' ),
		'add_new'            => __( 'New Lesson Page', 'bu-learning-blocks' ),
		'add_new_item'       => __( 'New Lesson Page', 'bu-learning-blocks' ),
		'edit_item'          => __( 'Edit Lesson Page', 'bu-learning-blocks' ),
		'update_item'        => __( 'Update Lesson Page', 'bu-learning-blocks' ),
		'new_item'           => __( 'New Lesson Page', 'bu-learning-blocks' ),
		'all_items'          => __( 'All Lesson Pages', 'bu-learning-blocks' ),
		'view_item'          => __( 'View Lesson Page', 'bu-learning-blocks' ),
		'view_items'         => __( 'View Lesson Pages', 'bu-learning-blocks' ),
		'attributes'         => __( 'Lesson Page Attributes', 'bu-learning-blocks' ),
		'search_items'       => __( 'Search Lesson Pages', 'bu-learning-blocks' ),
		'not_found'          => __( 'No Lesson Pages found', 'bu-learning-blocks' ),
		'not_found_in_trash' => __( 'No Lessons Pages found in Trash', 'bu-learning-blocks' ),
		'archives'           => __( 'Lesson Page Archives', 'bu-learning-blocks' ),
		'parent_item_colon'  => __( 'Parent Lesson Page:', 'bu-learning-blocks' ),
	);
	$rewrite = array(
		'slug'       => 'lessons',
		'with_front' => false,
	);

	// Set various pieces of information about the post type.
	$args = array(
		'label'               => __( 'lesson', 'bu-learning-blocks' ),
		'labels'              => $labels,
		'description'         => __( 'Holds our Lessons', 'bu-learning-blocks' ),
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
		'taxonomies'          => array( 'bulb-courses' ),
		'hierarchical'        => true,
		'has_archive'         => true,
		'rewrite'             => $rewrite,
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
 * Enqueue the custom Taxonomy's archive template.
 *
 * @param string $template Template file to be filtered.
 *
 * @return string $template Filtered template.
 *
 * @since 0.0.5
 */
function bulb_archive_template( $template ) {

	/* Checks for single template by post type */
	if ( is_tax( 'bulb-courses' ) ) {
		if ( file_exists( BULB_PLUGIN_DIR_PATH . 'src/taxonomy-bulb-courses.php' ) ) {
			return BULB_PLUGIN_DIR_PATH . 'src/taxonomy-bulb-courses.php';
		}
	}

	return $template;

}
/* Filter the single_template with our custom function*/
add_filter( 'template_include', 'bulb_archive_template' );

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

/**
 * Load script to customize the taxonomy menu in the lesson page editor.
 *
 * @since 0.0.7
 */
function bulb_add_admin_scripts() {
	wp_enqueue_script(
		'customize_tax_panel',
		BULB_PLUGIN_URL . 'src/customize_tax_panel.js',
		array(),
		filemtime( plugin_dir_path( __DIR__ ) . 'src/customize_tax_panel.js' ), // Gets file modification time for cache busting.
		true // Enqueue the script in the footer.
	);
}
add_action( 'enqueue_block_editor_assets', 'bulb_add_admin_scripts' );
