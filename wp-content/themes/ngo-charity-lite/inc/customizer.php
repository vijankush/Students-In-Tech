<?php
/**
 * NGO Charity Fund Theme Customizer
 *
 * @package ngo_charity_lite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ngo_charity_lite_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    $nct_theme_options = ngo_charity_lite_theme_options();
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'ngo_charity_lite_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'ngo_charity_lite_customize_partial_blogdescription',
		) );
	}

    $wp_customize->add_panel(
        'theme_options',
        array(
            'title' => esc_html__('Theme Options', 'ngo-charity-lite'),
            'priority' => 2,
        )
    );

    //banner section
    $wp_customize->add_section(
        'top_header_section',
        array(
            'title' => esc_html__( 'Top Header Sections','ngo-charity-lite' ),
            'panel'=>'theme_options',
            'capability'=>'edit_theme_options',
        )
    );
    $wp_customize->add_setting('ngo_charity_lite_theme_options[email]',
        array(
            'default' => $nct_theme_options['email'],
            'type' => 'option',
            'sanitize_callback' => 'sanitize_email',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[email]',
        array(
            'label' => esc_html__('Email', 'ngo-charity-lite'),
            'section' => 'top_header_section',
            'type' => 'text',
        ));
    $wp_customize->add_setting('ngo_charity_lite_theme_options[phone]',
        array(
            'default' => $nct_theme_options['phone'],
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[phone]',
        array(
            'label' => esc_html__('Phone', 'ngo-charity-lite'),
            'section' => 'top_header_section',
            'type' => 'text',
        ));
    $wp_customize->add_setting('ngo_charity_lite_theme_options[tw]',
        array(
            'default' => $nct_theme_options['tw'],
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[tw]',
        array(
            'label' => esc_html__('Twitter Link', 'ngo-charity-lite'),
            'section' => 'top_header_section',
            'type' => 'text',
        ));
    $wp_customize->add_setting('ngo_charity_lite_theme_options[fb]',
        array(
            'default' => $nct_theme_options['fb'],
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[fb]',
        array(
            'label' => esc_html__('Facebook Link', 'ngo-charity-lite'),
            'section' => 'top_header_section',
            'type' => 'text',
        ));
    $wp_customize->add_setting('ngo_charity_lite_theme_options[gp]',
        array(
            'default' => $nct_theme_options['gp'],
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[gp]',
        array(
            'label' => esc_html__('Google Plus Link', 'ngo-charity-lite'),
            'section' => 'top_header_section',
            'type' => 'text',
        ));
    $wp_customize->add_setting('ngo_charity_lite_theme_options[yt]',
        array(
            'default' => $nct_theme_options['yt'],
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[yt]',
        array(
            'label' => esc_html__('Youtube Link', 'ngo-charity-lite'),
            'section' => 'top_header_section',
            'type' => 'text',
        ));
    $wp_customize->add_setting('ngo_charity_lite_theme_options[ins]',
        array(
            'default' => $nct_theme_options['ins'],
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[ins]',
        array(
            'label' => esc_html__('Instagram Link', 'ngo-charity-lite'),
            'section' => 'top_header_section',
            'type' => 'text',
        ));

    $wp_customize->add_section(
        'nct_banner_section',
        array(
            'title' => esc_html__( 'Banner Sections','ngo-charity-lite' ),
            'panel'=>'theme_options',
            'capability'=>'edit_theme_options',
        )
    );
    $wp_customize->add_setting('ngo_charity_lite_theme_options[banner1]',
        array(
            'default' => $nct_theme_options['banner1'],
            'type' => 'option',
            'sanitize_callback' => 'absint',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[banner1]',
        array(
            'label' => esc_html__('Select Page 1 Banner', 'ngo-charity-lite'),
            'section' => 'nct_banner_section',
            'type' => 'dropdown-pages',
        ));
    $wp_customize->add_setting('ngo_charity_lite_theme_options[banner2]',
        array(
            'default' => $nct_theme_options['banner1'],
            'type' => 'option',
            'sanitize_callback' => 'absint',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[banner2]',
        array(
            'label' => esc_html__('Select Page 2 Banner', 'ngo-charity-lite'),
            'section' => 'nct_banner_section',
            'type' => 'dropdown-pages',
        ));

    $wp_customize->add_section(
        'nct_info_section',
        array(
            'title' => esc_html__( 'Info/About Sections','ngo-charity-lite' ),
            'panel'=>'theme_options',
            'capability'=>'edit_theme_options',
        )
    );
    $wp_customize->add_setting('ngo_charity_lite_theme_options[about]',
        array(
            'default' => $nct_theme_options['about'],
            'type' => 'option',
            'sanitize_callback' => 'absint',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[about]',
        array(
            'label' => esc_html__('Choose Page', 'ngo-charity-lite'),
            'section' => 'nct_info_section',
            'type' => 'dropdown-pages',
        ));

    $wp_customize->add_section(
        'nct_cta_section',
        array(
            'title' => esc_html__( 'CTA Sections','ngo-charity-lite' ),
            'panel'=>'theme_options',
            'capability'=>'edit_theme_options',
        )
    );
    $wp_customize->add_setting('ngo_charity_lite_theme_options[cta]',
        array(
            'default' => $nct_theme_options['cta'],
            'type' => 'option',
            'sanitize_callback' => 'absint',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[cta]',
        array(
            'label' => esc_html__('Choose Page', 'ngo-charity-lite'),
            'section' => 'nct_cta_section',
            'type' => 'dropdown-pages',
        ));

    $wp_customize->add_section(
        'nct_causes_section',
        array(
            'title' => esc_html__( 'Projects Section','ngo-charity-lite' ),
            'panel'=>'theme_options',
            'capability'=>'edit_theme_options',
        )
    );
    $wp_customize->add_setting('ngo_charity_lite_theme_options[causes_title]',
        array(
            'default' => $nct_theme_options['causes_title'],
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[causes_title]',
        array(
            'label' => esc_html__('Select Page For Title And Description', 'ngo-charity-lite'),
            'section' => 'nct_causes_section',
            'type' => 'dropdown-pages',
        ));
    $wp_customize->add_setting('ngo_charity_lite_theme_options[cause1]',
        array(
            'default' => $nct_theme_options['cause1'],
            'type' => 'option',
            'sanitize_callback' => 'absint',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[cause1]',
        array(
            'label' => esc_html__('Choose Cause 1', 'ngo-charity-lite'),
            'section' => 'nct_causes_section',
            'type' => 'dropdown-pages',
        ));
    $wp_customize->add_setting('ngo_charity_lite_theme_options[cause2]',
        array(
            'default' => $nct_theme_options['cause2'],
            'type' => 'option',
            'sanitize_callback' => 'absint',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[cause2]',
        array(
            'label' => esc_html__('Choose Cause 2', 'ngo-charity-lite'),
            'section' => 'nct_causes_section',
            'type' => 'dropdown-pages',
        ));
    $wp_customize->add_setting('ngo_charity_lite_theme_options[cause3]',
        array(
            'default' => $nct_theme_options['cause3'],
            'type' => 'option',
            'sanitize_callback' => 'absint',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[cause3]',
        array(
            'label' => esc_html__('Choose Cause 3', 'ngo-charity-lite'),
            'section' => 'nct_causes_section',
            'type' => 'dropdown-pages',
        ));

    $wp_customize->add_section(
        'nct_add_info_section',
        array(
            'title' => esc_html__( 'Additional Info Section','ngo-charity-lite' ),
            'panel'=>'theme_options',
            'capability'=>'edit_theme_options',
        )
    );
    $wp_customize->add_setting('ngo_charity_lite_theme_options[add_info]',
        array(
            'default' => $nct_theme_options['add_info'],
            'type' => 'option',
            'sanitize_callback' => 'absint',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[add_info]',
        array(
            'label' => esc_html__('Choose Page', 'ngo-charity-lite'),
            'section' => 'nct_add_info_section',
            'type' => 'dropdown-pages',
        ));
    $wp_customize->add_section(
        'nct_blog_section',
        array(
            'title' => esc_html__( 'Blog Section','ngo-charity-lite' ),
            'panel'=>'theme_options',
            'capability'=>'edit_theme_options',
        )
    );
    $wp_customize->add_setting('ngo_charity_lite_theme_options[blog]',
        array(
            'default' => $nct_theme_options['blog'],
            'type' => 'option',
            'sanitize_callback' => 'absint',
        ));
    $wp_customize->add_control('ngo_charity_lite_theme_options[blog]',
        array(
            'label' => esc_html__('Select Page For Title And Description', 'ngo-charity-lite'),
            'section' => 'nct_blog_section',
            'type' => 'dropdown-pages',
        ));
}
add_action( 'customize_register', 'ngo_charity_lite_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function ngo_charity_lite_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function ngo_charity_lite_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ngo_charity_lite_customize_preview_js() {
	wp_enqueue_script( 'ngo-charity-lite-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'ngo_charity_lite_customize_preview_js' );
