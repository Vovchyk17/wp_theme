<?php
$part_args = !empty($args) ? $args : array();
$label = $part_args['label'] ?? '';

$args = array(
	'meta_query' => array(
		array(
			'key'     => 'wp_capabilities',
			'value'   => 'subscriber',
			'compare' => 'NOT LIKE'
		),
	),
	'orderby'             => 'display_name',
	'order'               => 'ASC',
	'fields'              => array( 'ID', 'display_name' ),
	'capability'          => 'edit_posts',
	'has_published_posts' => array( 'post' ),
);

$user_query = new WP_User_Query( $args );

if ( ! empty( $user_query->results ) ) { ?>
    <div class="posts__filters_item">
        <label for="author_dropdown" hidden><?php echo esc_html('Filter by author'); ?></label>
        <select id="author_dropdown" class="author_filter_dropdown" aria-label="<?php echo esc_attr('Filter by author'); ?>">
            <option value="*"><?php echo esc_html( $label ); ?></option>
			<?php foreach ( $user_query->results as $user ) { ?>
                <option value="<?php echo esc_attr( $user->ID ); ?>"><?php echo esc_html( $user->display_name ); ?></option>
			<?php } ?>
        </select>
    </div>
<?php }