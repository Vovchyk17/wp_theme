<?php get_header();
$author_id          = get_the_author_meta( 'ID' );
$author_name        = get_the_author_meta( 'display_name', $author_id );
$author_description = get_the_author_meta( 'description' );
?>
    <div class="author__top">
        <div class="container">
            <h1><?php echo esc_html( $author_name ); ?></h1>
        </div>
    </div>

<?php
$posts = new WP_Query ( array(
	'posts_per_page' => - 1,
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'author'         => $author_id,
) );
if ( $posts->have_posts() || function_exists( 'load_posts_ajax' ) ) : ?>
    <div class="author_posts">
        <div class="container is_10">
            <h2><?php echo esc_html( 'Related articles' ); ?></h2>
            <div class="posts__container" data-post-type="post">
	            <?php if ( function_exists( 'load_posts_ajax' ) ) :
		            echo load_posts_ajax( [ 'posts_per_page' => 3, 'next' => 1, 'author' => $author_id ] );
	            else:
		            while ( $posts->have_posts() )  : $posts->the_post();
			            get_template_part( 'tpl-parts/post-items/post', 'item' );
		            endwhile;
	            endif; ?>
            </div>
        </div>
    </div>
<?php endif;
wp_reset_query(); ?>

<?php
$file_name = basename( __FILE__, '.php' );
tpl_style( $file_name );

get_footer();
?>