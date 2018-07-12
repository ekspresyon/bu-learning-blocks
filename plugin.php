<?php
/**
 * Plugin Name: bu-learning-blocks
 * Plugin URI: http://www.bu.edu
 * Description: bu-learning-blocks — is a collection of tools to enable the easy creation of lessons with embedded self-assessment questions.
 * Author: Danny Crews, Carlos Silva
 * Author URI: http://www.bu.edu/
 * Version: 0.0.1
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';
