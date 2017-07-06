<?php
/**
 * Template Name: Book Quote
 * Template Post Type: post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Spin
 */

// Get data from ACF fields.
$title = get_post_meta( $post->ID, 'title', true );
$author = get_post_meta( $post->ID, 'author', true );
$link = get_post_meta( $post->ID, 'link', true );

get_header(); ?>

	<div class="wrap">
		<div class="primary content-area">
			<main id="main" class="site-main blog-single" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article <?php post_class( 'blog-post' ); ?>>

					<div class="blog-content-quote">
						<header class="entry-header">
							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

							<div class="entry-meta">
								<?php echo cps_single_posted_on(); // WPCS: XSS ok. ?>
							</div><!-- .entry-meta -->
						</header><!-- .entry-header -->

						<div class="entry-content">
							<div class="featured-container">
								<img class ="featured" src="<?php echo esc_attr( cps_get_post_image_uri( 'featured-blog' ) ); ?>" alt="<?php esc_html_e( 'Featured image for ', 'cps' ); ?><?php echo the_title(); ?>">
							</div><!--.featured-container-->

							<div class="quote-container">
								<blockquote>
								<?php
									the_content( sprintf(
										/* translators: %s: Name of current post. */
										wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'cps' ), array( 'span' => array( 'class' => array() ) ) ),
										the_title( '<span class="screen-reader-text">"', '"</span>', false )
									) );
								?>
								</blockquote>

								<a href="<?php echo esc_url( $link ); ?>"><span class="source-title"><?php echo esc_html( $title ); ?></span></a>
								<cite><?php esc_html_e( '- ', 'cps' ); ?><?php echo esc_html( $author ); ?></cite>
							</div><!--.quote-container-->
							<?php
								wp_link_pages( array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cps' ),
									'after'  => '</div>',
								) );
							?>
						</div><!-- .entry-content -->
					</div><!--/.blog-content-->
				</article><!-- #post-## -->

				<?php the_post_navigation();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

			</main><!-- #main -->
		</div><!-- .primary -->

		<?php get_sidebar(); ?>

	</div><!-- .wrap -->

<?php get_footer(); ?>
