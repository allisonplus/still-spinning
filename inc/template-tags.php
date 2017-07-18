<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Spin
 */

if ( ! function_exists( 'cps_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function cps_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( 'Posted on %s', 'post date', 'cps' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'cps' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'cps_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function cps_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'cps' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'cps' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'cps' ), esc_html__( '1 Comment', 'cps' ), esc_html__( '% Comments', 'cps' ) );
			echo '</span>';
		}
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function cps_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'cps_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'cps_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so cps_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so cps_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in cps_categorized_blog.
 */
function cps_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return false;
	}
	// Like, beat it. Dig?
	delete_transient( 'cps_categories' );
}
add_action( 'delete_category', 'cps_category_transient_flusher' );
add_action( 'save_post',     'cps_category_transient_flusher' );

/**
 * Return SVG markup.
 *
 * @param  array $args {
 *     Parameters needed to display an SVG.
 *
 *     string $icon Required. Use the icon filename, e.g. "facebook-square".
 *     string $title Optional. SVG title, e.g. "Fac
 *     string $desc Optional. SVG description, e.g. "Share this post on Facebook".
 * }.
 * @return string SVG markup.
 */
function cps_get_svg( $args = array() ) {

	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return esc_html__( 'Please define default parameters in the form of an array.', 'cps' );
	}

	// YUNO define an icon?
	if ( false === array_key_exists( 'icon', $args ) ) {
		return esc_html__( 'Please define an SVG icon filename.', 'cps' );
	}

	// Set defaults.
	$defaults = array(
		'icon'  => '',
		'title' => '',
		'desc'  => '',
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Figure out which title to use.
	$title = ( $args['title'] ) ? $args['title'] : $args['icon'];

	// Begin SVG markup.
	$svg = '<svg class="icon icon-' . esc_html( $args['icon'] ) . '" aria-hidden="true">';

	// Add title markup.
	$svg .= '<title>' . esc_html( $title ) . '</title>';

	// If there is a description, display it.
	if ( $args['desc'] ) {
		$svg .= '<desc>' . esc_html( $args['desc'] ) . '</desc>';
	}

	$svg .= '<use xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use>';
	$svg .= '</svg>';

	return $svg;
}

/**
 * Display an SVG.
 *
 * @param  array $args  Parameters needed to display an SVG.
 */
function cps_do_svg( $args = array() ) {
	echo cps_get_svg( $args ); // WPCS: XSS ok.
}

/**
 * Trim the title length.
 *
 * @param  array $args  Parameters include length and more.
 * @return string        The shortened excerpt.
 */
