<?php

if (get_theme_mod('dimas_mobile_handheld_footer_bar_hide') == true) {
    remove_action('wp_footer', array(dimas_WooCommerce::getInstance(), 'mobile_handheld_footer_bar'));
}

add_action('customize_register', 'customize_hide_footer_handheld_mobile');
function customize_hide_footer_handheld_mobile($wp_customize) {
    if (class_exists('Dimas_Customize_Control_Button_Switch')) {
        $wp_customize->add_setting('dimas_mobile_handheld_footer_bar_hide', array(
            'sanitize_callback' => 'dimas_sanitize_button_switch',
        ));
        $wp_customize->add_control(new Dimas_Customize_Control_Button_Switch($wp_customize, 'dimas_mobile_handheld_footer_bar_hide', array(
            'section' => 'dimas_footer',
            'label'   => __('Hide mobile handheld footer bar', 'dimas'),
        )));
    }
}