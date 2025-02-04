<?php
// ajax posts load
function load_posts_ajax( $filter_data = null ) {
	extract( $_POST );

	$tax_query      = array();
	$date_query     = array();
	$posts_per_page = $filter_data['posts_per_page'] ?: 9;
	$paged          = $filter_data['next'];
	$author         = $filter_data['author'] ?? null;

	if ( isset( $filter_data['tax'] ) ) {
		$tax_query = array( 'relation' => 'AND' );

		foreach ( $filter_data['tax'] as $key => $tax ) :
			$temp_args = [
				'taxonomy' => $key,
				'terms'    => $tax,
				'field'    => 'id',
				'operator' => 'IN'
			];
			array_push( $tax_query, $temp_args );
		endforeach;
	}

	if ( isset( $filter_data['date'] ) ) {
		foreach ( $filter_data['date'] as $date ) :
			$date_arr  = explode( '-', $date );
			$year      = intval( $date_arr[0] );
			$temp_args = [
				'year' => $year,
			];
			array_push( $date_query, $temp_args );
		endforeach;
	}

	/*Uncomment function below if you need to search by post title only. Part 1 */
	/*function title_filter( $where, &$wp_query ) {
		global $wpdb;
		if ( $search_term = $wp_query->get( 's' ) ) {
			$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . $wpdb->esc_like( $search_term ) . '%\'';
		}
		return $where;
	}
	add_filter( 'posts_where', 'title_filter', 10, 2 );*/

	$args = array(
		'posts_per_page' => $posts_per_page,
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'paged'          => $paged,
		'tax_query'      => $tax_query,
		'date_query'     => $date_query,
		's'              => $filter_data['s'] ?? ''
	);

	if ( $author ) {
		$args['author__in'] = $author;
	}

	$posts_query = new WP_Query( $args );

	/*Uncomment function below if you need to search by post title only. Part 2 */
	/*remove_filter( 'posts_where', 'title_filter', 10 );*/

	$num_pages = $posts_query->max_num_pages;

	$filter_data['next'] = ( $num_pages <= $paged ) ? 1 : $paged + 1;

	ob_start();

	if ( $posts_query->have_posts() ) : while ( $posts_query->have_posts() ) : $posts_query->the_post();
		get_template_part( 'tpl-parts/post-items/post', 'item' );
	endwhile;

		if ( $num_pages != $paged ) :
			echo '<div class="load_more_holder">
                      <a class="button load_more__posts" 
                         data-next_page="' . htmlspecialchars( json_encode( $filter_data ), ENT_QUOTES ) . '"
                         aria-label="Load page ' . wp_kses_post( ( $paged + 1 ) ) . '"
                         href="javascript:;">' . esc_html( "Load More" ) . '</a>
                  </div>
                  <div class="loader_holder">' . wp_kses( get_loader(), $GLOBALS['allowed_loader'] ) . '</div>';
		endif;

	else :
		echo '<div><h3 class="custom_coming_soon">' . esc_html( "No results." ) . '</h3></div>';
	endif;

	$html = ob_get_clean();

	if ( wp_doing_ajax() ) :
		wp_send_json( [
			'html'  => $html,
			'paged' => $paged,
		] );
		wp_die();
	else :
		return $html;
	endif;

}

add_action( 'wp_ajax_load_posts_ajax', 'load_posts_ajax' );
add_action( 'wp_ajax_nopriv_load_posts_ajax', 'load_posts_ajax' );