<?php
if (!defined('ABSPATH')) {
    exit;
}

class dimas_yith_vendor {
    public function __construct() {
        add_action('after_setup_theme', array($this, 'after_setup_theme'));
    }

    public function after_setup_theme() {
        if (dimas_is_woocommerce_extension_activated('YITH_Woocompare') && get_option('yith_woocompare_compare_button_in_product_page') == 'yes') {
            update_option('yith_woocompare_compare_button_in_product_page', 'no');
        }

        if (dimas_is_woocommerce_extension_activated('YITH_Woocompare') && get_option('yith_woocompare_compare_button_in_products_list') == 'yes') {
            update_option('yith_woocompare_compare_button_in_products_list', 'no');
        }

        if (dimas_is_woocommerce_extension_activated('YITH_WCWL') && get_option('yith_wcwl_button_position') != 'shortcode') {
            update_option('yith_wcwl_button_position', 'shortcode');
        }
    }

}

return new dimas_yith_vendor();