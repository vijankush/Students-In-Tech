<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ngo_charity_lite
 */

?>
<footer>
    <div class="widget-area footer-widgets">
        <div class="container">
            <div class="row">
                <?php if (is_active_sidebar('ngo_charity_footer_1')) : ?>
                    <div class="col-md-3 col-sm-6">
                        <?php dynamic_sidebar('ngo_charity_footer_1') ?>
                    </div>
                    <?php
                else: ngo_charity_blank_widget();
                endif; ?>
                <?php if (is_active_sidebar('ngo_charity_footer_2')) : ?>
                    <div class="col-md-3 col-sm-6">
                        <?php dynamic_sidebar('ngo_charity_footer_2') ?>
                    </div>
                    <?php
                else: ngo_charity_blank_widget();
                endif; ?>
                <?php if (is_active_sidebar('ngo_charity_footer_3')) : ?>
                    <div class="col-md-3 col-sm-6">
                        <?php dynamic_sidebar('ngo_charity_footer_3') ?>
                    </div>
                    <?php
                else: ngo_charity_blank_widget();
                endif; ?>
                <?php if (is_active_sidebar('ngo_charity_footer_4')) : ?>
                    <div class="col-md-3 col-sm-6">
                        <?php dynamic_sidebar('ngo_charity_footer_4') ?>
                    </div>
                    <?php
                else: ngo_charity_blank_widget();
                endif; ?>
            </div>
        </div>
    </div>


    <div class="botfooter">
        <div class="container">
            <div class="row">

                <div class="col-md-12 text-center">
                    <div class="copyright">
                        <p><?php echo esc_html__('Powered By WordPress', 'ngo-charity-lite');
                            echo esc_html__(' | ', 'ngo-charity-lite') ?>
                            <a target="_blank" rel="nofollow"
                               href="<?php echo esc_url('https://www.pridethemes.com/product/ngo-charity-lite/'); ?>"><?php echo 'Ngo Charity Lite'; ?></a>
                        </p>
                    </div>
                </div>


            </div>
        </div>
    </div>
</footer>
<a href='#' class='scroll-to-top'></a>
<?php wp_footer(); ?>

</body>
</html>
