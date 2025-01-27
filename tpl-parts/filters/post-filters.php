<?php wp_enqueue_script( 'selectric', get_stylesheet_directory_uri() . '/js/libs/selectric.js', array( 'jquery' ), null, true );

$part_args  = ! empty( $args ) ? $args : array();
$pt         = $part_args['post_type'];
$taxonomies = $part_args['taxonomies'];
$labels     = $part_args['labels'];

echo '<div class="posts__filters">';

get_template_part( 'tpl-parts/filters/search-form-ajax' );

get_template_part( 'tpl-parts/filters/post-filters/filter', 'date', array( 'post_type' => $pt ) );

get_template_part( 'tpl-parts/filters/post-filters/filter', 'author', array( 'label' => 'Author' ) );

if ( ! empty( $taxonomies ) ) {
	foreach ( $taxonomies as $index => $tax ) {
		$label = $labels[ $index ] ?? 'Categories';
		get_template_part( 'tpl-parts/filters/post-filters/filter', 'taxonomy', array(
			'post_type' => $pt,
			'tax'       => $tax,
			'label'     => $label
		) );
	}
}

echo '<div class="posts__filters_item"><a href="javascript:;" class="posts__filters_clear">' . esc_attr( 'Clear filters' ) . '</a></div>';

echo wp_kses( get_loader(), $GLOBALS['allowed_loader'] );

echo '</div>';
?>

