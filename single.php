<?php get_header(); ?>

<div class="single_post">
    <section class="single_post__meta top_panel__default">
        <div class="container is_smaller">
            <h1><?php the_title(); ?></h1>

            <div class="author_name">Author:
                <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) )); ?>"><?php the_author(); ?></a>
            </div>

            <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('F j, Y'); ?></time>

            <?php if ( get_the_terms( get_the_ID(), 'category' ) ) : ?>
                <div class="cats">Category: <?php echo wp_kses_post( custom_tax( get_the_ID(), 'category' ) ); ?></div>
            <?php endif; ?>

	        <?php if ( get_the_terms( get_the_ID(), 'post_tag' ) ) : ?>
                <div class="tags_list">Tags: <?php the_tags(''); ?></div>
	        <?php endif; ?>
        </div>
    </section>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <section class="single_post__content">
            <div class="container is_smaller">
                <ul class="shrs is_vertical">
                    <?php get_template_part( 'tpl-parts/share-buttons' ); ?>
                </ul>

                <div class="content">
                    <?php if ( has_post_thumbnail() ) :
	                    $thumb_id = get_post_thumbnail_id( get_the_ID() ); ?>
                        <figure class="wp-block-image">
                            <picture>
                                <source media="(max-width: 480px)" srcset="<?php echo wp_get_attachment_image_url( $thumb_id, 'mob_size' ); ?>">
                            	<?php echo wp_get_attachment_image( $thumb_id, 'top_default', false, array( 'alt' => get_alt( get_the_ID() ), 'class' => 'object_fit' ) ); ?>
                            </picture>
                            <?php if ( get_the_post_thumbnail_caption() ) : ?>
                                <figcaption>
                                    <?php the_post_thumbnail_caption(); ?>
                                </figcaption>
                            <?php endif; ?>
                        </figure>
                    <?php endif; ?>

                    <?php the_content(); ?>
                </div>
            </div>
        </section>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
