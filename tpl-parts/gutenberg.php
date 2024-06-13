<?php
if ( !empty( $args ) ) {
	$part_args = $args;
	$container_class = $part_args['class'];
} else {
	$container_class = '';
}
$container_class = $container_class > 0 ? ' ' . $container_class : '';
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
	if ( get_the_content() ) : ?>
        <div class="gutenberg">
            <div class="container<?php echo $container_class; ?>">
                <div class="content">
					<?php the_content(); ?>
                </div>
            </div>
        </div>
		<?php tpl_style( 'gutenberg', 'tpl-parts' ); ?>
	<?php endif;
endwhile; endif; ?>
