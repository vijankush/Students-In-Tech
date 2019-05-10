<?php
$nct_theme_options = ngo_charity_lite_theme_options();
$about = array($nct_theme_options['add_info']);
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
        if (!empty($image_attributes[0])) {
            $image_style = "style='background-image:url(" . esc_url($image_attributes[0]) . ")'";
        } else {
            $image_style = '';
        }
        ?>
        <div class="testimonial-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="page-img" <?php echo wp_kses_post($image_style); ?>>

                    </div>
                    <div class="page-content-wrap">
                        <h2><?php echo esc_html(get_the_title()); ?></h2>
                        <?php
                        if (get_the_excerpt() && trim(get_the_excerpt()) != "" ) {
                            the_excerpt();
                        } else {
                            ?>
                            <p><?php echo wp_kses_post(ngo_charity_lite_get_excerpt(get_the_ID(), 350)); ?></p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    wp_reset_postdata();
}
