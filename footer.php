<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Spin
 */

?>

	</div><!-- #content -->

	<footer class="site-footer">
		<div class="wrap">

			<div class="site-info">
				<?php cps_do_copyright_text(); ?>
			</div>

		</div><!-- .wrap -->
	</footer><!-- .site-footer -->
</div><!-- #page -->

<?php cps_do_mobile_navigation_menu(); ?>

<?php wp_footer(); ?>

</body>
</html>