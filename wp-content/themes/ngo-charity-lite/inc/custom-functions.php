<?php
if (!function_exists('ngo_charity_lite_get_excerpt')) :
    function ngo_charity_lite_get_excerpt($post_id, $count)
    {
        $content_post = get_post($post_id);
        $excerpt = $content_post->post_content;

        $excerpt = strip_shortcodes($excerpt);
        $excerpt = strip_tags($excerpt);


        $excerpt = preg_replace('/\s\s+/', ' ', $excerpt);
        $excerpt = preg_replace('#\[[^\]]+\]#', ' ', $excerpt);
        $strip = explode(' ', $excerpt);
        foreach ($strip as $key => $single) {
            if (!filter_var($single, FILTER_VALIDATE_URL) === false) {
                unset($strip[$key]);
            }
        }
        $excerpt = implode(' ', $strip);

        $excerpt = substr($excerpt, 0, $count);
        if (strlen($excerpt) >= $count) {
            $excerpt = substr($excerpt, 0, strripos($excerpt, ' '));
            $excerpt = $excerpt . '...';
        }
        return $excerpt;
    }
endif;
if (!function_exists('ngo_charity_lite_blog_post_format')) {
    function ngo_charity_lite_blog_post_format($post_format, $post_id)
    {
        global $post;

        if ($post_format == 'video') {

            $content = trim(get_post_field('post_content', $post->ID));
            $ori_url = explode("\n", esc_html($content));
            $url = $ori_url[0];
            $url_type = explode(" ", $url);
            $url_type = explode("[", $url_type[0]);

            if (isset($url_type[1])) {
                $url_type_shortcode = $url_type[1];
            }
            $new_content = get_shortcode_regex();
            if (isset($url_type[1])) {

            } else {
                if (!is_single())
                    echo wp_kses_post(wp_oembed_get(ngo_charity_lite_the_featured_video($content)));
            }

        } elseif ($post_format == 'gallery') {
            add_filter( 'shortcode_atts_gallery', 'ngo_charity_lite_shortcode_atts_gallery' );
            $image_url = get_post_gallery_images($post_id);
            $post_thumbnail_id = get_post_thumbnail_id($post_id);
            $attachment = get_post($post_thumbnail_id);
            $gallery = get_post_gallery($post, false);
            if (count($gallery) > 0) {
                $image_list = '';
                if (array_key_exists('ids', $gallery)) {
                    $ids = explode(",", $gallery['ids']);
                } else {
                    $ids = $image_url;
                }

                ?>
                <div class="post-gallery">
                    <div class="post-format-gallery">
                        <?php foreach ($ids as $id) {
                            if (array_key_exists('ids', $gallery)) {

                                $link = wp_get_attachment_url($id);
                            } else {
                                $link = $id;
                            }

                            ?>
                            <div class="slider-item" style="background-image: url('<?php echo esc_url($link); ?>');">
                            </div>
                        <?php } ?>
                    </div>

                </div>
            <?php } else {
                if (has_post_thumbnail() && !is_single() && is_page_template('page-templates/template-home.php')) {
                    echo '<div class="featured-image archive-thumb">';
                    echo '<a  href="' . esc_url(get_the_permalink()) . '" class="post-thumbnail">';
                    the_post_thumbnail();
                    echo '<div class="share-mask"><div class="share-wrap"></div></div></a></div>';
                } else {
                    the_post_thumbnail();
                }
            }
        } else {
            if (has_post_thumbnail() && !is_single() && is_page_template('page-templates/template-home.php')) {
                echo '<div class="featured-image archive-thumb">';
                echo '<a  href="' . esc_url(get_the_permalink()) . '" class="post-thumbnail">';

                the_post_thumbnail();
                echo '<div class="share-mask"><div class="share-wrap"></div></div></a></div>';
            } else {
                the_post_thumbnail();
            }
        }
    }
}


