<?php
if ( !empty( $args ) ) $part_args = $args;

$post_type = $part_args['post_type'];

$date_posts = new WP_Query( array(
	'posts_per_page' => - 1,
	'post_type'      => $post_type,
	'post_status'    => 'publish',
) );

$filter_options = array();

while ( $date_posts->have_posts() ) : $date_posts->the_post();
	$full_date = get_the_time( 'Y-m-d', $post->ID );
	$year_Y    = date( 'Y', strtotime( $full_date ) );

	$filter_options[ $year_Y ] = $year_Y;
endwhile; ?>
<div class="posts__filters_item">
    <label for="date_dropdown" hidden><?php echo esc_html('Filter by date'); ?></label>
	<select id="date_dropdown" class="date_filter_dropdown" data-post-type="<?php echo esc_attr($post_type); ?>" aria-label="Filter by date">
		<option value="*"><?php echo esc_html( 'Date' ); ?></option>
		<?php $filter_options = array_unique( $filter_options );
		foreach ( $filter_options as $key => $option ) : ?>
			<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $option ); ?></option>
		<?php endforeach; ?>
	</select>
</div>