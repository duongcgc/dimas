<?php
/**
 * Kirki Controls Notice Control class.
 *
 * @package Dimas;
 * @version 1.0.0
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 /**
  * Controls Notice class
  */
class Register_Controls extends Kirki_Control_Base {

	/**
	 * The type variable
	 *
	 * @var string
	 */
	public $type = 'notice';

	/**
	 * Render content function
	 *
	 * @return void
	 */
	public function render_content() { ?>
			THE CONTROL CONTENT HERE
				<?php
	}
}
