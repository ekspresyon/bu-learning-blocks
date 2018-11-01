<?php
/**
 * True/False question block
 *
 * Register dynamic block functions
 *
 * @since   0.0.1
 * @package BU Learning Blocks
 */

// Load helper functions.
require_once BULB_PLUGIN_DIR_PATH . 'src/helpers/get-feedback.php';


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

	// Parse any shortcodes in feedback string.
	foreach ( $attributes['answers'] as &$answer ) {
		$answer['feedback'] = do_shortcode( $answer['feedback'] );
		$answer['answer']   = do_shortcode( $answer['answer'] );
	}

	// Transform gutenberg attributes into the proposed data structure.
	$data = [
		'type'              => 'true-false',
		'header'            => do_shortcode( $attributes['header'] ),
		'body'              => do_shortcode( $attributes['body'] ),
		'answers'           => $attributes['answers'],
		'correctFeedback'   => do_shortcode( $attributes['correctFeedback'] ),
		'incorrectFeedback' => do_shortcode( $attributes['incorrectFeedback'] ),
	];

	// Save the block data as a JS variable.
	// Use the instance id as the variable name.
	wp_localize_script( 'slickquiz-master-js', $id, $data );

	// Print a question block wrapper with the same instance id.
	// The JS code will then be able to connect the question wrapper with its data.
	return '<div id="' . $id . '" class="bulb-question" style="background-color:' . $background_color . ';color:' . $text_color . ';font-size:' . $font_size . 'px;"></div>';
}

/**
 * Register the dynamic block
 *
 * @return void
 */
function bulb_register_question_tf() {
	register_block_type(
		'bulb/question-tf', [
			'attributes'      => [
				'id'                     => [],
				'header'                 => [],
				'body'                   => [],
				'answers'                => [
					'default' => [
						[
							'answer'   => 'True',
							'feedback' => '',
							'correct'  => true,
						],
						[
							'answer'   => 'False',
							'feedback' => '',
							'correct'  => false,
						],
					],
				],
				'correctFeedback'        => [],
				'incorrectFeedback'      => [],
				'textAlignment'          => [
					'default' => 'left',
				],
				'blockAlignment'         => [
					'type'    => 'string',
					'default' => 'wide',
				],
				'backgroundColorControl' => [
					'type' => 'string',
				],
				'textColorControl'       => [
					'type' => 'string',
				],
				'fontSize'               => [
					'type' => 'string',
				],
			],
			'render_callback' => 'bulb_render_block_tf',
		]
	);
}
add_action( 'init', 'bulb_register_question_tf' );
