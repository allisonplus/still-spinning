<?php
/**
 * The template for displaying the About Page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Spin
 */

get_header(); ?>

	<div class="wrap">
		<div class="primary content-area">
			<main id="main" class="site-main" role="main">

				<div class="user-photo">
					<?php $image = get_field( 'user-image' ); ?>
					<img class="photo" src="<?php echo esc_url( $image['sizes']['medium_large'] ); ?>">
				</div> <!--/.user-photo-->

				<div class="info">
					<?php
					while ( have_posts() ) : the_post();
						the_content();
					endwhile; ?>
				</div> <!--/.info-->

			</main><!-- #main -->
		</div><!-- .primary -->

	</div><!-- .wrap -->

<?php get_footer(); ?>
