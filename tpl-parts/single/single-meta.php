<?php
global $post;
$author_id = $post->post_author;
//get author url
$author_url  = get_author_posts_url( $author_id );
$author_name = get_the_author_meta( 'display_name', $author_id );
?>

<div class="single_post__meta container">
    <div class="single_post__meta__inner">
        <div class="author_name">Author:
            <a href="<?php echo esc_url( $author_url ); ?>"><?php echo $author_name; ?></a>
        </div>

        <time datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'F j, Y' ); ?></time>

		<?php if ( get_the_terms( get_the_ID(), 'category' ) ) : ?>
            <div class="cats">Category: <?php echo wp_kses_post( custom_tax( get_the_ID(), 'category' ) ); ?></div>
            <div class="cats">Category
                linked: <?php echo wp_kses_post( custom_tax_linked( get_the_ID(), 'category', 'category' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_the_terms( get_the_ID(), 'post_tag' ) ) : ?>
            <div class="tags_list">Tags: <?php the_tags( '' ); ?></div>
		<?php endif; ?>

        <ul class="shrs">
			<?php get_template_part( 'tpl-parts/single/share', 'buttons' ); ?>
        </ul>
    </div>
</div>