if (!function_exists('ngo_charity_lite_the_featured_video')) {
    function ngo_charity_lite_the_featured_video($content)
    {
        $ori_url = explode("\n", $content);
        $url = $ori_url[0];
        $w = get_option('embed_size_w');
        if (is_single() || is_archive() || is_search() || is_home() || is_page_template('page-templates/template-home.php')) {
            $url = str_replace('448', $w, $url);

            return $url;
        }
        if (0 === strpos($url, 'https://') || 0 == strpos($url, 'http://')) {
            echo esc_url(wp_oembed_get($url));
            $content = trim(str_replace($url, '', $content));
        } elseif (preg_match('#^<(script|iframe|embed|object)#i', $url)) {
            $h = get_option('embed_size_h');
            echo esc_url($url);
            if (!empty($h)) {

                if ($w === $h) $h = ceil($w * 0.75);
                $url = preg_replace(
                    array('#height="[0-9]+?"#i', '#height=[0-9]+?#i'),
                    array(sprintf('height="%d"', $h), sprintf('height=%d', $h)),
                    $url
                );
                echo esc_url($url);
            }
            $content = trim(str_replace($url, '', $content));
        }

    }
}


if (!function_exists('ngo_charity_lite_blank_widget')) {

    function ngo_charity_blank_widget()
    {
        echo '<div class="col-md-3">';
        if (is_user_logged_in() && current_user_can('edit_theme_options')) {
            echo '<a href="' . esc_url(admin_url('widgets.php')) . '" target="_blank"><i class="fa fa-plus-circle"></i> ' . esc_html__('Add Footer Widget', 'ngo-charity-lite') . '</a>';
        }
        echo '</div>';
    }
}


if (!function_exists('ngo_charity_lite_shortcode_atts_gallery')) {

    function ngo_charity_lite_shortcode_atts_gallery($out)
    {
        remove_filter(current_filter(), __FUNCTION__);
        $out['size'] = 'full';
        return $out;
    }
}

