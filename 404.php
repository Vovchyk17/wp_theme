<?php
get_header();

tpl_style( 'page' );
?>

<?php get_template_part( 'tpl-parts/top-panels/top-panel', 'default', array( 'title' => 'Error 404' ) ); ?>

<div class="page_404 default_page container">
    <div class="content last_no_spacing">
        <p><?php echo esc_html("Sorry, this page doesn't exist or has been removed."); ?></p>
        <a href="<?php echo esc_url( site_url() ); ?>" class="button"><?php echo esc_html("Go back home"); ?></a>
    </div>
</div>

<?php get_footer(); ?>
