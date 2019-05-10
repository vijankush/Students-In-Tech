<?php
$nct_theme_options = ngo_charity_lite_theme_options();
$about = array($nct_theme_options['cta']);
$args = array(
    'post_type' => 'page',
    'post__in' => $about
);
$about_query = new WP_Query($args);
if ($about_query->have_posts()) {
    while ($about_query->have_posts()) {
        $about_query->the_post();
        ?>
        <section class="section cta-sec">
            <div class="container">
                <div class="row">
                    <div class="cta-content" data-aos="fade-up">
                        <h2 class="cta-title"><?php echo esc_html(get_the_title()); ?></h2>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
    wp_reset_postdata();
}