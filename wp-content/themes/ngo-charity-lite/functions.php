<?php
/**
 * NGO Charity Fund functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ngo_charity_lite
 */

if ( ! function_exists( 'ngo_charity_lite_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ngo_charity_lite_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on NGO Charity Fund, use a find and replace
		 * to change 'ngo-charity-lite' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ngo-charity-lite', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'ngo-charity-lite' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ngo_charity_lite_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

        add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));

        /**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'ngo_charity_lite_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ngo_charity_lite_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ngo_charity_lite_content_width', 640 );
}
add_action( 'after_setup_theme', 'ngo_charity_lite_content_width', 0 );
add_action( 'init', 'ngo_charity_lite_post_type_support', 0 );

function ngo_charity_lite_post_type_support(){
    add_post_type_support( 'page', 'excerpt' );
}
if (!function_exists('ngo_charity_lite_fonts_url')) :
    function ngo_charity_lite_fonts_url()
    {
        $fonts_url = '';
        $fonts = array();


        if ('off' !== _x('on', 'Montserrat font: on or off', 'ngo-charity-lite')) {
            $fonts[] = 'Montserrat:300';
        }

        if ('off' !== _x('on', 'Raleway font: on or off', 'ngo-charity-lite')) {
            $fonts[] = 'Raleway:400,500';
        }

        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urlencode(implode('|', $fonts)),
            ), '//fonts.googleapis.com/css');
        }

        return $fonts_url;
    }
endif;
define( 'NGO_CHARITY_LITE_VERSION', '1.4.0' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ngo_charity_lite_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ngo-charity-lite' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ngo-charity-lite' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name' => esc_html__('Footer Widget', 'ngo-charity-lite') . $i,
            'id' => 'ngo_charity_footer_' . $i,
            'description' => esc_html__('Shows widgets at Footer Widget ', 'ngo-charity-lite') . $i,
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));
    }

}
add_action( 'widgets_init', 'ngo_charity_lite_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ngo_charity_lite_scripts() {
	wp_enqueue_style( 'ngo-charity-lite-style', get_stylesheet_uri() );
    wp_enqueue_style( 'ngo-charity-lite-fonts', ngo_charity_lite_fonts_url(), array(), null);
    wp_enqueue_style( 'ngo-charity-custom-style', get_template_directory_uri() . '/assets/css/ngo-charity-lite.css' );

	wp_enqueue_script( 'ngo-charity-lite-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'ngo-charity-lite-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_enqueue_script( 'ngo-charity-lite-easypiechart', get_template_directory_uri() . '/assets/js/easypiechart.js', array('jquery'), '20151215', true );
	wp_enqueue_script( 'ngo-charity-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '20151215', true );
	wp_enqueue_script( 'ngo-charity-slick', get_template_directory_uri() . '/assets/js/slick.min.js', array('jquery'), '20151215', true );
	wp_enqueue_script( 'ngo-charity-main', get_template_directory_uri() . '/assets/js/app.js', array('jquery'), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ngo_charity_lite_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/custom-functions.php';
require get_template_directory() . '/inc/ngo-charity-menu.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

require get_template_directory() . '/inc/class-ngo-charity-discount.php';
/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/ngo-customizer-default.php';

require get_template_directory() . '/information/feature-about-page.php';

require get_template_directory() . '/information/ngo-charity-lite-notifications-utils.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

if (!function_exists('ngo_charity_lite_theme_options')):
    function ngo_charity_lite_theme_options()
    {
        return wp_parse_args(get_option('ngo_charity_lite_theme_options', array()), ngo_charity_lite_theme_options());
    }
endif;

if (!function_exists('ngo_charity_lite_add_editor_styles')) {
    // Add editor styles
    function ngo_charity_lite_add_editor_styles()
    {
        add_editor_style(get_template_directory() . '/inc/customizer/css/admin/editor-styles.min.css');
    }

    add_action('init', 'ngo_charity_lite_add_editor_styles');
}
function ngo_charity_lite_demo_import_files()
{
    return array(
        array(
            'import_file_name'             => 'Demo 1',
            'local_import_file'            => trailingslashit( get_template_directory() )  . 'inc/ngo-charity-lite-demo/import.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() )  . 'inc/ngo-charity-lite-demo/import.wie',
            'local_import_customizer_file' => trailingslashit( get_template_directory() )  . 'inc/ngo-charity-lite-demo/import.dat',
            'import_preview_image_url'     => esc_url( get_template_directory_uri() . '/screenshot.png'),
            'preview_url'                  => esc_url('http://demos.pridethemes.com/ngo-charity-lite/'),
        ),
    );
}

add_filter('pt-ocdi/import_files', 'ngo_charity_lite_demo_import_files');


function ngo_charity_lite_after_import_setup() {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'main-menu' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'ngo_charity_lite_after_import_setup' );
