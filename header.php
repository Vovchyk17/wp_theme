<?php ( function_exists( 'pll_current_language' ) ) ? $lang = pll_current_language() : $lang = 'en'; ?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
	<meta charset="UTF-8">
	<title><?php wpa_title(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0"/>
    <meta name="mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<meta name="theme-color" content="#1c2c39">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="preload" as="style"
	      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,500&display=swap"/>
	<link rel="stylesheet"
	      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,500&display=swap"
	      media="print" onload="this.media='all'"/>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> data-a="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
<a href="#main" class="button skip_to_content"><?php echo esc_html('Skip to content'); ?></a>

<header>
	<div class="header__container container flex">
		<?php echo ( is_front_page() ) ? '<figure class="header__logo">' : '<a href="' . esc_url( get_site_url() ) . '" class="header__logo">'; ?>
		<img src="<?php echo esc_url( theme( 'images/logo.svg' ) ); ?>" height="60" width="60"
		     alt="<?php bloginfo(); ?>">
		<?php echo ( is_front_page() ) ? '</figure>' : '</a>'; ?>

		<a class="search_toggle i_search" data-fancybox data-src="#search_field" href="javascript:;"
		   aria-label="Search"></a>

		<a class="menu__toggle" href="javascript:;" aria-label="Menu toggle">
			<span></span>
			<span></span>
			<span></span>
		</a>

		<nav class="menu__primary">
			<?php wp_nav_menu(
				array(
					'container'      => false,
					'items_wrap'     => '<ul class="menu__primary_list flex__rwd">%3$s</ul>',
					'theme_location' => 'main_menu'
				)
			); ?>
		</nav>
	</div>
</header>

<main id="main">

	<div id="search_field">
		<div class="container"><?php get_search_form(); ?></div>
	</div>
