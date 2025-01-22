<?php
// get fields
$custom_gallery = get_field( 'custom_gallery' );
if ( $custom_gallery ) :
?>
    <div class="block__custom_gallery">
	    <?php $g_i = 1; foreach ( $custom_gallery as $image ) : ?>
            <figure class="block__custom_gallery_item">
                <a href="<?php echo esc_url( $image['url'] ); ?>" data-fancybox="custom-gallery" aria-label="Open image <?php echo $g_i++; ?>">
                    <?php echo wp_get_attachment_image( $image['id'], 'full', false, array( 'alt' => get_alt( $image['id'] ) ) ); ?>
                </a>
            </figure>
	    <?php endforeach; ?>
    </div>
<?php endif; ?>