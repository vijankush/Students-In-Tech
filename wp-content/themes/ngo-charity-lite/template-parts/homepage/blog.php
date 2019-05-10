<?php
$nct_theme_options = ngo_charity_lite_theme_options();
$about = array($nct_theme_options['blog']);
$args = array(
    'post_type' => 'page',
    'post__in' => $about
);
$blog_query = new WP_Query($args);

$args = array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'order' => 'desc',
    'orderby' => 'menu_order date',
);
$featured = new WP_Query($args);
$loop = 0;
?>
<div class="blog-section section">
    <div class="container">
        <div class="row">
            <?php
            if ($blog_query->have_posts()) {
                while ($blog_query->have_posts()) {
                    $blog_query->the_post();
                    ?>
                    <div class="section-title">
                        <h2><?php echo esc_html(get_the_title()); ?></h2>
                        <?php
                        if (get_the_excerpt() && trim(get_the_excerpt()) != "") {
                            the_excerpt();
                        } else {
                            ?>
                            <p><?php echo wp_kses_post(ngo_charity_lite_get_excerpt(get_the_ID(), 90)); ?></p>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            }

            ?>

            <?php
            if ($featured->have_posts()) {
                while ($featured->have_posts()) : $featured->the_post();
                    global $post;
                    $post_format = get_post_format($post->ID);
                    $blog_post_author = get_avatar(get_the_author_meta('ID'), 32);
                    $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
                    $image = wp_get_attachment_image_src($post_thumbnail_id, 'full');
                    $author_name = get_the_author_meta('display_name');
                    $category = get_the_category();
                    $id = get_the_ID();
                    if ($loop <= 2):
                        ?>
                        <div class="col-md-4">
                            <div class="post-wrap">
                                <div class="post-img">
                                    <?php ngo_charity_lite_blog_post_format($post_format, $post->ID); ?>
                                    <a href="<?php echo esc_url(get_the_permalink()); ?>"
                                       class="btn btn-default"><?php echo esc_html__('read more', 'ngo-charity-lite') ?></a>
                                </div>
                                <div class="post-review">
                                    <h3 class="post-title"><a
                                                href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a>
                                    </h3>
                                    <?php
                                    if (get_the_excerpt() && trim(get_the_excerpt()) != "") {
                                        echo '<p class="post-description">'.esc_html(get_the_excerpt()).'</p>';
                                    } else {
                                        ?>
                                        <p class="post-description"><?php echo wp_kses_post(ngo_charity_lite_get_excerpt($id, 125)); ?></p>
                                        <?php
                                    }
                                    ?>
                                    <ul class="post-info">
                                        <li class="post-date"><a
                                                    href="<?php echo esc_url(ngo_charity_lite_archive_link($post)); ?>"><?php echo esc_html(get_the_date('F d, Y')); ?></a>
                                        </li>

                                        <li class="author vcard">
                                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo esc_html(get_the_author()); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php $loop++; endif; endwhile;
                wp_reset_postdata();
            }
            ?>

        </div>
    </div>
</div>
