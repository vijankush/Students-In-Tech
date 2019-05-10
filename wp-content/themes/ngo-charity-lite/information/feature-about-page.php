<?php
/**
 * Lite Manager
 *
 * @package Ngo_Charity_Lite_
 * @since 1.0.12
 */


/**
 * About page class
 */
require_once get_template_directory() . '/information/ngo-charity-lite-about-page/class-ngo-charity-lite-about-page.php';

/*
* About page instance
*/
$config = array(
	// Menu name under Appearance.
	'menu_name'           => apply_filters( 'ngo_charity_lite_about_page_filter', esc_html__( 'About Ngo Charity Lite', 'ngo-charity-lite' ), 'menu_name' ),
	// Page title.
	'page_name'           => apply_filters( 'ngo_charity_lite_about_page_filter', esc_html__( 'About Ngo Charity Lite', 'ngo-charity-lite' ), 'page_name' ),
	// Main welcome title
	/* translators: s - theme name */
	'welcome_title'       => apply_filters( 'ngo_charity_lite_about_page_filter', sprintf( esc_html__( 'Welcome to %s! - Version ', 'ngo-charity-lite' ), 'Ngo Charity Lite' ), 'welcome_title' ),
	// Main welcome content
	'welcome_content'     => apply_filters( 'ngo_charity_lite_about_page_filter', esc_html__( 'Ngo Charity Lite is a WordPress Theme designed for Non-Profit, Crowdfunding & Fundraising Organizations. This theme make your campaigns and events easy to manage and market with the Denorious. NGO Charity theme is a uniquely powerful WordPress theme that has been specifically and narrowly designed to attend to the needs of charitable organizations, non-profit organization and non-government organizations (NGOs) of any kind, field, interest or industry whatsoever.
', 'ngo-charity-lite' ), 'welcome_content' ),
	/**
	 * Tabs array.
	 *
	 * The key needs to be ONLY consisted from letters and underscores. If we want to define outside the class a function to render the tab,
	 * the will be the name of the function which will be used to render the tab content.
	 */
	'tabs'                => array(
		'getting_started'     => esc_html__( 'Getting Started', 'ngo-charity-lite' ),
		'recommended_actions' => esc_html__( 'Recommended Actions', 'ngo-charity-lite' ),
		'recommended_plugins' => esc_html__( 'Useful Plugins', 'ngo-charity-lite' ),
		'demo_import'         => esc_html__( 'Demo Import', 'ngo-charity-lite' ),
		'support'             => esc_html__( 'Support', 'ngo-charity-lite' ),
		'changelog'           => esc_html__( 'Changelog', 'ngo-charity-lite' ),
	),
	// Support content tab.
	'support_content'     => array(
		'first'  => array(
			'title'        => esc_html__( 'Contact Support', 'ngo-charity-lite' ),
			'icon'         => 'dashicons dashicons-sos',
			'text'         => esc_html__( 'We want to make sure you have the best experience using Ngo_Charity_Lite, and that is why we have gathered all the necessary information here for you. We hope you will enjoy using Ngo_Charity_Lite as much as we enjoy creating great products.', 'ngo-charity-lite' ),
			'button_label' => esc_html__( 'Contact Support', 'ngo-charity-lite' ),
			'button_link'  => esc_url( 'https://www.pridethemes.com/tickets/' ),
			'is_button'    => true,
			'is_new_tab'   => true,
		),
		'second' => array(
			'title'        => esc_html__( 'Documentation', 'ngo-charity-lite' ),
			'icon'         => 'dashicons dashicons-book-alt',
			'text'         => esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use Ngo_Charity_Lite.', 'ngo-charity-lite' ),
			'button_label' => esc_html__( 'Read full documentation', 'ngo-charity-lite' ),
			'button_link'  => esc_url('https://www.pridethemes.com/ngo-charity-lite-documentation/'),
			'is_button'    => false,
			'is_new_tab'   => true,
        ),
		'third'  => array(
			'title'        => esc_html__( 'Changelog', 'ngo-charity-lite' ),
			'icon'         => 'dashicons dashicons-portfolio',
			'text'         => esc_html__( 'Want to get the gist on the latest theme changes? Just consult our changelog below to get a taste of the recent fixes and features implemented.', 'ngo-charity-lite' ),
			'button_label' => esc_html__( 'Changelog', 'ngo-charity-lite' ),
			'button_link'  => esc_url( 'https://www.pridethemes.com/product/ngo-charity-lite/' ),
			'is_button'    => false,
			'is_new_tab'   => false,

        ),
	),
	'demo_import'     => array(
		'first'  => array(
			'title'        => esc_html__( 'Demo', 'ngo-charity-lite' ),
			'image'        => esc_url( get_template_directory_uri() . '/screenshot.png'),
			'text'         => esc_html__( 'We want to make sure you have the best experience using Ngo_Charity_Lite, and that is why we have gathered all the necessary information here for you. We hope you will enjoy using Ngo_Charity_Lite as much as we enjoy creating great products.', 'ngo-charity-lite' ),
			'buy_label' => esc_html__( 'Import Now', 'ngo-charity-lite' ),
			'buy_link'  => esc_url( admin_url( 'themes.php?page=pt-one-click-demo-import' ) ),
            'demo_label' => esc_html__( 'Preview', 'ngo-charity-lite' ),
            'demo_link'  => esc_url('http://demos.pridethemes.com/ngo-charity-lite/'),
			'is_button'    => true,
			'is_new_tab'   => true,
            'is_free_pro'   => 'free',
        ),
    ),
	// Getting started tab
	'getting_started'     => array(
        'home'  => array(
            'title'               => esc_html__( 'Setup Homepage', 'ngo-charity-lite' ),
            'text'                => wp_kses_post('1. Create a Page.<br>2. And in right sidebar select Home Template in Page attributes.<br>3. Goto Settings > Reading > Choose Static page.<br>4. Select page and save.'),
            'button_label'        => esc_html__( 'Go to the Customizer', 'ngo-charity-lite' ),
            'button_link'         => false,
            'is_button'           => false,
            'recommended_actions' => false,
            'is_new_tab'          => true,
        ),
		'first'  => array(
			'title'               => esc_html__( 'Recommended actions', 'ngo-charity-lite' ),
			'text'                => esc_html__( 'We have compiled a list of steps for you to take so we can ensure that the experience you have using one of our products is very easy to follow.', 'ngo-charity-lite' ),
			'button_label'        => esc_html__( 'Recommended actions', 'ngo-charity-lite' ),
			'button_link'         => esc_url( admin_url( 'themes.php?page=ngo_charity_lite-welcome&tab=recommended_actions' ) ),
			'is_button'           => false,
			'recommended_actions' => true,
			'is_new_tab'          => false,
		),
		'second' => array(
			'title'               => esc_html__( 'Read full documentation', 'ngo-charity-lite' ),
			'text'                => esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use Ngo_Charity_Lite.', 'ngo-charity-lite' ),
			'button_label'        => esc_html__( 'Documentation', 'ngo-charity-lite' ),
			'button_link'         => esc_url('https://www.pridethemes.com/ngo-charity-lite-documentation/'),
			'is_button'           => false,
			'recommended_actions' => false,
			'is_new_tab'          => true,
		),
		'third'  => array(
			'title'               => esc_html__( 'Go to the Customizer', 'ngo-charity-lite' ),
			'text'                => esc_html__( 'Using the WordPress Customizer you can easily customize every aspect of the theme.', 'ngo-charity-lite' ),
			'button_label'        => esc_html__( 'Go to the Customizer', 'ngo-charity-lite' ),
			'button_link'         => esc_url( admin_url( 'customize.php' ) ),
			'is_button'           => true,
			'recommended_actions' => false,
			'is_new_tab'          => true,
		),
	),
	// Plugins array.
	'recommended_plugins' => array(
		'already_activated_message' => esc_html__( 'Already activated', 'ngo-charity-lite' ),
		'version_label'             => esc_html__( 'Version: ', 'ngo-charity-lite' ),
		'install_label'             => esc_html__( 'Install and Activate', 'ngo-charity-lite' ),
		'activate_label'            => esc_html__( 'Activate', 'ngo-charity-lite' ),
		'deactivate_label'          => esc_html__( 'Deactivate', 'ngo-charity-lite' ),
		'content'                   => array(
			array(
				'slug' => 'one-click-demo-import',
			),
            array(
                'slug' => 'elementor',
            ),
            array(
                'slug' => 'ng-animated-slider',
            ),
            array(
                'slug' => 'loco-translate',
            ),

		),
	),
	// Required actions array.
	'recommended_actions' => array(
		'install_label'    => esc_html__( 'Install and Activate', 'ngo-charity-lite' ),
		'activate_label'   => esc_html__( 'Activate', 'ngo-charity-lite' ),
		'deactivate_label' => esc_html__( 'Deactivate', 'ngo-charity-lite' ),
		'content'          => array(
            'classic-editor'           => array(
                'title'       => 'Classic Editor',
                'description' => ngo_charity_lite_get_wporg_plugin_description( 'classic-editor' ),
                'check'       => ( defined( 'HL_CLASSIC_EDITOR' ) || ! ngo_charity_lite_check_passed_time( '259200' ) ),
                'plugin_slug' => 'classic-editor',
                'id'          => 'classic-editor',
            ),
            'jetpack'           => array(
                'title'       => 'Jetpack',
                'description' => ngo_charity_lite_get_wporg_plugin_description( 'jetpack' ),
                'check'       => ( defined( 'HL_JETPACK_VERSION' ) || ! ngo_charity_lite_check_passed_time( '259200' ) ),
                'plugin_slug' => 'jetpack',
                'id'          => 'jetpack',
            ),
            'contact-form-7'           => array(
                'title'       => 'Contact Form 7',
                'description' => ngo_charity_lite_get_wporg_plugin_description( 'contact-form-7' ),
                'check'       => ( defined( 'HL_WPCF7_VERSION' ) || ! ngo_charity_lite_check_passed_time( '259200' ) ),
                'plugin_slug' => 'contact-form-7',
                'id'          => 'contact-form-7',
            ),
            'one-click-demo-import'           => array(
                'title'       => 'One Click Demo Import',
                'description' => ngo_charity_lite_get_wporg_plugin_description( 'one-click-demo-import' ),
                'check'       => ( defined( 'HL_ONE_CLICK_DEMO_IMPORT_VERSION' ) || ! ngo_charity_lite_check_passed_time( '259200' ) ),
                'plugin_slug' => 'one-click-demo-import',
                'id'          => 'one-click-demo-import',
            ),
		),
	),
);
Ngo_Charity_Lite_About_Page::init( apply_filters( 'ngo_charity_lite_about_page_array', $config ) );

/*
 * Notifications in customize
 */
require get_template_directory() . '/information/class-ngo-charity-lite-customizer-notify.php';

$config_customizer = array(
	'recommended_plugins'       => array(
		'ngo-charity-lite-companion' => array(
			'recommended' => true,
			/* translators: s - Orbit Fox Companion */
			'description' => sprintf( esc_html__( 'If you want to take full advantage of the options this theme has to offer, please install and activate %s.', 'ngo-charity-lite' ), sprintf( '<strong>%s</strong>', 'Orbit Fox Companion' ) ),
		),
	),
	'recommended_actions'       => array(),
	'recommended_actions_title' => esc_html__( 'Recommended Actions', 'ngo-charity-lite' ),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugins', 'ngo-charity-lite' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'ngo-charity-lite' ),
	'activate_button_label'     => esc_html__( 'Activate', 'ngo-charity-lite' ),
	'deactivate_button_label'   => esc_html__( 'Deactivate', 'ngo-charity-lite' ),
);
Ngo_Charity_Lite_Customizer_Notify::init( apply_filters( 'ngo_charity_lite_customizer_notify_array', $config_customizer ) );
