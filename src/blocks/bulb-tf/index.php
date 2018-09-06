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
function bulb_render_block_tf( $attributes, $content ) {
	// Get the question block instance id.
	$id               = $attributes['id'];
	$background_color = $attributes['backgroundColorControl'];
    $text_color       = $attributes['textColorControl'];
    $font_size        = $attributes['fontSize'];

	// Save the block data as a JS variable.
	// Use the instance id as the variable name.
	wp_localize_script( 'slickquiz-master-js', $id, $attributes );

	// Print a question block wrapper with the same instance id.
	// The JS code will then be able to connect the question wrapper with its data.
	return(
		'<div>
			<div id=' . $id . ' class="bulb-question">
				<div class="quizArea" style="background-color:' . $background_color . ';color:' . $text_color . ';font-size:' . $font_size . 'px;" >
					<div class="quizHeader">
						<a class="button startQuiz" href="#">Test Your knowledge!</a>
					</div>
				</div>
			</div>
		</div>'
	);
}

/**
 * Register the dynamic block
 *
 * @return void
 */
function bulb_register_question_tf() {
	register_block_type(
		'bulb/question-tf', array(
			'render_callback' => 'bulb_render_block_tf',
		)
	);
}
add_action( 'init', 'bulb_register_question_tf' );
