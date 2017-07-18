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

/**
 * Get 6 posts from the relevant tag.
 *
 * @param  int|string $tag_slug The tag ID for getting posts.
 * @return WP_Query The tag/archive posts.
 */
function cps_get_archive_tag_posts( $tag_slug ) {

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	return new WP_Query( array(
		'post_type'              => 'post',
		'tag'                    => $tag_slug,
		'posts_per_page'         => 6,
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
		'paged'                  => $paged,
	) );
}

/**
 * Get related posts.
 *
 * @param  int $post_id Post ID.
 * @param  int $related_count How many posts to return.
 * @return WP_Query Related Posts.
 */
function cps_get_related_posts( $post_id, $related_count = 2 ) {

	$terms = get_the_terms( $post_id, 'category' );

	if ( empty( $terms ) ) {
		$terms = array();
	}

	$term_list = wp_list_pluck( $terms, 'slug' );

	$related_args = array(
		'post_type'      => 'post',
		'posts_per_page' => $related_count,
		'post__not_in'   => array( $post_id ),
		'orderby'        => 'rand',
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
		'tax_query'      => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $term_list,
			),
		),
	);

	return new WP_Query( $related_args );
}
