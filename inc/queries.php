<?php
/**
 * Custom queries.
 *
 * @package Spin
 */

/**
 * Get three most recent posts.
 *
 * @return WP_Query The recent posts.
 */
function cps_get_recent_posts() {

	return new WP_Query( array(
		'post_type'              => 'post',
		'posts_per_page'         => 3,
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
	) );
}
