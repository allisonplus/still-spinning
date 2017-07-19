<?php
/**
 * Template Name: Quotation
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

				<article <?php post_class( 'quote-article' ); ?>>

					<header class="entry-header">
						<h1 class="entry-title"><?php echo esc_html( $title ); ?></h1>
						<span class="author"><cite><?php esc_html_e( 'Source: ', 'cps' ); ?><?php echo esc_html( $author ); ?></cite></span></h1>

						<div class="entry-meta">
							<?php echo cps_single_posted_on(); // WPCS: XSS ok. ?>
						</div><!-- .entry-meta -->

					</header><!-- .entry-header -->

					<div class="entry-content">

						<div class="quote-container">
							<blockquote cite="<?php echo esc_url( $link ); ?>">
							<?php
								the_content( sprintf(
									/* translators: %s: Name of current post. */
									wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'cps' ), array( 'span' => array( 'class' => array() ) ) ),
									the_title( '<span class="screen-reader-text">"', '"</span>', false )
								) );
							?>
							</blockquote>
						</div><!--.quote-container-->

						<div class="featured-container">
						<a class="source-title" href="<?php echo esc_url( $link ); ?>"><img class ="featured" src="<?php echo esc_attr( cps_get_post_image_uri( 'book-cover' ) ); ?>" alt="<?php esc_html_e( 'Featured image for ', 'cps' ); ?><?php echo the_title(); ?>"></a>
						</div><!--.featured-container-->

						<?php
							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cps' ),
								'after'  => '</div>',
							) );
						?>
					</div><!-- .entry-content -->
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

	</div><!-- .wrap -->

<?php get_footer(); ?>
