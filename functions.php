<?php
/**
 * Spin functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Spin
 */

if ( ! function_exists( 'cps_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function cps_setup() {
		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Spin, use a find and replace
		 * to change 'cps' to the name of your theme in all the template files.
		 * You will also need to update the Gulpfile with the new text domain
		 * and matching destination POT file.
		 */
		load_theme_textdomain( 'cps', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Featured Blog images.
		add_image_size( 'featured-blog', 450, 321, array( 'center', 'center' ) );
		add_image_size( 'book-cover', 300, 450, array( 'center', 'center' ), false );
		add_image_size( 'half', 400 );

		// Set default image link to none.
		update_option( 'image_default_link_type','none' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'cps' ),
			'mobile'  => esc_html__( 'Optional Mobile Menu', 'cps' ),
		) );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'cps_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add styles to the post editor.
		add_editor_style( array( 'editor-style.css', cps_font_url() ) );

	}
endif; // cps_setup.
add_action( 'after_setup_theme', 'cps_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cps_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cps_content_width', 640 );
}
add_action( 'after_setup_theme', 'cps_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cps_widgets_init() {

	// Define sidebars.
	$sidebars = array(
		'sidebar-1'  => esc_html__( 'Sidebar 1', 'cps' ),
		'sidebar-2'  => esc_html__( 'Footer Widgets', 'cps' ),
	);

	// Loop through each sidebar and register.
	foreach ( $sidebars as $sidebar_id => $sidebar_name ) {
		register_sidebar( array(
			'name'          => $sidebar_name,
			'id'            => $sidebar_id,
			'description'   => sprintf( esc_html__( 'Widget area for %s', 'cps' ), $sidebar_name ),
			'before_widget' => '<aside class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

}
add_action( 'widgets_init', 'cps_widgets_init' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load custom queries.
 */
require get_template_directory() . '/inc/queries.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load styles and scripts.
 */
require get_template_directory() . '/inc/scripts.php';