if (!function_exists('ngo_charity_lite_breadcrumb')) {

    function ngo_charity_lite_breadcrumb()
    {
        $header_image = get_header_image();
        if ((get_post_type() == 'portfolio') && !is_archive()) {
            $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
            $image = wp_get_attachment_image_src($post_thumbnail_id, 'full');
            $header_image = $image[0];
        }
        $addClass = '';

        ?>
        <div class="inner-banner-wrap<?php echo esc_attr($addClass); ?>"
             <?php if ($header_image) { ?>style="background-image:url(<?php echo esc_url($header_image); ?>)"<?php } ?>>
            <div class="container">
                <div class="row">
                    <div class="inner-banner-content">
                        <?php
                        if (is_archive()) {
                            the_archive_title('<h2>', '</h2>');
                        }
                        if (is_search()) {
                            echo('<h2>' . esc_html__('Search Page', 'ngo-charity-lite') . '</h2>');
                        }
                        if (is_single()) {
                            the_title('<h2>', '</h2>');
                        }
                        if (is_page() && !is_page_template('page-templates/template-home.php')) {
                            the_title('<h2>', '</h2>');
                        }
                        ?>
                        <div class="header-breadcrumb">
                            <?php

                            if (is_page_template('page-templates/template-home.php')) {

                            } else {

                                $delimiter = '';
                                if (is_home())
                                    $home = '<h2>' . esc_html__('Blog', 'ngo-charity-lite') . '</h2>'; // text for the 'Home' link
                                else
                                    $home = esc_html__('Home', 'ngo-charity-lite'); // text for the 'Home' link

                                $before = '<li>'; // tag before the current crumb
                                $after = '</li>'; // tag after the current crumb
                                echo '<ul class="breadcrumb">';
                                global $post;
                                $homeLink = home_url();
                                echo '<li><a href="' . esc_url($homeLink) . '">' . wp_kses_post($home) . '</a></li>' . wp_kses_post($delimiter) . ' ';
                                if (is_category()) {
                                    global $wp_query;
                                    $cat_obj = $wp_query->get_queried_object();
                                    $thisCat = $cat_obj->term_id;
                                    $thisCat = get_category($thisCat);
                                    $parentCat = get_category($thisCat->parent);
                                    if ($thisCat->parent != 0)
                                        echo wp_kses_post(get_category_parents(esc_html($parentCat), TRUE, ' ' . wp_kses_post($delimiter) . ' '));
                                    echo wp_kses_post($before) . single_cat_title('', false) . wp_kses_post($after);
                                } elseif (is_day()) {
                                    echo '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a></li> ' . wp_kses_post($delimiter) . ' ';
                                    echo '<li><a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . esc_html(get_the_time('F')) . '</a></li> ' . wp_kses_post($delimiter) . ' ';
                                    echo wp_kses_post($before) . esc_html(get_the_time('d')) . wp_kses_post($after);
                                } elseif (is_month()) {
                                    echo '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a></li> ' . wp_kses_post($delimiter) . ' ';
                                    echo wp_kses_post($before) . esc_html(get_the_time('F')) . wp_kses_post($after);
                                } elseif (is_year()) {
                                    echo wp_kses_post($before) . esc_html(get_the_time('Y')) . wp_kses_post($after);
                                } elseif (is_single() && !is_attachment()) {
                                    if (get_post_type() != 'post') {
                                        $post_type = get_post_type_object(get_post_type());
                                        $slug = $post_type->rewrite;
                                        echo '<li><a href="' . esc_url($homeLink) . '/' . esc_attr($slug['slug']) . '/">' . esc_html($post_type->labels->singular_name) . '</a></li> ' . wp_kses_post($delimiter) . ' ';
                                        echo wp_kses_post($before) . esc_html(get_the_title()) . wp_kses_post($after);
                                    } else {
                                        $cat = get_the_category();
                                        $cat = $cat[0];
                                        echo wp_kses_post($before) . esc_html(get_the_title()) . wp_kses_post($after);
                                    }

                                } elseif (!is_single() && !is_page() && get_post_type() != 'post') {
                                    $post_type = get_post_type_object(get_post_type());
                                    if (!empty($post_type)) {
                                        echo wp_kses_post($before) . esc_html($post_type->labels->singular_name) . wp_kses_post($after);
                                    }
                                } elseif (is_attachment()) {
                                    $parent = get_post($post->post_parent);
                                    $cat = get_the_category($parent->ID);
                                    echo '<li><a href="' . esc_url(get_permalink($parent)) . '">' . esc_html($parent->post_title) . '</a></li> ' . wp_kses_post($delimiter) . ' ';
                                    echo wp_kses_post($before) . esc_html(get_the_title()) . wp_kses_post($after);
                                } elseif (is_page() && !$post->post_parent) {
                                    echo wp_kses_post($before) . esc_html(get_the_title()) . wp_kses_post($after);
                                } elseif (is_page() && $post->post_parent) {
                                    $parent_id = $post->post_parent;
                                    $breadcrumbs = array();
                                    while ($parent_id) {
                                        $page = get_post($parent_id);
                                        $breadcrumbs[] = '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html(get_the_title($page->ID)) . '</a></li>';
                                        $parent_id = $page->post_parent;
                                    }
                                    $breadcrumbs = array_reverse($breadcrumbs);
                                    foreach ($breadcrumbs as $crumb)
                                        echo wp_kses_post($crumb) . ' ' . wp_kses_post($delimiter) . ' ';
                                    echo wp_kses_post($before) . esc_html(get_the_title()) . wp_kses_post($after);
                                } elseif (is_search()) {
                                    echo wp_kses_post($before) . esc_html__("Search results for: ", "ngo-charity-lite") . esc_html(get_search_query()) . '' . wp_kses_post($after);
                                } elseif (is_tag()) {
                                    echo wp_kses_post($before) . esc_html__('Tag', 'ngo-charity-lite') . single_tag_title('', false) . wp_kses_post($after);
                                } elseif (is_author()) {
                                    global $author;
                                    $userdata = get_userdata($author);
                                    echo wp_kses_post($before) . esc_html__("Articles posted by", "ngo-charity-lite") . ' ' . esc_html($userdata->display_name) . wp_kses_post($after);
                                } elseif (is_404()) {
                                    echo wp_kses_post($before) . esc_html__("Error 404", "ngo-charity-lite") . wp_kses_post($after);
                                } elseif (is_page_template('page-templates/template-contact.php')) {
                                    echo wp_kses_post($before) . esc_html(get_the_title()) . wp_kses_post($after);
                                }
                            }
                            echo '</ul>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('ngo_charity_lite_archive_link')) {
    function ngo_charity_lite_archive_link($post)
    {
        $year = date('Y', strtotime($post->post_date));
        $month = date('m', strtotime($post->post_date));
        $day = date('d', strtotime($post->post_date));
        $link = home_url('') . '/' . $year . '/' . $month . '?day=' . $day;
        return $link;
    }
}
function ngo_charity_lite_get_wporg_plugin_description( $slug ) {

    $plugin_transient_name = 'ngo_charity_t_' . $slug;

    $transient = get_transient( $plugin_transient_name );

    if ( ! empty( $transient ) ) {

        return $transient;

    } else {

        $plugin_description = '';

        if ( ! function_exists( 'plugins_api' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
        }

        $call_api = plugins_api(
            'plugin_information', array(
                'slug'   => $slug,
                'fields' => array(
                    'short_description' => true,
                ),
            )
        );

        if ( ! empty( $call_api ) ) {
            if ( ! empty( $call_api->short_description ) ) {
                $plugin_description = strtok( $call_api->short_description, '.' );
            }
        }

        set_transient( $plugin_transient_name, $plugin_description, 10 * DAY_IN_SECONDS );

        return $plugin_description;

    }
}

function ngo_charity_lite_check_passed_time( $no_seconds ) {
    $activation_time = get_option( 'ngo_charity_lite_time_activated' );
    if ( ! empty( $activation_time ) ) {
        $current_time    = time();
        $time_difference = (int) $no_seconds;
        if ( $current_time >= $activation_time + $time_difference ) {
            return true;
        } else {
            return false;
        }
    }

    return true;
}


add_action( 'admin_notices', 'ngo_charity_lite_admin_notice' );
function ngo_charity_lite_admin_notice(){
    global $current_user;
    $user_id   = $current_user->ID;
    $theme_data  = wp_get_theme();
    if ( !get_user_meta( $user_id, esc_html( $theme_data->get( 'TextDomain' ) ) . '_notice_ignore' ) ) {
        ?>
        <div class="notice ngo-charity-lite-notice">
            <h1>
                <?php
                    /* translators: %1$s: theme name, %2$s theme version */
                    printf( esc_html__( 'Thank you for Installing %1$s - Version %2$s', 'ngo-charity-lite' ), esc_html($theme_data->Name), esc_html( $theme_data->Version ) );
                ?>
            </h1>
            <p>
                <?php

                    /* translators: %1$s: theme name, %2$s link */
                    printf( __( 'Visit %1$s options page to take full advantage of theme.', 'ngo-charity-lite' ), esc_html( $theme_data->Name ), esc_url( admin_url( 'themes.php?page=ngo-charity-lite-welcome' ) ) );
                    printf( '<a href="%1$s" class="notice-dismiss dashicons dashicons-dismiss dashicons-dismiss-icon"></a>', '?' . esc_html( $theme_data->get( 'TextDomain' ) ) . '_notice_ignore=0' );
                ?>
            </p>
            <p>
                <a href="<?php echo esc_url( admin_url( 'themes.php?page=ngo-charity-lite-welcome' ) ) ?>" class="button button-primary button-hero" style="text-decoration: none;">
                    <?php
                        /* translators: %s theme name */
                        printf( esc_html__( 'Get started with %s', 'ngo-charity-lite' ), esc_html( $theme_data->Name ) );
                    ?>
                </a>
                <?php
        if (in_array('one-click-demo-import/one-click-demo-import.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            ?>
            <a href="<?php echo esc_url(admin_url('themes.php?page=pt-one-click-demo-import')) ?>"
               class="button button-primary button-hero" style="text-decoration: none;">
                <?php
                /* translators: %s theme name */
                printf(esc_html__('Import Demo with One Click', 'ngo-charity-lite'));
                ?>
            </a>
            <?php
        }
                ?>
            </p>
        </div>
        <?php
    }
}

add_action( 'admin_init', 'ngo_charity_lite_notice_ignore' );
function ngo_charity_lite_notice_ignore(){
    global $current_user;
    $theme_data  = wp_get_theme();
    $user_id   = $current_user->ID;
    /* If user clicks to ignore the notice, add that to their user meta */
    if ( isset( $_GET[ esc_html( $theme_data->get( 'TextDomain' ) ) . '_notice_ignore' ] ) && '0' == $_GET[ esc_html( $theme_data->get( 'TextDomain' ) ) . '_notice_ignore' ] ) {
        add_user_meta( $user_id, esc_html( $theme_data->get( 'TextDomain' ) ) . '_notice_ignore', 'true', true );
    }
}
