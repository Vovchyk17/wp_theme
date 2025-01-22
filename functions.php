<?php

// run pre-installed plugins
require_once('inc/themer.php');

// register menus
register_nav_menus(array(
    'main_menu' => 'Main menu'
));

// custom images sizes
add_image_size('full', '1920', '', true);
add_image_size('mob_size', '480', '', true);
add_image_size('mob_slider', '480', '320', true);
add_image_size('top_default', '1095', '616', true);
add_image_size('custom_gallery', '525', '395', true);

// get post taxonomy
function custom_tax($pid, $tax) {
	if ( get_the_terms( $pid, $tax ) ) {
		$tax_terms = get_the_terms( $pid, $tax );
		$term_list = '';
		$co = count( $tax_terms );
		$i = 1;
		$term_list .= '<div class="tax_terms">';
		foreach ( $tax_terms as $t ) {
			$tax_term = get_term( $t );
			$term_list .= '<span class="tax_term">' . $tax_term->name . '</span>' . ( $i ++ != $co ? '<span>,</span> ' : '' );
		}
		$term_list .= '</div>';

		return $term_list;
	}
}

// custom templates slugs to use with custom_tax_linked() function
/*const CUSTOM_TEMPLATE_SLUG = '/custom-post-type/';*/

// get post taxonomy as hash with related template slug
function custom_tax_linked($pid, $tax, $template_slug) {
	if ( get_the_terms($pid, $tax) ) {
		$tax_terms = get_the_terms( $pid, $tax );
		$term_list = '';
		$co = count( $tax_terms );
		$i = 1;
		$term_list .= '<div class="tax_terms">';
		foreach ( $tax_terms as $t ) {
			$tax_term = get_term( $t );
			$term_link = get_term_link( $tax_term );
			$term_list .= '<a href="' . $term_link. '" class="tax_term">' . $tax_term->name . '</a>' . ( $i ++ != $co ? '<span>,</span> ' : '' );
		}
		$term_list .= '</div>';

		return $term_list;
	}
}

//get page url by template name
function get_page_url( $template_name ) {
	$pages = get_posts( [
		'post_type'   => 'page',
		'post_status' => 'publish',
		'meta_query'  => [
			[
				'key'     => '_wp_page_template',
				'value'   => $template_name . '.php',
				'compare' => '='
			]
		]
	] );
	if ( ! empty( $pages ) ) {
		foreach ( $pages as $pages__value ) {
			return get_permalink( $pages__value->ID );
		}
	}

	return get_bloginfo( 'url' );
}