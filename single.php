<?php get_header(); ?>

<?php get_template_part( 'tpl-parts/top-panels/top-panel', 'default' ); ?>

<?php get_template_part( 'tpl-parts/single/single', 'meta' ); ?>

<?php get_template_part( 'tpl-parts/single/single', 'thumb' ); ?>

<?php get_template_part( 'tpl-parts/gutenberg', null ); ?>

<?php get_template_part( 'tpl-parts/single/single', 'related' ); ?>


<?php
$file_name = basename( __FILE__, '.php' );
tpl_style( $file_name );

get_footer();
?>