function cps_get_the_title( $args = array() ) {

	// Set defaults.
	$defaults = array(
		'length' => 12,
		'more'   => '...',
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Trim the title.
	return wp_trim_words( get_the_title( get_the_ID() ), $args['length'], $args['more'] );
}

/**
 * Customize "Read More" string on <!-- more --> with the_content();
 */
function cps_content_more_link() {
	return ' <a class="more-link" href="' . get_permalink() . '">' . esc_html__( 'Read More', 'cps' ) . '...</a>';
}
add_filter( 'the_content_more_link', 'cps_content_more_link' );

/**
 * Customize the [...] on the_excerpt();
 *
 * @param string $more     The current $more string.
 * @return string            Replace with "Read More..."
 */
function cps_excerpt_more( $more ) {
	return sprintf( ' <a class="more-link" href="%1$s">%2$s</a>', get_permalink( get_the_ID() ), esc_html__( 'Read more...', 'cps' ) );
}
add_filter( 'excerpt_more', 'cps_excerpt_more' );

/**
 * Limit the excerpt length.
 *
 * @param  array $args  Parameters include length and more.
 * @return string        The shortened excerpt.
 */
function cps_get_the_excerpt( $args = array() ) {

	// Set defaults.
	$defaults = array(
		'length' => 20,
		'more'   => '...',
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Trim the excerpt.
	return wp_trim_words( get_the_excerpt(), absint( $args['length'] ), esc_html( $args['more'] ) );
}

/**
 * Echo an image, no matter what.
 *
 * @param string $size  The image size you want to display.
 */
function cps_do_post_image( $size = 'thumbnail' ) {

	// If featured image is present, use that.
	if ( has_post_thumbnail() ) {
		return the_post_thumbnail( $size );
	}

	// Check for any attached image.
	$media = get_attached_media( 'image', get_the_ID() );
	$media = current( $media );

	// Set up default image path.
	$media_url = get_stylesheet_directory_uri() . '/assets/images/placeholder.png';

	// If an image is present, then use it.
	if ( is_array( $media ) && 0 < count( $media ) ) {
		$media_url = ( 'thumbnail' === $size ) ? wp_get_attachment_thumb_url( $media->ID ) : wp_get_attachment_url( $media->ID );
	}

	echo '<img src="' . esc_url( $media_url ) . '" class="attachment-thumbnail wp-post-image" alt="' . esc_html( get_the_title() ) . '" />';
}

/**
 * Return an image URI, no matter what.
 *
 * @param  string $size  The image size you want to return.
 * @return string         The image URI.
 */
function cps_get_post_image_uri( $size = 'thumbnail' ) {

	// If featured image is present, use that.
	if ( has_post_thumbnail() ) {

		$featured_image_id = get_post_thumbnail_id( get_the_ID() );
		$media = wp_get_attachment_image_src( $featured_image_id, $size );

		if ( is_array( $media ) ) {
			return current( $media );
		}
	}

	// Check for any attached image.
	$media = get_attached_media( 'image', get_the_ID() );
	$media = current( $media );

	// Set up default image path.
	$media_url = get_stylesheet_directory_uri() . '/assets/images/placeholder.png';

	// If an image is present, then use it.
	if ( is_array( $media ) && 0 < count( $media ) ) {
		$media_url = ( 'thumbnail' === $size ) ? wp_get_attachment_thumb_url( $media->ID ) : wp_get_attachment_url( $media->ID );
	}

	return $media_url;
}

/**
 * Get an attachment ID from it's URL.
 *
 * @param  string $attachment_url  The URL of the attachment.
 * @return int                      The attachment ID.
 */
function cps_get_attachment_id_from_url( $attachment_url = '' ) {

	global $wpdb;

	$attachment_id = false;

	// If there is no url, return.
	if ( '' == $attachment_url ) {
		return false;
	}

	// Get the upload directory paths.
	$upload_dir_paths = wp_upload_dir();

	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image.
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

		// If this is the URL of an auto-generated thumbnail, get the URL of the original image.
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

		// Remove the upload path base directory from the attachment URL.
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

		// Finally, run a custom database query to get the attachment ID from the modified attachment URL.
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

	}

	return $attachment_id;
}

/**
 * Echo the copyright text saved in the Customizer.
 */
function cps_do_copyright_text() {

	// Grab our customizer settings.
	$copyright_text = get_theme_mod( 'cps_copyright_text' );

	// Stop if there's nothing to display.
	if ( ! $copyright_text ) {
		return false;
	}

	// Echo the text.
	echo '<span class="copyright-text">	&#169; ' . wp_kses_post( $copyright_text ) . ' ' . date( 'Y' ) . '</span>'; // WPCS: XSS ok.

}

/**
 * Build social sharing icons.
 *
 * @return string
 */
function cps_get_social_share() {

	// Build the sharing URLs.
	$twitter_url  = 'https://twitter.com/share?text=' . urlencode( html_entity_decode( get_the_title() ) ) . '&amp;url=' . rawurlencode( get_the_permalink() );
	$facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( get_the_permalink() );
	$linkedin_url = 'https://www.linkedin.com/shareArticle?title=' . urlencode( html_entity_decode( get_the_title() ) ) . '&amp;url=' . rawurlencode( get_the_permalink() );

	// Start the markup.
	ob_start(); ?>
	<div class="social-share">
		<h5 class="social-share-title"><?php esc_html_e( 'Share This', 'cps' ); ?></h5>
		<ul class="social-icons menu menu-horizontal">
			<li class="social-icon">
				<a href="<?php echo esc_url( $twitter_url ); ?>" onclick="window.open(this.href, 'targetWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, top=150, left=0, width=600, height=300' ); return false;">
					<?php cps_do_svg( array( 'icon' => 'twitter-square', 'title' => 'Twitter', 'desc' => __( 'Share on Twitter', 'cps' ) ) ); ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Share on Twitter', 'cps' ); ?></span>
				</a>
			</li>
			<li class="social-icon">
				<a href="<?php echo esc_url( $facebook_url ); ?>" onclick="window.open(this.href, 'targetWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, top=150, left=0, width=600, height=300' ); return false;">
					<?php cps_do_svg( array( 'icon' => 'facebook-square', 'title' => 'Facebook', 'desc' => __( 'Share on Facebook', 'cps' ) ) ); ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Share on Facebook', 'cps' ); ?></span>
				</a>
			</li>
			<li class="social-icon">
				<a href="<?php echo esc_url( $linkedin_url ); ?>" onclick="window.open(this.href, 'targetWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, top=150, left=0, width=475, height=505' ); return false;">
					<?php cps_do_svg( array( 'icon' => 'linkedin-square', 'title' => 'LinkedIn', 'desc' => __( 'Share on LinkedIn', 'cps' ) ) ); ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Share on LinkedIn', 'cps' ); ?></span>
				</a>
			</li>
		</ul>
	</div><!-- .social-share -->

	<?php
	return ob_get_clean();
}

/**
 * Output the mobile navigation
 */
function cps_do_mobile_navigation_menu() {

	// Figure out which menu we're pulling.
	$mobile_menu = has_nav_menu( 'mobile' ) ? 'mobile' : 'primary';
	?>

	<nav id="mobile-menu" class="mobile-nav-menu">
		<button class="close-mobile-menu"><span class="screen-reader-text"><?php esc_html_e( 'Close menu', 'cps' ); ?></span><?php cps_do_svg( array( 'icon' => 'close' ) ); ?></button>
		<?php
			wp_nav_menu( array(
				'theme_location' => $mobile_menu,
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'menu dropdown mobile-nav',
				'link_before'    => '<span>',
				'link_after'     => '</span>',
			) );
		?>
	</nav>
	<?php
}

/**
 * Social links for the footer.
 */
function cps_get_footer_social_links() {

	// Set an array of social networks.
	$social_networks = array( 'twitter', 'instagram', 'vimeo', 'pinterest' );
	$email = get_theme_mod( 'cps_email_link' );

	ob_start(); ?>

	<ul class="social-networks">

	<?php // If there's no email, don't make this <li> in the first place .?>
	<?php if ( ! empty( $email ) ) : ?>
		<li class="social-network email">
			<a href="mailto:<?php echo esc_url( $email ); ?>">
				<?php echo cps_get_svg( array( 'icon' => 'email-social', '' ) ); // WPCS: XSS ok. ?>
			</a>
		</li>
	<?php endif; ?>

	<?php // Continue <li>'s with rest of social networks provided. ?>
	<?php foreach ( $social_networks as $network ) : ?>
		<li class="social-network <?php echo esc_attr( $network ); ?>">
			<a href="<?php echo esc_url( get_theme_mod( 'cps_' . $network . '_link' ) ); ?>">
				<?php echo cps_get_svg( array( 'icon' => $network . '-social', 'title' => $network . '' ) ); // WPCS: XSS ok. ?>
			</a>
		</li>
	<?php endforeach; ?>
	</ul><!-- .social-networks -->
	<?php
	return ob_get_clean();
}

/**
 * Prints HTML with customized meta information single-post.
 *
 * @author Allison Tarr
 * @param   array $args Potential args to pass.
 */
function cps_single_posted_on( $args = array() ) {

	// Set up category stuff.
	$category = get_the_category();
	$category_name = '';
	$category_link = '';

	// Setup defaults.
	$defaults = array(
		'link'          => get_the_permalink(),
		'date'          => get_the_date( 'F j, Y' ),
		'category'      => $category_name,
		'category_link' => $category_link,
	);

	// If there is an array of categories.
	if ( is_array( $category ) ) {
		$category_name = $category[0]->name;
		$category_link = get_category_link( $category[0]->cat_ID );
	}

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	ob_start();
	?>

	<p class="posted-on"><time class="entry-date"><?php echo esc_attr( $args['date'] ); ?></time></p>
		<p class="meta-content">
			<span class="category"><span class="posted-emphasis"><?php esc_html_e( 'in ', 'cps' ); ?></span><a class="category-link" href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $category_name ); ?></a></span>
		</p>

	<?php
	return ob_get_clean();
}

/**
 * Displays Custom Image Sizes in Media Gallery
 *
 * @param  string $sizes  Image sizes.
 * @author Allison Tarr
 */
function cps_display_custom_img_sizes( $sizes ) {
	global $_wp_additional_image_sizes;
	if ( empty( $_wp_additional_image_sizes ) ) {
		return $sizes;
	}

	foreach ( $_wp_additional_image_sizes as $id => $data ) {
		if ( ! isset( $sizes[ $id ] ) ) {
			$sizes[ $id ] = ucfirst( str_replace( '-', ' ', $id ) );
		}
	}

	return $sizes;
}
add_filter( 'image_size_names_choose', 'cps_display_custom_img_sizes' );
