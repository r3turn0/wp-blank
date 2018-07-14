<?php 
// Start functions.php

add_action( 'after_setup_theme', 'SITENAME_setup' );
function SITENAME_setup() {
	load_theme_textdomain( 'SITENAME', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
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
	wp_enqueue_style( 'SITENAME-css',  get_template_directory_uri() . '/css/SITENAME.css');
	/* ------------ SCRIPTS -------------- */
	// Queue site script after loading array dependencies in Wordpress CORE. List of Built in pacakages can be found here:
	// https://developer.wordpress.org/reference/functions/wp_enqueue_script/
	wp_enqueue_script('SITENAME-js', get_template_directory_uri() .'/js/SITENAME.js', array('jquery', 'jquery-ui-core'));
}

add_action( 'comment_form_before', 'SITENAME_enqueue_comment_reply_script' );
function SITENAME_enqueue_comment_reply_script() {
	if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}

add_filter( 'the_title', 'SITENAME_title' );
function SITENAME_title( $title ) {
	if ( $title == '' ) {
		return '&rarr;';
	} else {
		return $title;
	}
}

add_filter( 'wp_title', 'SITENAME_filter_wp_title' );
function SITENAME_filter_wp_title( $title ) {
	return $title . esc_attr( get_bloginfo( 'name' ) );
}

add_action( 'widgets_init', 'SITENAME_widgets_init' );
function SITENAME_widgets_init() {
	register_sidebar( array (
		'name' => __( 'Sidebar Widget Area', 'SITENAME' ),
		'id' => 'primary-widget-area',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title" style="display: none;">',
		'after_title' => '</h3>',
	) );
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
}

/* ------------- Show all categories ------------ */
add_filter( 'widget_categories_args', 'wpb_force_empty_cats' );
function wpb_force_empty_cats($cat_args) {
    $cat_args['hide_empty'] = 0;
    return $cat_args;
}

/* ------------ HEADER IMAGE ------------ */
$headerDef = array(
	'flex-width'    => true,
	'flex-height'   => true,
	'header-text'   => true,
	'default-image' => get_template_directory_uri() . '/images/header.jpg',
);
add_theme_support( 'custom-header', $headerDef );

// End functions.php 
?>