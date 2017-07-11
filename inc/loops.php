<?php
/**
 * Custom loops.
 *
 * @package Spin
 */

/**
 * Show Recent Posts.
 */
function cps_show_recent_posts() {
?>

<?php $recent_posts = cps_get_recent_posts(); ?>

<section class="recent-post-container">
<?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'loop-single-post' ); ?>>

		<div class="featured-container"><img class ="featured" src="<?php echo esc_attr( cps_get_post_image_uri( 'featured-blog' ) ); ?>" alt="<?php esc_html_e( 'Featured image for ', 'cps' ); ?><?php echo the_title(); ?>"></div><!-- .featured-container -->

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

<?php endwhile;
wp_reset_postdata(); ?>
</section>

	<?php
}

/**
 * Show Related Posts.
 */
function cps_show_related_posts() {
?>

	<?php $related_posts = cps_get_related_posts( get_the_ID() ); ?>

	<?php if ( $related_posts->have_posts() ) : ?>

		<section class="related-posts">
			<header class="related-posts-header">
				<h2 class="related-posts-title"><?php esc_html_e( 'Similar Posts', 'cps' ); ?></h2>
			</header>

			<div class="related-posts-grid">
				<?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'loop-single-post' ); ?>>

					<div class="featured-container"><img class ="featured" src="<?php echo esc_attr( cps_get_post_image_uri( 'featured-blog' ) ); ?>" alt="<?php esc_html_e( 'Featured image for ', 'cps' ); ?><?php echo the_title(); ?>"></div><!-- .featured-container -->

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
				<?php endwhile; ?>
			</div><!--.related-posts-grid-->
		</section><!--.related-posts-->

	<?php endif;
	wp_reset_postdata(); ?>

	<?php
}
