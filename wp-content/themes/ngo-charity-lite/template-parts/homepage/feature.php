<?php
$nct_theme_options = ngo_charity_lite_theme_options();
$about = array($nct_theme_options['about']);
$args = array(
    'post_type' => 'page',
    'post__in' => $about
);
$about_query = new WP_Query($args);
if ($about_query->have_posts()) {
    while ($about_query->have_posts()) {
        $about_query->the_post();
        $attachment_id = get_post_thumbnail_id(get_the_ID());
        $image_attributes = wp_get_attachment_image_src($attachment_id, 'full');
        $image_alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true);
        ?>
        <div class="about-sec section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6" data-aos="fade-up">
                        <?php if(has_post_thumbnail()): ?>
                        <img src="<?php echo esc_url($image_attributes[0]); ?>"
                             alt="<?php echo esc_attr($image_alt) ?>">
            <?php endif; ?>
                    </div>
                    <div class="col-md-6" data-aos="fade-up">
                        <div class="about-wrap">
                            <h2><?php echo esc_html(get_the_title()); ?></h2>
                            <?php
                            if(get_the_excerpt() && trim(get_the_excerpt()) != ""){
                                the_excerpt();
                            }
                            else{
                            ?>
                            <p><?php echo wp_kses_post(ngo_charity_lite_get_excerpt(get_the_ID(), 500)); ?></p>
                            <?php
                            }
                            ?>
                            <a href="<?php echo esc_url(get_the_permalink()) ?>"
                               class="btn btn-default"><?php echo esc_html__('Read More', 'ngo-charity-lite'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    wp_reset_postdata();
}
