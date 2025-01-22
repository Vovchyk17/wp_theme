<?php
// get fields
$accordion = get_field( 'accordion' );
if ( $accordion ) :
?>
    <div class="block__accordion" aria-label="Accordion">
        <?php foreach ( $accordion as $row ) : ?>
            <div class="block__accordion_row">
                <div class="block__accordion_title acc_title h3" tabindex="0" aria-expanded="false" aria-label="<?php echo esc_html( $row['title'] ); ?>" role="button">
                    <?php echo esc_html( $row['title'] ); ?>
                    <span class="block__accordion_title__icon i_chevron_down"></span>
                </div>

                <div class="block__accordion_content last_no_spacing" aria-hidden="true" role="region">
                    <?php echo wp_kses_post( $row['content'] ); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>