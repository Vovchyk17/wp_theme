<?php

$current_post_id = get_the_ID();
$post_type       = get_post_type( $current_post_id );
$categories      = get_the_category( $current_post_id );

$category_ids = array();
foreach ( $categories as $category ) {
	$category_ids[] = $category->term_id;
}

$args = array(
	'post_type'      => $post_type,
	'posts_per_page' => 3,
	'post__not_in'   => array( $current_post_id ),
	'category__in'   => $category_ids,
	'orderby'        => 'date',
	'order'          => 'DESC',
);

$related_query = new WP_Query( $args );

if ( $related_query->have_posts() ) : ?>
    <div class="single_post__related">
        <div class="container">
            <h2><?php echo esc_html( 'Related articles' ); ?></h2>
            <div class="posts__container">
				<?php while ( $related_query->have_posts() )  : $related_query->the_post();
					get_template_part( 'tpl-parts/post-items/post', 'item' );
				endwhile; ?>
            </div>
        </div>
    </div>
<?php endif;
wp_reset_query(); ?>