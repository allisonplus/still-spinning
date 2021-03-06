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
$type = get_post_meta( $post->ID, 'type', true );

$title = get_post_meta( $post->ID, 'title', true );
$author = get_post_meta( $post->ID, 'author', true );
$link = get_post_meta( $post->ID, 'link', true );
$subject = get_post_meta( $post->ID, 'subject_matter', true );

get_header(); ?>

	<div class="wrap">
		<div class="primary content-area">
			<main id="main" class="site-main blog-single" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article <?php post_class( 'quote-article' ); ?>>

					<header class="entry-header">

						<?php // If book or article, use different title + citation. ?>
						<?php if ( 'book' == $type || 'article' == $type ) : ?>

						<h1 class="entry-title"><?php echo esc_html( $title ); ?></h1>

						<?php if ( ! empty( $link ) ) : ?>
						<span class="author"><cite><?php esc_html_e( 'Author: ', 'cps' ); ?><?php echo esc_html( $author ); ?></cite></span>
						<?php endif; ?>

						<?php else : ?>

						<h1 class="entry-title"><?php echo esc_html( $author ); ?><?php esc_html_e( ' on ', 'cps' ); ?><?php echo esc_html( $subject ); ?></h1>

						<?php if ( ! empty( $link ) ) : ?>
						<span class="author"><cite><a href="<?php echo esc_url( $link ); ?>"><?php esc_html_e( 'Source', 'cps' ); ?></a></cite></span>
						<?php endif; ?>


						<?php endif; ?>

						<div class="entry-meta">
							<?php echo cps_single_posted_on(); // WPCS: XSS ok. ?>
						</div><!-- .entry-meta -->

						<?php echo cps_show_related_posts(); // WPCS: XSS ok. ?>

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

						<?php // If book or article, use different <img> size.
						if ( has_post_thumbnail() ) {

							if ( 'book' == $type || 'article' == $type ) : ?>

							<div class="featured-container"><a class="source-title" href="<?php echo esc_url( $link ); ?>"><img class ="featured" src="<?php echo esc_attr( cps_get_post_image_uri( 'book-cover' ) ); ?>" alt="<?php esc_html_e( 'Featured image for ', 'cps' ); ?><?php echo the_title(); ?>"></a>
							</div><!--.featured-container-->

							<?php else : ?>

							<div class="featured-container"><a class="source-title" href="<?php echo esc_url( $link ); ?>"><img class ="featured" src="<?php echo esc_attr( cps_get_post_image_uri( 'featured-blog' ) ); ?>" alt="<?php esc_html_e( 'Featured image for ', 'cps' ); ?><?php echo the_title(); ?>"></a>
							</div><!--.featured-container-->

							<?php endif; } ?>

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
