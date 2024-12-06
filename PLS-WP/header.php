<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package swps
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!-- stylesheet for GridJs Table -->
	<link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<div id="page" class="site" <?php echo ! is_customize_preview() ?: 'style="padding: 0 40px;"'; ?>>

		<header id="masthead" class="site-header" role="banner">

			<?php
			if ( is_customize_preview() ) {
				echo '<div id="swps-header-control"></div>';
			}
			?>

			<?php
				$pagetitle = get_the_title();

				if (is_front_page()) {
					get_template_part('template-parts/blocks/headers/homepage');
				}
				else if (is_shop() || (is_product_category()) || is_account_page()) {
					get_template_part('template-parts/blocks/headers/store');
				} 
				else if (is_cart() || is_checkout() || is_checkout_pay_page()) {
					get_template_part('template-parts/blocks/headers/cart_and_checkout');
				} 
				else if (is_product()) {
					get_template_part('template-parts/blocks/headers/product');
				} 
				else if (is_page_template('page-templates/lesson-player.php')) {
					get_template_part('template-parts/blocks/headers/lesson-player');
				}
				//else if (is_page_template('page-templates/student-dashboard.php')) {
				//	get_template_part('template-parts/blocks/headers/student-dashboard');
				// }
				else if (is_singular('acf-course')) {
					get_template_part('template-parts/blocks/headers/course-detail');
				}
			?>
				

			<div class="container container-fluid w-full">
				<div class="row">
					

				</div><!-- .col -->

				<div class="col-xs-12 col-sm-8">

					<nav id="site-navigation" class="main-navigation" role="navigation">
						<?php
						if ( has_nav_menu( 'primary' ) ) :
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'menu_id'        => 'primary-menu',
									'walker'         => new swps\Core\WalkerNav(),
								)
							);
						endif;
						?>
					</nav>

				</div><!-- .col -->

			</div><!-- .row -->
		</div><!-- .container-fluid -->

	</header><!-- #masthead -->

	<div id="content" class="site-content">
