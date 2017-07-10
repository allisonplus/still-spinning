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

/**
 * Get 6 posts from the relevant category.
 *
 * @param  int|string $cat_id The category ID for getting posts.
 * @return WP_Query The category/archive posts.
 */
function cps_get_archive_posts( $cat_id ) {

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	return new WP_Query( array(
		'post_type'              => 'post',
		'cat'                    => absint( $cat_id ),
		'posts_per_page'         => 6,
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
		'paged'                  => $paged,
	) );
}
