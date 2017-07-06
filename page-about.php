<?php
/**
 * The template for displaying the About Page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Spin
 */

get_header();  ?>

<div class="main">
	<div class="wrap">

		<div class="page-content-about">

			<div class="user-photo">
				<?php $image = get_field('user-image'); ?>
				<img class="photo" src="<?php echo $image['sizes']['medium_large'] ?>">
			</div> <!--/.user-photo-->

			<div class="info">
				<?php // Start the loop ?>
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

					<?php the_content(); ?>

				<?php endwhile; // end the loop?>
			</div> <!--/.info-->

		</div> <!-- /.page-content-about -->

	</div> <!-- /.wrap -->
</div> <!-- /.main -->

<?php get_footer(); ?>
