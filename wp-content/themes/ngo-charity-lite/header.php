<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ngo_charity_lite
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="loader">
    <div class="load-three-bounce">
        <div class="load-child bounce1"></div>
        <div class="load-child bounce2"></div>
        <div class="load-child bounce3"></div>
    </div>
</div>
<?php
$nct_theme_options = ngo_charity_lite_theme_options();
$email = $nct_theme_options['email'];
$phone = $nct_theme_options['phone'];
$twitter = $nct_theme_options['tw'];
$facebook = $nct_theme_options['fb'];
$google = $nct_theme_options['gp'];
$youtube = $nct_theme_options['yt'];
$instagram = $nct_theme_options['ins'];
?>
<header id="top" class="header hero">
    <div class="header-wrap">
        <?php if ($twitter || $facebook || $google || $youtube || $instagram || $email || $phone): ?>

            <div class="top-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <?php if ($twitter || $facebook || $google || $youtube || $instagram): ?>
                                <div class="top-right-area">
                                    <ul class="social-listing">
                                        <?php
                                        if ($twitter)
                                            echo '<li><a href="' . esc_url_raw($twitter) . '" target="_blank" class="social-links fa fa-twitter">' . esc_html__('Twitter', 'ngo-charity-lite') . '</a></li>';
                                        if ($facebook)
                                            echo '<li><a href="' . esc_url_raw($facebook) . '" target="_blank" class="social-links fa fa-facebook-official">' . esc_html__('Facebook', 'ngo-charity-lite') . '</a></li>';
                                        if ($google)
                                            echo '<li><a href="' . esc_url_raw($google) . '" target="_blank" class="social-links fa fa-google-plus">' . esc_html__('Google Plus', 'ngo-charity-lite') . '</a></li>';
                                        if ($youtube)
                                            echo '<li><a href="' . esc_url_raw($youtube) . '" target="_blank" class="social-links fa fa-youtube-play">' . esc_html__('Youtube', 'ngo-charity-lite') . '</a></li>';
                                        if ($instagram)
                                            echo '<li><a href="' . esc_url_raw($instagram) . '" target="_blank" class="social-links fa fa-instagram">' . esc_html__('Instagram', 'ngo-charity-lite') . '</a></li>';
                                        ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if ($email || $phone): ?>

                            <div class="col-md-6">
                                <div class="top-mail"><?php echo esc_html__('Email:', 'ngo-charity-lite'); ?>
                                    <a href="<?php echo esc_url('mailto:' . $email); ?>"><?php echo esc_html(antispambot($email)); ?></a>
                                </div>
                                <div class="top-tel">
                                    <i class="icon-phone">&nbsp;</i>
                                    <a href="<?php echo esc_url('tel:' . preg_replace('/\D+/', '', $phone)); ?>"><?php echo esc_html($phone); ?> </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php endif; ?>
        <!-- Start of Naviation -->
        <div class="nav-wrapper">
            <div class="container">
                <nav id="primary-nav" class="navbar navbar-default">
                    <div class="navbar-header">
                        <div class="header-logo">
                            <?php
                            $description = get_bloginfo('description', 'display');
                            if ((function_exists('the_custom_logo') && has_custom_logo())) {
                                the_custom_logo();
                            } else {
                                ?>
                                <h3 class="site-title"><a class="navbar-brand"
                                                          href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
                                </h3>
                                <p class="site-description"><?php echo esc_html($description) ?></p>
                                <?php
                            }
                            ?>
                        </div>
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target="#navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>


                    <!-- Brand and toggle get grouped for better mobile display -->

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'container' => '',
                            'menu_class' => 'nav navbar-nav navbar-right',
                            'walker' => new ngo_charity_nav_walker(),
                            'fallback_cb' => 'ngo_charity_nav_walker::fallback',
                        ));
                        ?>
                    </div><!-- End navbar-collapse -->

            </div>
            </nav>
        </div>
        <!-- End of Navigation -->
    </div>


    <?php
    if (is_page_template('page-templates/homepage.php')) {

        $slider = array($nct_theme_options['banner1'], $nct_theme_options['banner2']);
        $args = array(
            'post_type' => 'page',
            'post__in' => $slider
        );
        $slider_query = new WP_Query($args);
        if ($slider_query->have_posts()) {
            ?>
            <div class="banner-wrapper">
                <div class="row">
                    <div class="ngo-banner-slider">
                        <?php while ($slider_query->have_posts()) {
                            $slider_query->the_post();
                            $attachment_id = get_post_thumbnail_id(get_the_ID());
                            $image_attributes = wp_get_attachment_image_src($attachment_id, 'full');
                            if (!empty($image_attributes[0])) {
                                $background_style = "style='background-image:url(" . esc_url($image_attributes[0]) . ")'";
                            } else {
                                $background_style = "";
                            }
                            ?>
                            <div class="slider-item slider1" <?php echo wp_kses_post($background_style); ?>>
                                <div class="container">
                                    <div class="banner-text-wrap">
                                        <h2><?php echo esc_html(get_the_title()); ?></h2>
                                        <?php
                                        if (get_the_excerpt() && trim(get_the_excerpt()) != "") {
                                            echo '<span>'.esc_html(get_the_excerpt()).'</span>';
                                        } else {
                                            ?>
                                            <span><?php echo wp_kses_post(ngo_charity_lite_get_excerpt(get_the_ID(), 90)); ?></span>
                                            <?php
                                        }
                                        ?>
                                        <div class="btn-wrap">
                                            <a href="<?php echo esc_url(get_the_permalink()); ?>"
                                               class="btn btn-default"><?php echo esc_html__('Read More', 'ngo-charity-lite'); ?></a>
                                            <a href="<?php echo esc_url(get_the_permalink()); ?>"
                                               class="btn btn-default" style="display: none;"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
            <?php

        }
        wp_reset_postdata();
    }

    if (!is_page_template('page-templates/homepage.php')) {

        ngo_charity_lite_breadcrumb();
    }
    ?>

</header>
