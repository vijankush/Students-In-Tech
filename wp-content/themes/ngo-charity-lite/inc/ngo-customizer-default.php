<?php
if (!function_exists('ngo_charity_lite_theme_options')) :
    function ngo_charity_lite_theme_options()
    {
        $defaults = array(

            //banner section
            'banner1' => '',
            'banner2' => '',
            'causes_title' => '',
            'cause1' => '',
            'cause2' => '',
            'cause3' => '',
            'about' => '',
            'add_info' => '',
            'email' => '',
            'phone' => '',
            'cta' => '',
            'ins' => '',
            'yt' => '',
            'gp' => '',
            'fb' => '',
            'tw' => '',
            'blog' => '',
        );

        $options = get_option('ngo_charity_lite_theme_options', $defaults);

        //Parse defaults again - see comments
        $options = wp_parse_args($options, $defaults);

        return $options;
    }
endif;