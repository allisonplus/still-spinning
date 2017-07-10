<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Spin
 */

get_header(); ?>

	<div class="wrap">
		<div class="primary content-area">
			<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) : ?>

				<header class="page-header">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<section class="category-post-container">
				<?php
				/* Start the Loop */

				if ( is_category() || is_tag() ) {

					// Get particular category's object info.
					$category = get_category( get_query_var( 'cat' ) );
					$cat_id = $category->cat_ID;
				}

				$archive_posts = cps_get_archive_posts( $cat_id );
				?>

					<?php while ( $archive_posts->have_posts() ) : $archive_posts->the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'archive' );

				endwhile; ?>

				<?php wp_reset_postdata(); ?>
				</section>

				<?php the_posts_navigation();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>


			</main><!-- #main -->
		</div><!-- .primary -->

	</div><!-- .wrap -->

<?php get_footer(); ?>
