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

// Returns the taxonomy terms for a given post and taxonomy as a comma-separated list of HTML span elements.
function custom_tax($pid, $tax) {
	$tax_terms = get_the_terms($pid, $tax);
	if (empty($tax_terms) || is_wp_error($tax_terms)) {
		return '';
	}
	$terms = array_map(function($term) {
		return '<span class="tax_term">' . esc_html($term->name) . '</span>';
	}, $tax_terms);
	return '<div class="tax_terms">' . implode('<span>,</span> ', $terms) . '</div>';
}

// Get post taxonomy terms as linked HTML elements for a given post and taxonomy.
function custom_tax_linked($pid, $tax) {
	$tax_terms = get_the_terms($pid, $tax);
	if (empty($tax_terms) || is_wp_error($tax_terms)) {
		return '';
	}
	$terms = [];
	foreach ($tax_terms as $term) {
		$term_link = get_term_link($term);
		if (!is_wp_error($term_link)) {
			$terms[] = '<a href="' . esc_url($term_link) . '" class="tax_term">' . esc_html($term->name) . '</a>';
		}
	}
	return '<div class="tax_terms">' . implode('<span>,</span> ', $terms) . '</div>';
}

//get page url by template name
function get_page_url( $template_name ) {
	$page = get_posts( [
		'post_type'   => 'page',
		'post_status' => 'publish',
		'meta_query'  => [
			[
				'key'     => '_wp_page_template',
				'value'   => $template_name . '.php',
				'compare' => '='
			]
		],
		'numberposts' => 1
	] );
	if ( ! empty( $page ) ) {
		return get_permalink( $page[0]->ID );
	}
	return get_bloginfo( 'url' );
}