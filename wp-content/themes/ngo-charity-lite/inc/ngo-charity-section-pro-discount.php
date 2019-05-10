<?php
class Ngo_Charity_lite_Discount_Customize_Section_Pro extends WP_Customize_Section {

    /**
     * The type of customize section being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $type = 'ngo_charity_to_pro_discount';

    /**
     * Custom button text to output.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $pro_text = '';

    /**
     * Custom pro button URL.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $pro_url = '';

    /**
     * Add custom parameters to pass to the JS via JSON.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */

    public $pro_info = '';
    public $pro_info1 = '';
    public $pro_info2 = '';
    public $pro_info3 = '';
    public $pro_info4 = '';
    public $pro_info5 = '';
    public $pro_info6 = '';
    public $pro_info7 = '';

    public function json() {
        $json = parent::json();

        $json['pro_text'] = $this->pro_text;
        $json['pro_url']  = esc_url( $this->pro_url );
        $json['pro_info']  =  $this->pro_info ;
        $json['pro_info1']  =  $this->pro_info1 ;
        $json['pro_info2']  =  $this->pro_info2 ;
        $json['pro_info3']  =  $this->pro_info3 ;
        $json['pro_info4']  =  $this->pro_info4 ;
        $json['pro_info5']  =  $this->pro_info5 ;
        $json['pro_info6']  =  $this->pro_info6 ;
        $json['pro_info7']  =  $this->pro_info7 ;
        return $json;
    }

    /**
     * Outputs the Underscore.js template.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    protected function render_template() { ?>

        <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand upgrade-to-hasten-pro">

            <h3 class="accordion-section-title">

                <# if ( data.pro_text && data.pro_url ) { #>
                    <a class="ngo-charity-lite-support" target="_blank" href="{{ data.pro_url }}">{{ data.pro_text }}</a>
                    <# } #><br>

                        <span><i>{{ data.pro_info }}</i></span><br>
                        <span>{{ data.pro_info1 }}</span><br>
                        <span>{{ data.pro_info2 }}</span><br>
                        <span>{{ data.pro_info3 }}</span><br>
                        <span>{{ data.pro_info4 }}</span><br>
                        <a class="btn btn-default" target="_blank" href="{{ data.pro_url }}">{{ data.pro_info5 }}</a>
                        <p><a href="<?php echo esc_url(admin_url( 'themes.php?page=ngo-charity-lite-welcome' )); ?>" target="_blank">Need help setting homepage?</a></p>
            </h3>
        </li>
    <?php }
}