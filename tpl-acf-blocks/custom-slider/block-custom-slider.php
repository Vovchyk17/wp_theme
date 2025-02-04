<?php
wp_enqueue_script( 'swiper', get_stylesheet_directory_uri() . '/js/libs/swiper.js', null, null, array('in_footer' => true, 'strategy' => 'defer' ) );
wp_enqueue_style( 'swiper', get_stylesheet_directory_uri() . '/style/libs/swiper.css', null, null );

// get fields
$custom_slider = get_field( 'custom_slider' );
if ( $custom_slider ) :
	?>
    <div class="block__custom_slider">
        <div class="swiper">
            <div class="swiper-wrapper">
				<?php foreach ( $custom_slider as $image ) : ?>
                    <div class="block__custom_slider_item swiper-slide">
                        <picture>
                            <source media="(max-width: 480px)" srcset="<?php echo wp_get_attachment_image_url( $image['id'], 'mob_slider' ); ?>">
                        	<?php echo wp_get_attachment_image( $image['id'], 'top_default', false, array( 'alt' => get_alt( $image['id'] ), 'class' => 'object_fit' ) ); ?>
                        </picture>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>

        <div class="sw_controls">
            <div class="sw_prev i_chevron_left"></div>
            <div class="sw_pagination"></div>
            <div class="sw_next i_chevron_right"></div>
        </div>
    </div>
<?php endif; ?>