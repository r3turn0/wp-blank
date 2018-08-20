<?php 
// Start functions.php

/* -------------- NAVWALKER CLASS -------------- */
require_once get_template_directory() . '/includes/class-wp-bootstrap-navwalker.php';

/* -------------- THEME SETUP -------------- */
add_action( 'after_setup_theme', 'SITENAME_setup' );
function SITENAME_setup() {
	
	load_theme_textdomain( 'SITENAME', get_template_directory() . '/languages' );

	// Enable if you prefer RSS feeds instead of email list based subscriptions
	//add_theme_support( 'automatic-feed-links' );
	
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 840, 0 );
	add_image_size( 'landscape', 560, 420, true );
	add_image_size( 'portrait', 480, 640, true );
	add_image_size( 'square', 480, 480, true );

	global $content_width;

	if ( ! isset( $content_width ) ) $content_width = 640;
		register_nav_menus(
		array( 'main_menu' => __( 'Main Menu', 'SITENAME navigation' ) )
	);
}

/* -------------- QUEUE SCRIPTS -------------- */
add_action( 'wp_enqueue_scripts', 'SITENAME_load_scripts' );
function SITENAME_load_scripts()
{
	/* ------------ CSS ------------ */
	//wp_enqueue_style( 'font', '//fonts.googleapis.com/css?family=Titillium Web:300,400|Fira Sans:400,600');
	wp_enqueue_style( 'fontawesome',  get_template_directory_uri() . '/css/fontawesome/css/fontawesome-all.min.css');
	wp_enqueue_style( 'bootstrap',  get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css');
	wp_enqueue_style( 'SITENAME',  get_template_directory_uri() . '/css/SITENAME.css');

	/* ------------ SCRIPTS -------------- */
	// Queue site script after loading array dependencies in Wordpress CORE. List of Built in pacakages can be found here:
	// https://developer.wordpress.org/reference/functions/wp_enqueue_script/
	wp_enqueue_script( 'popper', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array('jquery', 'jquery-ui-dialog'));
	wp_enqueue_script('bootstrap', get_template_directory_uri() .'/js/bootstrap/bootstrap.min.js', array('popper'));
	wp_enqueue_script('SITENAME', get_template_directory_uri() .'/js/SITENAME.js', array('bootstrap'));
}

add_action( 'widgets_init', 'SITENAME_widgets_init' );
function SITENAME_widgets_init() {
	register_sidebar( array (
		'name' => __( 'Sidebar Widget', 'SITENAME' ),
		'id' => 'sidebar-widget',
		'before_widget' => '<div class="widget-container">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}

/* ------------- COMMENTS ------------ */
/*add_action( 'comment_form_before', 'SITENAME_enqueue_comment_reply_script' );
function SITENAME_enqueue_comment_reply_script() {
	if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}

function SITENAME_custom_pings( $comment ) {
	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
	<?php 
}

add_filter( 'get_comments_number', 'SITENAME_comments_number' );
function SITENAME_comments_number( $count ) {
	if ( !is_admin() ) {
		global $id;
		$comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
		return count( $comments_by_type['comment'] );
	} else {
		return $count;
	}
}*/

/* ------------- SHOW ALL CATEGORIES ------------ */
add_filter( 'widget_categories_args', 'wpb_force_empty_cats' );
function wpb_force_empty_cats($cat_args) {
    $cat_args['hide_empty'] = 0;
    return $cat_args;
}

/* ------------ HEADER IMAGE ------------ */
function header_img_setup() {
	$defaults = array(
		'height' => 'auto',
        'width'  => 'auto',
		'flex-width'    => true,
		'flex-height'   => true,
	);
	add_theme_support( 'custom-header', $defaults );
}
add_action( 'after_setup_theme', 'header_img_setup' );

/* ------------ LOGO ------------ */
function logo_setup() {
    $defaults = array(
        'height'      => 'auto',
        'width'       => 'auto',
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    );
    add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'logo_setup' );

// End functions.php 
?>