<?php
// custom js/stylesheet
function tt_add_jscss() {
	if ( ! is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_deregister_script( 'jquery-ui-datepicker' );
	}

	if ( defined( 'WPCF7_VERSION' ) ) {
		wp_deregister_style( 'contact-form-7' );
	}

	if ( defined( 'GOOGLE_MAPS_API_KEY' ) ) {
		wp_enqueue_script( 'googlemaps', '//maps.googleapis.com/maps/api/js?v=3.exp&language=en&key='.GOOGLE_MAPS_API_KEY, false, null, false );
	}

	wp_enqueue_script( 'jquery', get_stylesheet_directory_uri() . '/js/_jquery.js', false, null, array(
		'in_footer' => true,
		'strategy'  => 'defer'
	) );

	// uncomment next line and comment all below it on deploy after webpack build
	/*wp_enqueue_script('main', get_stylesheet_directory_uri(). '/dist/main.min.js', array('jquery'), '1.0', array('in_footer' => true, 'strategy' => 'defer' ));*/
	/*wp_enqueue_script('aos', get_stylesheet_directory_uri(). '/js/libs/aos.js', array('jquery'), null, true);*/
	wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'libs' ), null, array(
		'in_footer' => true,
		'strategy'  => 'defer'
	) );
	wp_enqueue_script( 'libs', get_stylesheet_directory_uri() . '/js/libs/common-libs.js', array( 'jquery' ), null, array(
		'in_footer' => true,
		'strategy'  => 'defer'
	) );

	// uncomment next line and comment all below it on deploy after webpack build
	/*wp_enqueue_style('main', get_stylesheet_directory_uri(). '/dist/main.min.css', null, '1.0' );*/
	/*wp_enqueue_style('aos', get_stylesheet_directory_uri(). '/style/libs/aos.css', null, null );*/
	wp_enqueue_style( 'fonts', get_stylesheet_directory_uri() . '/style/fonts.css', null, null );
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style/style.css', null, null );

	wp_enqueue_style( 'libs', get_stylesheet_directory_uri() . '/style/libs/common-libs.css', null, null );
}

add_action( 'wp_enqueue_scripts', 'tt_add_jscss' );


// enqueue styles individually by template
function tpl_style( $file_names, $sub_path = '', $version = null ) {
	if ( ! is_array( $file_names ) ) :
		$file_names = array( $file_names );
	endif;

	if ( $sub_path !== '' ) :
		$sub_path = $sub_path . '/';
	endif;

	foreach ( $file_names as $file_name ) {
		wp_enqueue_style( $file_name, get_stylesheet_directory_uri() . '/style/templates/' . $sub_path . '' . $file_name . '.css', null, $version );
	}
}

/*Gutenberg Contact form 7 enqueue files*/
function contains_contact_form_7_block( $post_content ) {
	// Check for Contact Form 7 shortcode or Gutenberg block
	return has_shortcode( $post_content, 'contact-form-7' ) || strpos( $post_content, '<!-- wp:wpcf7/contact-form-selector' ) !== false;
}

function enqueue_contact_form_7_styles() {
	if ( is_singular() ) {
		global $post;
		if ( contains_contact_form_7_block( $post->post_content ) ) {
			wp_enqueue_script( 'selectric', get_stylesheet_directory_uri() . '/js/libs/selectric.js', array( 'jquery' ), null, true );
			wp_enqueue_script( 'cf7-scripts', get_stylesheet_directory_uri() . '/js/libs/cf7-scripts.js', null, null, array(
				'in_footer' => true,
				'strategy'  => 'defer'
			)  );
			wp_enqueue_style( 'cf7', get_stylesheet_directory_uri() . '/style/libs/cf7.css', null, null );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'enqueue_contact_form_7_styles' );

/*Custom ACF Block enqueue styles - start*/
function is_block_used( $block_name ) {
	if ( is_admin() ) {
		return true;
	}

	global $post;

	if ( ! isset( $post->post_content ) ) {
		return false;
	}

	// Check for the block name in post content
	return strpos( $post->post_content, $block_name ) !== false;
}

function enqueue_acf_block_styles( $is_editor = false ) {
	// Directory path to the CSS files
	$css_directory = get_stylesheet_directory() . '/tpl-acf-blocks/';
	$css_files     = glob( $css_directory . '*/*.css' ); // Recursively get all CSS files in subdirectories

	if ( ! empty( $css_files ) ) {
		foreach ( $css_files as $file ) {
			$block_json = file_get_contents( dirname( $file ) . '/block.json' );
			$block_data = json_decode( $block_json, true );
			$block_name = $block_data['name'];

			if ( is_block_used( $block_name ) ) {
				$file_url     = str_replace( get_stylesheet_directory(), get_stylesheet_directory_uri(), $file );
				$file_version = null;
				$handle       = 'acf-block-style-' . basename( $file, '.css' );

				// Check if styles are for the editor or the front-end
				if ( $is_editor ) {
					wp_enqueue_style(
						$handle . '-editor',
						$file_url,
						array(), // Dependencies, if any
						$file_version
					);
				} else {
					wp_enqueue_style(
						$handle,
						$file_url,
						array(), // Dependencies, if any
						$file_version
					);
				}
			}
		}
	}
}

// Hook for front-end styles
add_action( 'wp_enqueue_scripts', function() {
	enqueue_acf_block_styles( false );
} );

// Hook for editor styles
add_action( 'enqueue_block_editor_assets', function() {
	enqueue_acf_block_styles( true );
} );
/*Custom ACF Block enqueue styles - end*/

function enqueue_acf_block_scripts() {
	// Directory path to the JS files
	$js_directory = get_stylesheet_directory() . '/tpl-acf-blocks/';
	$js_files     = glob( $js_directory . '*/*.js' ); // Recursively get all JS files in subdirectories

	if ( ! empty( $js_files ) ) {
		foreach ( $js_files as $file ) {
			$block_json = file_get_contents( dirname( $file ) . '/block.json' );
			$block_data = json_decode( $block_json, true );
			$block_name = $block_data['name'];

			if ( is_block_used( $block_name ) ) {
				$file_url     = str_replace( get_stylesheet_directory(), get_stylesheet_directory_uri(), $file );
				$file_version = null;
				$handle       = 'acf-block-script-' . basename( $file, '.js' );

				// Enqueue the script for the front-end
				wp_enqueue_script(
					$handle,
					$file_url,
					array(), // Dependencies, if any
					$file_version,
					true
				);
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'enqueue_acf_block_scripts' );

// Defer no critical CSS files
function defer_non_style_css_files($html, $handle, $href, $media) {
	// Check if the current file is not 'style.css' and if the handle is not 'wp-block-library'
	if (strpos($href, 'style.css') === false && $handle !== 'wp-block-library') {
		// Check if the CSS file is from the theme directory
		if (strpos($href, get_template_directory_uri()) !== false) {
			// Create the new HTML with defer
			$html = <<<EOT
<link rel='preload' as='style' onload="this.onload=null;this.rel='stylesheet'" id='$handle' href='$href' type='text/css' media='all' />
EOT;
		}
	} elseif ($handle === 'wp-block-library') {
		// Create the new HTML with defer specifically for 'wp-block-library'
		$html = <<<EOT
<link rel='preload' as='style' onload="this.onload=null;this.rel='stylesheet'" id='$handle' href='$href' type='text/css' media='all' />
EOT;
	}
	return $html;
}

// Add the filter to modify the output of enqueued styles
add_filter('style_loader_tag', 'defer_non_style_css_files', 10, 4);

