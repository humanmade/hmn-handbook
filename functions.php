<?php
/**
 * Handbook functions and definitions
 *
 * @package Handbook
 */

function hm_handbook_enqueue_scripts() {
		$hm_handbook_data = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'ajaxnonce' => wp_create_nonce( 'hm-handbook-live-search' )
		);

		wp_enqueue_script( 'hm-handbook-live-search',  get_stylesheet_directory_uri() . '/js/live-search.js', array('jquery') );
		wp_localize_script( 'hm-handbook-live-search', 'hm_handbook', $hm_handbook_data );

		wp_enqueue_style( 'hm-handbook-live-search', get_stylesheet_directory_uri() . '/css/live-search.css' );
}
add_action( 'wp_enqueue_scripts', 'hm_handbook_enqueue_scripts' );

function hm_handbook_live_search_ajax() {
	
	check_ajax_referer( 'hm-handbook-live-search', 'security' );
	
	global $wpdb;
	
	// Get Search
	$q = esc_html( $_POST['hm_handbook_search_query'] );
	
	$search_query_args = array(
		's' => $q,
		'post_type' => array('post', 'page'),
		'posts_per_page' => -1
	);
	
	// Live Search Query
	$search_query = new WP_Query( $search_query_args );

	if ( $search_query->have_posts() ) {
		$search_html = '';
		while ( $search_query->have_posts() ) {
			$search_query->the_post();
			$search_html .= '<li class="result"><a href="'. get_permalink() .'">'. get_the_title() .'</a></li>';
		}
		echo json_encode($search_html);
	}
	
	wp_reset_postdata();
	exit;
}
add_action( 'wp_ajax_hm_handbook', 'hm_handbook_live_search_ajax' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'handbook_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function handbook_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Handbook, use a find and replace
	 * to change 'handbook' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'handbook', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'handbook' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'handbook_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
	) );
}
endif; // handbook_setup
add_action( 'after_setup_theme', 'handbook_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function handbook_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'handbook' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Sidebar Pages List', 'handbook' ),
		'id'            => 'footer-sidebar-1',
		'description'   => __( 'To show our content' ),
		'before_widget' => '<aside id="%1$s" class="widget-a %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Sidebar Collaboration', 'handbook' ),
		'id'            => 'footer-sidebar-2',
		'description'   => __( 'To encourage collaboration' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'handbook_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function handbook_scripts() {
	wp_enqueue_style( 'handbook-style', get_stylesheet_uri() );

	wp_enqueue_script( 'handbook-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'handbook-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'handbook_scripts' );

/**
 * 	Add the Favicon to the head.
 *
 *	Added to theme, admin and login.
 */
function hm_handbook_favicon() { 

	?>
	<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo( 'stylesheet_directory' ); ?>/images/favicon.ico" />
	<?php 

}
add_action( 'wp_head', 'hm_handbook_favicon' );
add_action( 'admin_head', 'hm_handbook_favicon' );
add_action( 'login_head', 'hm_handbook_favicon' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
