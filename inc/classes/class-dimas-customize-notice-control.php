<?php
/**
 * Customize API: Customize_Notice_Control class
 *
 * @package WordPress
 * @subpackage Dimas
 * @since Dimas 1.0
 */

namespace Dimas;

use WP_Customize_Control;

/**
 * Customize Notice Control class.
 *
 * @since Dimas 1.0
 *
 * @see WP_Customize_Control
 */
class Customize_Notice_Control extends WP_Customize_Control {
	/**
	 * The control type.
	 *
	 * @since Dimas 1.0
	 *
	 * @var string
	 */
	public $type = 'dimas-notice';

	/**
	 * Renders the control content.
	 *
	 * This simply prints the notice we need.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	public function render_content() {
		?>
		<div class="notice notice-warning">
			<p><?php esc_html_e( 'To access the Dark Mode settings, select a light background color.', 'dimas' ); ?></p>
			<p><a href="<?php echo esc_url( __( 'https://wordpress.org/support/article/dimas/#dark-mode-support', 'dimas' ) ); ?>">
				<?php esc_html_e( 'Learn more about Dark Mode.', 'dimas' ); ?>
			</a></p>
		</div>
		<?php
	}
}
