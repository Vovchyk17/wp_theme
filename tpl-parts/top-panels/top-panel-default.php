<?php
if ( !empty( $args ) ) {
	$part_args = $args;
	$container_class = isset($part_args['container_class']) ? ' ' . $part_args['container_class'] : '';
	$title = $part_args['title'] ?? get_the_title(get_the_ID());
} else {
	$container_class = '';
	$title = get_the_title( get_the_ID() );
}
?>

<section class="top_panel top_panel__default">
    <div class="container<?php echo $container_class; ?>">
        <h1><?php echo $title; ?></h1>
    </div>
</section>
