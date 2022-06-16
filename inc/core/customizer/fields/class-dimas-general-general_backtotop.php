<?php

/**
 * Customize Fields
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class General_Backtotop_Fields {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self:: $instance;
	}	

	/**
	 * Section name.
	 *
	 * @var string
	 */
	private static $section = 'general_backtotop';

	/**
	 * Section priority variable
	 *
	 * @var integer
	 */
	private static $section_priority = 10;

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {	

		$priority = self::$section_priority;
		$fields = array(
			'general_backtotop'    => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Back To Top', 'dimas'),
				'section'     => self::$section,
				'priority' => $priority++,
				'description' => esc_html__('Check this to show back to top.', 'dimas'),
				'default'     => true,
			),
		);

		return $fields;
	}

	

}
