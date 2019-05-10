<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Ngo_Charity_Lite_Discount_Customize {

    /**
     * Returns the instance.
     *
     */
    public static function get_instance() {

        static $instance = null;

        if ( is_null( $instance ) ) {
            $instance = new self;
            $instance->setup_actions();
        }

        return $instance;
    }

    /**
     * Constructor method.
     *
     */
    private function __construct() {}

    /**
     * Sets up initial actions.
     *
     */
    private function setup_actions() {

        // Register panels, sections, settings, controls, and partials.
        add_action( 'customize_register', array( $this, 'sections' ) );

        // Register scripts and styles for the controls.
        add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
    }

    /**
     * Sets up the customizer sections.
     *
     */
    public function sections( $manager ) {

        // Load custom sections.
        require get_template_directory(). '/inc/ngo-charity-section-pro-discount.php';

        // Register custom section types.
        $manager->register_section_type( 'Ngo_Charity_lite_Discount_Customize_Section_Pro' );

        // Register sections.
        $manager->add_section(
            new Ngo_Charity_lite_Discount_Customize_Section_Pro(
                $manager,
                'ngo_charity_lite_to_pro_discount',
                array(

                    'pro_text' => wp_kses_post( "Buy Ngo Charity Pro (20% Off)", 'ngo-charity-lite' ),
                    'pro_url'  => esc_url('https://www.pridethemes.com/product/best-non-profit-funding-wordpress-theme/'),
                    'pro_info'  => esc_html__('Why Pro?','ngo-charity-lite'),
                    'pro_info1'  => esc_html__('Modern And clean design','ngo-charity-lite'),
                    'pro_info2'  => esc_html__('Instant Demo Import','ngo-charity-lite'),
                    'pro_info3'  => esc_html__('Premium Support','ngo-charity-lite'),
                    'pro_info4'  => esc_html__('Multi Language Support','ngo-charity-lite'),
                    'pro_info5'  => esc_html__('Buy Premium','ngo-charity-lite'),
                    'pro_info6'  => esc_html__('Buy Premium','ngo-charity-lite'),
                    'priority' => 1,
                )
            )
        );
    }

    /**
     * Loads theme customizer CSS.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function enqueue_control_scripts() {

        wp_enqueue_script( 'ngo-charity-lite-customize-controls', get_template_directory_uri() . '/js/customizer.js', array( 'customize-controls' ) );

        wp_enqueue_style( 'ngo-charity-lite-customize-controls',get_template_directory_uri() . '/assets/css/customizer-control.css' );
    }
}

// Doing this customizer thang!
Ngo_Charity_Lite_Discount_Customize::get_instance();
