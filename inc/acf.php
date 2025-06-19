<?php
/* ACF settings */
function my_acf_json_save_point( $path ) {
    return get_template_directory() . '/inc/acf-json';
}
add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );

function my_acf_json_load_point( $paths ) {
    // Remove the original path (optional).
    unset($paths[0]);

    // Append the new path and return it.
    $paths[] = get_template_directory() . '/inc/acf-json';

    return $paths;
}
add_filter( 'acf/settings/load_json', 'my_acf_json_load_point' );

// add custom tab (group) for common ACF fields
if(function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title'    => 'Theme General Settings',
		'menu_title'    => 'Theme Settings',
		'menu_slug'     => 'theme-general-settings',
		'capability'    => 'edit_posts',
		'redirect'      => false
	));
}

function my_acf_init() {
	// g-map API key
	acf_update_setting('google_api_key', 'AIzaSyAO77hGcvxmsvOn1RSjDFQMI4YUnW89MDo');

	// Gutenberg blocks
	if( function_exists('register_block_type') ) {
		$blocks = glob(get_template_directory() . "/tpl-acf-blocks/*", GLOB_ONLYDIR);
		foreach($blocks as $block) {
			$block_name = basename($block);
			register_block_type(get_template_directory() . "/tpl-acf-blocks/$block_name/block.json");
		}
	}
}
add_action('acf/init', 'my_acf_init');

// add custom styles for custom Gutenberg tpl-acf-blocks in WP dashboard
function load_custom_wp_admin_style() {
	wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/tpl-acf-blocks/block-custom-styles.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );

	wp_enqueue_script('admin-custom', get_template_directory_uri() . '/js/admin-custom.js', array('wp-blocks', 'wp-element', 'wp-hooks'), '', true);
	//We use wp_localize_script to pass data
	wp_localize_script( 'admin-custom', 'passed_data', array( 'templateUrl' => get_stylesheet_directory_uri() ) );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

// ACF repeater styles
function acf_repeater_even() {
	$scheme = get_user_option( 'admin_color' );
	$color = '';
	if($scheme == 'fresh') {
		$color = '#0073aa';
	} else if($scheme == 'light') {
		$color = '#d64e07';
	} else if($scheme == 'blue') {
		$color = '#52accc';
	} else if($scheme == 'coffee') {
		$color = '#59524c';
	} else if($scheme == 'ectoplasm') {
		$color = '#523f6d';
	} else if($scheme == 'midnight') {
		$color = '#e14d43';
	} else if($scheme == 'ocean') {
		$color = '#738e96';
	} else if($scheme == 'sunrise') {
		$color = '#dd823b';
	}
	echo '<style>.acf-repeater > table > tbody > tr:nth-child(even) > td.order {color: #fff !important;background-color: '.esc_html($color).' !important; text-shadow: none}</style>';
}
add_action('admin_footer', 'acf_repeater_even');

// remove ACF menu item from
add_filter('acf/settings/show_admin', 'my_acf_show_admin');
function my_acf_show_admin( $show ) {
	return current_user_can('manage_options');
}