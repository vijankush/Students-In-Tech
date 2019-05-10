<?php
$nct_theme_options = ngo_charity_lite_theme_options();
$page = $nct_theme_options['causes_title'];
$args = array($nct_theme_options['cause1'], $nct_theme_options['cause2'], $nct_theme_options['cause3']);
$section_info = '';
if ($page)
    $section_info = get_post($page);

$query = new WP_Query(array('post_type' => 'page', 'post__in' => $args, 'post__not_in' => array(0)));
if ($query->have_posts()) {
    ?>

    <div class="cause-section section">
        <div class="container">
            <?php if ($section_info) { ?>
                <div class="section-title">
                    <?php echo (esc_html($page)) ? '<h2>' . esc_html($section_info->post_title) . '</h2>' : ''; ?>
                    <?php echo (esc_html($page)) ? '<p>' . wp_kses_post(ngo_charity_lite_get_excerpt($section_info->ID, 70)) . '</p>' : ''; ?>
                </div>
            <?php } ?>
            <div class="row">

                <?php
                while ($query->have_posts()) : $query->the_post();
                    global $post;
                    $post_format = get_post_format($post->ID);
                    $blog_post_author = get_avatar(get_the_author_meta('ID'), 32);
                    $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
                    $image = wp_get_attachment_image_src($post_thumbnail_id, 'full');
                    $author_name = get_the_author_meta('display_name');
                    $category = get_the_category();
                    $id = get_the_ID();
                    if (!empty($image)) {
                        $image_bg = "style='background-image:url(" . esc_url($image[0]) . ")'";
                    } else {
                        $image_bg = '';
                    }
                    ?>
                    <div class="col-md-4">
                        <div class="single-cause-wrap">
                            <div class="cause-img" <?php echo wp_kses_post($image_bg); ?>>
                            </div>
                            <div class="cause-details">
                                <h3 class="post-title"><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a></h3>
                                <?php
                                if (get_the_excerpt() && trim(get_the_excerpt()) != "") {
                                    echo '<p class="post-description">'.esc_html(get_the_excerpt()).'</p>';
                                } else {
                                    ?>
                                    <p class="post-description"><?php echo wp_kses_post(ngo_charity_lite_get_excerpt(get_the_ID(), 125)); ?></p>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
    <?php
}