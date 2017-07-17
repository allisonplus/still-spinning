<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Spin
 */

get_header(); ?>

	<div class="wrap">
		<div class="primary content-area">
			<main id="main" class="site-main" role="main">

				<section class="error-404 not-found">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Uh oh. These aren\'t the droids you\'re looking for.', 'cps' ); ?></h1>
					</header><!-- .page-header -->

					<div class="page-content">

						<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/droids.png" alt="Several Star Wars r2 units">
						<p><?php esc_html_e( 'It seems we can’t find what you’re looking for. Perhaps searching can help.', 'cps' ); ?></p>

						<?php get_search_form(); ?>

					</div><!-- .page-content -->
				</section><!-- .error-404 -->

			</main><!-- #main -->
		</div><!-- .primary -->

	</div><!-- .wrap -->

<?php get_footer(); ?>
