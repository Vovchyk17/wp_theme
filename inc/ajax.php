<?php

// ajax posts load
function load_posts_ajax( $filter_data = null ) {
	extract( $_POST );

	$tax_query = array();
	$paged       = $filter_data['next'];

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

	$args = array(
		'posts_per_page' => 6,
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'paged'          => $paged,
		'tax_query'      => $tax_query
	);

	$posts_query = new WP_Query( $args );

	$num_pages = $posts_query->max_num_pages;

	if ( $num_pages <= $paged ) {
		$filter_data['next'] = 1;
	} else {
		$filter_data['next'] = $paged + 1;
	}

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
		echo '<div><h3 class="custom_coming_soon">' . esc_html( "Nothing found." ) . '</h3></div>';
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