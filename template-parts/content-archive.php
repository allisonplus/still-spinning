<?php
/**
 * Template part for displaying archive posts loop.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Spin
 */

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'loop-single-post' ); ?>>
		<div class="featured-container"><img class ="featured" src="<?php echo esc_attr( cps_featured_fallback( 'featured-blog' ) ); ?>" alt="<?php esc_html_e( 'Featured image for ', 'cps' ); ?><?php echo the_title(); ?>"></div><!-- .featured-container -->

		<div class="post-info">
			<div class="meta-data">
				<span class="post-category">
					<?php
					$category = get_the_category();

					if ( $category[0] ) {
						echo '<a href="' . get_category_link( $category[0]->term_id ) . '">' . $category[0]->cat_name . '</a>'; // WPCS: XSS ok.
					} ?>
				</span>
				<span class="entry-date"><i class="fa fa-clock-o"></i><?php the_date( 'F jS, Y', '<p>', '</p>' ); ?></span>

			</div> <!--/.meta-data-->
				<h2 class="single-post-title"><a href="<?php the_permalink(); ?>" title="Permalink to: <?php esc_attr( the_title_attribute() ); ?>" rel="bookmark">
					<?php the_title(); ?></a></h2>
		</div> <!--/.post-info-->

	</article><!-- #post-## -->
