<?php get_header();
$term             = get_queried_object();
$term_id          = $term->term_id;
$term_name        = $term->name;
$term_description = $term->description;

$posts = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => - 1,
	'post_status'    => 'publish',
	'category__in'   => $term_id,
) );
?>

<section class="category">
    <div class="container">
        <div class="content">
            <h1><?php echo esc_html( $term_name ); ?></h1>
			<?php echo wpautop( $term_description ); ?>
        </div>
    </div>
</section>

<?php ?>

<?php if ( $posts->have_posts() || function_exists( 'load_posts_ajax' ) ) : ?>
    <section class="container">
        <h2><?php echo esc_html( 'Related articles' ); ?></h2>
        <div class="posts__container" data-post-type="post">
			<?php if ( function_exists( 'load_posts_ajax' ) ) :
				echo load_posts_ajax( [ 'posts_per_page' => 3, 'next' => 1, 'tax' => [ 'category' => [ $term_id ] ] ] );
			else:
				while ( $posts->have_posts() )  : $posts->the_post();
					get_template_part( 'tpl-parts/post-items/post', 'item' );
				endwhile;
			endif; ?>
        </div>
    </section>
<?php endif;
wp_reset_query(); ?>

<?php get_footer(); ?>
