<?php
$part_args = !empty($args) ? $args : array();
$tax = $part_args['tax'] ?? '';
$label = $part_args['label'] ?? '';

// term_query
$cat_terms = get_terms(array(
	'taxonomy'   => $tax,
	'hide_empty' => true,
	'orderby'    => 'id'
));

if ( !empty( $cat_terms ) && ! is_wp_error( $cat_terms ) ) : ?>
    <div class="posts__filters_item">
        <ul class="posts__filters_desktop filters__taxonomy mob_hide">
            <li><a href="javascript:;" data-id="*" class="is_filtered" data-tax="<?php echo esc_attr($tax); ?>"><?php echo $label; ?></a></li>
			<?php foreach( $cat_terms as $cat_term ) : ?>
                <li><a href="javascript:;" data-id="<?php echo $cat_term->term_id; ?>" data-tax="<?php echo esc_attr($tax); ?>"><?php echo esc_html( $cat_term->name ); ?></a></li>
			<?php endforeach; ?>
        </ul>

        <div class="posts__filters_mob">
            <label for="select_<?php echo $tax; ?>" hidden="hidden"><?php echo esc_attr($label); ?></label>
            <select id="select_<?php echo $tax; ?>" class="tax_filter_dropdown" data-tax="<?php echo esc_attr($tax); ?>" aria-label="<?php echo esc_attr($label.' dropdown'); ?>">
                <option value="*" data-name="<?php echo $tax; ?>"><?php echo $label; ?></option>
				<?php foreach ( $cat_terms as $cat_term ) : ?>
                    <option value="<?php echo $cat_term->term_id; ?>"
                            data-name="<?php echo $tax; ?>"><?php echo esc_html( $cat_term->name ); ?></option>
				<?php endforeach; ?>
            </select>
        </div>
    </div>
<?php endif; ?>