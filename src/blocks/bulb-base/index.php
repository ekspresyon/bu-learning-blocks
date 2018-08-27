<?php
/**
 * Base question block
 *
 * Register dynamic block functions
 *
 * @since   0.0.1
 * @package BU Learning Blocks
 */

/**
 * Render the dynamic block
 *
 * @param object $attributes The block's attributes.
 * @param string $content The block's content.
 * @return string The html markup for the block
 */
function bulb_render_block_base( $attributes, $content ) {
	// Get the question block instance id.
	$id = $attributes['id'];

	// Save the block data as a JS variable.
	// Use the instance id as the variable name.
	wp_localize_script( 'bulb-blocks-front-end-js', $id, $attributes );

	// Print a question block wrapper with the same instance id.
	// The JS code will then be able to connect the question wrapper with its data.
	return '<div id="' . $id . '" class="bulb-question"></div>';
}

/**
 * Register the dynamic block
 *
 * @return void
 */
function bulb_register_base() {
	register_block_type(
		'bulb/base', array(
			'render_callback' => 'bulb_render_block_base',
		)
	);
}
add_action( 'init', 'bulb_register_base' );