<?php
/**
 *
 * Customize Fields
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fields class
 */
class Fields {
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
	 *
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * The class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'dimas_customize_fields', array( $this, 'customize_fields' ) );
	}

	/**
	 * Create Fields.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function create_fields() {
		foreach ( self::$dimas_fields_classes as $field_class => $file_class ) {
			require_once $file_class;
			$field_class::instance();
		}
	}

	/**
	 * $dimas_fields
	 *
	 * @var $dimas_fields
	 */
	public static $dimas_fields_classes = array(

		'\Dimas\Core\Customizer\General_Preloader_Fields'  => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-general-preloader.php',

		'\Dimas\Core\Customizer\Colors_Main_Color_Fields'  => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-colors-main-color.php',

		'\Dimas\Core\Customizer\Typography_Heading_Fields' => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-typography-heading.php',
		'\Dimas\Core\Customizer\Typography_Body_Fields'    => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-typography-body.php',

		'\Dimas\Core\Customizer\Animations_Transition_Duration_Fields' => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-animations-transition-duration.php',

		'\Dimas\Core\Customizer\Header_Background_Color_Fields' => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-header-bg-color.php',
		'\Dimas\Core\Customizer\Header_Logo_Fields'        => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-header-logo.php',
		'\Dimas\Core\Customizer\Header_Menus_Fields'       => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-header-menus.php',
		'\Dimas\Core\Customizer\Header_Socials_Fields'      => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-header-socials.php',

		'\Dimas\Core\Customizer\Pages_Title_Fields'        => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-pages-title.php',
		'\Dimas\Core\Customizer\Pages_Comments_Fields'        => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-pages-comments.php',

		'\Dimas\Core\Customizer\Post_Single_Fetured_Img_Fields'        => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-post-single-featured-img.php',
		'\Dimas\Core\Customizer\Post_Single_Date_Fields'        => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-post-single-date.php',
		'\Dimas\Core\Customizer\Post_Single_Title_Fields'        => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-post-single-title.php',
		'\Dimas\Core\Customizer\Post_Single_Social_Share_Fields'        => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-post-single-social-share.php',
		'\Dimas\Core\Customizer\Post_Single_Related_Post_Fields'        => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-post-single-related-post.php',
		'\Dimas\Core\Customizer\Post_Single_Comments_Fields'        => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-post-single-comments.php',

		'\Dimas\Core\Customizer\Post_Archive_Title_Fields'        => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-post-archive-title.php',
		'\Dimas\Core\Customizer\Post_Archive_Style_Fields'        => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-post-archive-style.php',

		'\Dimas\Core\Customizer\Footer_Background_Color_Fields' => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-footer-bg-color.php',
		'\Dimas\Core\Customizer\Footer_Item_Fields' => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-footer-item.php',

		'\Dimas\Core\Customizer\Social_Link_Fields' => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-socials-link.php',
		'\Dimas\Core\Customizer\Info_Fields' => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-info.php',
	);

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function customize_fields() {

		self::instance()->create_fields();

		$fields = array();

		foreach ( self::$dimas_fields_classes as $field_class => $file_class ) {
			$fields_tmp = $field_class::get_fields();
			$fields     = array_merge( $fields, $fields_tmp );
		}

		return $fields;
	}

}
