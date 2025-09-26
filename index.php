<?php get_header();

$title = is_home() ? get_the_title(BLOG_ID) : get_the_archive_title();
get_template_part('tpl-parts/top-panels/top-panel', 'default', array('title' => $title));

$posts_per_page = 6;

//posts_query
$posts = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'post_status' => 'publish',
));
if ($posts->have_posts()) :?>
    <section class="posts__page">
        <div class="container">
            <?php get_template_part('tpl-parts/filters/post', 'filters', array(
                    'post_type' => 'post',
                    'taxonomies' => ['category', 'topic'],
                    'labels' => ['Category', 'Topic']
            )); ?>

            <div class="posts__container" data-post-type="post"
                 data-posts-per-page="<?php echo esc_attr($posts_per_page); ?>">
                <?php if (function_exists('load_posts_ajax')) :
                    echo load_posts_ajax(['posts_per_page' => $posts_per_page, 'next' => 1]);
                else :
                    while ($posts->have_posts()) : $posts->the_post();
                        get_template_part('tpl-parts/post-items/post', 'item');
                    endwhile;
                endif; ?>
            </div>
        </div>
    </section>
<?php endif; wp_reset_postdata(); ?>

<?php
$file_name = basename(__FILE__, '.php');
tpl_style($file_name);

wp_enqueue_script('ajax', get_stylesheet_directory_uri() . '/js/ajax.js', array('jquery'), null, array(
        'in_footer' => true,
        'strategy' => 'defer'
));

get_footer();
?>
