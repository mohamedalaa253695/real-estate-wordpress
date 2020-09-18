<?php
/**
 * homesweet functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Homesweet
 * @since Homesweet 1.4
 */

define( 'HOMESWEET_THEME_VERSION', '1.4' );
define( 'HOMESWEET_DEMO_MODE', false );

if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

if ( ! function_exists( 'homesweet_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Homesweet 1.0
 */
function homesweet_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on homesweet, use a find and replace
	 * to change 'homesweet' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'homesweet', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 750, true );

	add_image_size( 'homesweet-standard-size', 480, 310, true );
	add_image_size( 'homesweet-special-large', 640, 519, true );
	add_image_size( 'homesweet-special-medium', 555, 210, true );
	add_image_size( 'homesweet-special-small', 262, 210, true );
	add_image_size( 'homesweet-gallery-thumbnails', 194, 114, true );
	add_image_size( 'homesweet-gallery-v1', 1920, 670, true );
	add_image_size( 'homesweet-gallery-v2', 750, 450, true );
	add_image_size( 'homesweet-gallery-v3', 1170, 590, true );
	add_image_size( 'homesweet-gallery-v4', 900, 608, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'homesweet' ),
		'authenticated'  => esc_html__( 'Authenticated user', 'homesweet' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );
	add_theme_support( 'realia-custom-styles' );
	add_theme_support( "woocommerce" );
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = homesweet_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'homesweet_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'responsive-embeds' );
	
	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	add_editor_style( array( 'css/style-editor.css', homesweet_get_fonts_url() ) );
	
	homesweet_get_load_plugins();
}
endif; // homesweet_setup
add_action( 'after_setup_theme', 'homesweet_setup' );
/**
 * Load Google Front
 */


function homesweet_get_fonts_url() {
    $fonts_url = '';

    /* Translators: If there are characters in your language that are not
    * supported by Montserrat, translate this to 'off'. Do not translate
    * into your own language.
    */
    $opensans = _x( 'on', 'Open Sans font: on or off', 'homesweet' );
    $dosis  = _x( 'on', 'Dosis font: on or off', 'homesweet' );
 
    if ( 'off' !== $opensans || 'off' !== $dosis ) {
        $font_families = array();
 
        if ( 'off' !== $opensans ) {
            $font_families[] = 'Open+Sans:300,400,600,700,800';
        }
        if ( 'off' !== $dosis ) {
            $font_families[] = 'Dosis:300,400,500,600,700,800';
        }
 
        $query_args = array(
            'family' => ( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 		
 		$protocol = is_ssl() ? 'https:' : 'http:';
        $fonts_url = add_query_arg( $query_args, $protocol .'//fonts.googleapis.com/css' );
    }
 
    return esc_url_raw( $fonts_url );
}

function homesweet_fonts_url() {  
	$protocol = is_ssl() ? 'https:' : 'http:';
	wp_enqueue_style( 'homesweet-theme-fonts', homesweet_get_fonts_url(), array(), null );
}
add_action('wp_enqueue_scripts', 'homesweet_fonts_url');

/**
 * Enqueue scripts and styles.
 *
 * @since Homesweet 1.0
 */
function homesweet_scripts() {
	// Load our main stylesheet.

	//load font awesome
	wp_enqueue_style( 'awesome', get_template_directory_uri() . '/css/awesome.css', array(), '4.7.0' );
	
	wp_enqueue_style( 'font-ionicons', get_template_directory_uri() . '/css/ionicons.css', array(), 'v2.0.0' );

	wp_enqueue_style( 'apus-font', get_template_directory_uri() . '/css/apus-font.css', array(), '1.0.0' );
	// material design iconic font
	wp_enqueue_style( 'material-design-iconic-font', get_template_directory_uri() . '/css/material-design-iconic-font.css', array(), '2.2.0' );

	// load animate version 3.5.0
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), '3.5.0' );

	// load bootstrap style
	if( is_rtl() ){
		wp_enqueue_style( 'bootstrap-rtl', get_template_directory_uri() . '/css/bootstrap-rtl.css', array(), '3.2.0' );
	}else{
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.2.0' );
	}
	
	wp_enqueue_style( 'homesweet-template', get_template_directory_uri() . '/css/template.css', array(), '3.2' );
	$footer_style = homesweet_print_style_footer();
	if ( !empty($footer_style) ) {
		wp_add_inline_style( 'homesweet-template', $footer_style );
	}
	
	$custom_style = homesweet_custom_styles();
	if ( !empty($custom_style) ) {
		wp_add_inline_style( 'homesweet-template', $custom_style );
	}
	
	wp_enqueue_style( 'homesweet-style', get_template_directory_uri() . '/style.css', array(), '3.2' );

	wp_enqueue_script( 'skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '20150330', true );

	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), '2.2.1', true );

	wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri() . '/js/magnific/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/js/magnific/magnific-popup.css', array(), '1.1.0' );

	// colorbox
	wp_enqueue_script( 'jquery-colorbox', get_template_directory_uri() . '/js/colorbox/jquery.colorbox.js', array( 'jquery' ), '1.1.0', true );
	wp_enqueue_style( 'colorbox', get_template_directory_uri() . '/js/colorbox/colorbox.css', array(), '1.1.0' );
	
	wp_enqueue_script( 'sticky-kit', get_template_directory_uri() . '/js/sticky-kit.js', array( 'jquery' ), '1.1.0', true );
	wp_enqueue_script( 'jquery-unveil', get_template_directory_uri() . '/js/jquery.unveil.js', array( 'jquery' ), '1.1.0', true );
	
	wp_enqueue_script( 'perfect-scrollbar', get_template_directory_uri() . '/js/perfect-scrollbar.jquery.min.js', array( 'jquery' ), '0.6.12', true );
	wp_enqueue_style( 'perfect-scrollbar', get_template_directory_uri() . '/css/perfect-scrollbar.css', array(), '0.6.12' );
	
	wp_register_script( 'homesweet-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery', 'jquery-ui-slider' ), '20150330', true );

	$currency_index = 0;
	$currencies = get_theme_mod( 'realia_currencies' );
	$currency_symbol = ! empty( $currencies[ $currency_index ]['symbol'] ) ? $currencies[ $currency_index ]['symbol'] : '$';
	$dec_point = ! empty( $currencies[ $currency_index ]['money_dec_point'] ) ? $currencies[ $currency_index ]['money_dec_point'] : '.';
	$thousands_separator = ! empty( $currencies[ $currency_index ]['money_thousands_separator'] ) ? $currencies[ $currency_index ]['money_thousands_separator'] : ',';

	wp_localize_script( 'homesweet-script', 'homesweet_ajax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'dec_point' => $dec_point,
		'thousands_separator' => $thousands_separator,
		'comapre_text' => esc_html__('Compare', 'homesweet'),
		'comapre_text_added' => esc_html__('Added Compare', 'homesweet'),
		'currency' => esc_attr($currency_symbol),
		'monthly_text' => esc_html__('Monthly Payment: ', 'homesweet'),
		'transparent_marker' => get_template_directory_uri() . '/images/transparent-marker-image.png',
	));
	wp_enqueue_script( 'homesweet-script' );

	if ( homesweet_get_config('custom_js') != "" ) {
		wp_add_inline_script( 'homesweet-script', homesweet_get_config('custom_js') );
	}
	wp_add_inline_script( 'homesweet-script', "(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);" );
}
add_action( 'wp_enqueue_scripts', 'homesweet_scripts', 100 );

/**
 * Display descriptions in main navigation.
 *
 * @since Homesweet 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function homesweet_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'homesweet_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Homesweet 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function homesweet_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'homesweet_search_form_modify' );

/**
 * Function get opt_name
 *
 */
function homesweet_get_opt_name() {
	return 'homesweet_theme_options';
}
add_filter( 'apus_framework_get_opt_name', 'homesweet_get_opt_name' );


function homesweet_register_demo_mode() {
	if ( defined('HOMESWEET_DEMO_MODE') && HOMESWEET_DEMO_MODE ) {
		return true;
	}
	return false;
}
add_filter( 'apus_framework_register_demo_mode', 'homesweet_register_demo_mode' );

function homesweet_get_demo_preset() {
	$preset = '';
    if ( defined('HOMESWEET_DEMO_MODE') && HOMESWEET_DEMO_MODE ) {
        if ( isset($_GET['_preset']) && $_GET['_preset'] ) {
            $presets = get_option( 'apus_framework_presets' );
            if ( is_array($presets) && isset($presets[$_GET['_preset']]) ) {
                $preset = $_GET['_preset'];
            }
        } else {
            $preset = get_option( 'apus_framework_preset_default' );
        }
    }
    return $preset;
}

function homesweet_get_config($name, $default = '') {
	global $apus_options;
    if ( isset($apus_options[$name]) ) {
        return $apus_options[$name];
    }
    return $default;
}

function homesweet_get_global_config($name, $default = '') {
	$options = get_option( 'homesweet_theme_options', array() );
	if ( isset($options[$name]) ) {
        return $options[$name];
    }
    return $default;
}

function homesweet_exporter_settings_option_keys($option_keys) {
	return array_merge($option_keys, array('theme_mods_homesweet'));
}
add_filter( 'apus_exporter_settings_option_keys', 'homesweet_exporter_settings_option_keys' );

function homesweet_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Default', 'homesweet' ),
		'id'            => 'sidebar-default',
		'description'   => esc_html__( 'Add widgets here to appear in your Sidebar.', 'homesweet' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Topbar information Sidebar', 'homesweet' ),
		'id'            => 'information-default',
		'description'   => esc_html__( 'Add widgets here to appear in your Sidebar.', 'homesweet' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Topbar Social Sidebar', 'homesweet' ),
		'id'            => 'social-default',
		'description'   => esc_html__( 'Add widgets here to appear in your Sidebar.', 'homesweet' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Header Information sidebar', 'homesweet' ),
		'id'            => 'header-infor-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your Header 2.', 'homesweet' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Properties Default Layout Top Sidebar', 'homesweet' ),
		'id'            => 'properties-default-top-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your Properties Default sidebar.', 'homesweet' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Properties sidebar', 'homesweet' ),
		'id'            => 'properties-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your Properties Default sidebar.', 'homesweet' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Properties Halfmap sidebar', 'homesweet' ),
		'id'            => 'halfmap-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in Properties Halfmap version.', 'homesweet' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Single Property sidebar', 'homesweet' ),
		'id'            => 'single-property-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your Single Property.', 'homesweet' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );	
	
	register_sidebar( array(
		'name'          => esc_html__( 'Agencies sidebar', 'homesweet' ),
		'id'            => 'agencies-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your Agencies.', 'homesweet' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'IDX Sidebar', 'homesweet' ),
		'id'            => 'idx-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your Agencies.', 'homesweet' ),
		'before_widget' => '<aside id="%1$s" class="%2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Profile Sidebar', 'homesweet' ),
		'id'            => 'profile-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your Profile.', 'homesweet' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Blog sidebar', 'homesweet' ),
		'id'            => 'blog-left-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homesweet' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
}
add_action( 'widgets_init', 'homesweet_widgets_init' );

function homesweet_get_load_plugins() {

	$plugins[] = array(
		'name'                     => esc_html__( 'Apus Framework For Themes', 'homesweet' ),
        'slug'                     => 'apus-framework',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/apus-framework.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'WPBakery Visual Composer', 'homesweet' ),
	    'slug'                     => 'js_composer',
	    'required'                 => true,
	    'source'				   => get_template_directory() . '/inc/plugins/js_composer.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Revolution Slider', 'homesweet' ),
        'slug'                     => 'revslider',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/revslider.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Cmb2', 'homesweet' ),
	    'slug'                     => 'cmb2',
	    'required'                 => true,
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'MailChimp for WordPress', 'homesweet' ),
	    'slug'                     => 'mailchimp-for-wp',
	    'required'                 =>  true
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Contact Form 7', 'homesweet' ),
	    'slug'                     => 'contact-form-7',
	    'required'                 => true,
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Realia', 'homesweet' ),
	    'slug'                     => 'realia',
	    'required'                 => true,
	);

	tgmpa( $plugins );
}

require get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/functions-helper.php';
require get_template_directory() . '/inc/functions-frontend.php';

/**
 * Implement the Custom Header feature.
 *
 */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/classes/megamenu.php';
require get_template_directory() . '/inc/classes/mobilemenu.php';

/**
 * Custom template tags for this theme.
 *
 */
require get_template_directory() . '/inc/template-tags.php';

$active_plugins =  apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
if ( defined( 'APUS_FRAMEWORK_REDUX_ACTIVED' ) ) {
	require get_template_directory() . '/inc/vendors/redux-framework/redux-config.php';
	define( 'HOMESWEET_REDUX_FRAMEWORK_ACTIVED', true );
}
if( in_array( 'cmb2/init.php', $active_plugins ) ) {
	require get_template_directory() . '/inc/vendors/cmb2/page.php';
	require get_template_directory() . '/inc/vendors/cmb2/footer.php';
	define( 'HOMESWEET_CMB2_ACTIVED', true );
}
if( in_array( 'js_composer/js_composer.php', $active_plugins ) ) {
	require get_template_directory() . '/inc/vendors/visualcomposer/functions.php';
	require get_template_directory() . '/inc/vendors/visualcomposer/google-maps-styles.php';
	if ( defined('WPB_VC_VERSION') && version_compare( WPB_VC_VERSION, '6.0', '>=' ) ) {
		require get_template_directory() . '/inc/vendors/visualcomposer/vc-map-posts2.php';
	} else {
		require get_template_directory() . '/inc/vendors/visualcomposer/vc-map-posts.php';
	}
	require get_template_directory() . '/inc/vendors/visualcomposer/vc-map-theme.php';
	define( 'HOMESWEET_VISUALCOMPOSER_ACTIVED', true );
}
if( in_array( 'realia/realia.php', $active_plugins ) ) {
	require get_template_directory() . '/inc/vendors/realia/functions.php';
	require get_template_directory() . '/inc/vendors/realia/functions-favorite.php';
	require get_template_directory() . '/inc/vendors/realia/functions-compare.php';
	require get_template_directory() . '/inc/vendors/realia/functions-filter.php';
	require get_template_directory() . '/inc/vendors/realia/vc-functions.php';
	require get_template_directory() . '/inc/vendors/realia/vc-map.php';
	require get_template_directory() . '/inc/vendors/realia/functions-submition-form.php';
	require get_template_directory() . '/inc/vendors/realia/functions-save-search.php';
	require get_template_directory() . '/inc/vendors/realia/functions-display.php';
	require get_template_directory() . '/inc/vendors/realia/functions-review.php';
	require get_template_directory() . '/inc/vendors/realia/functions-user.php';

	define( 'HOMESWEET_REALIA_ACTIVED', true );
}
if( in_array( 'apus-framework/apus-framework.php', $active_plugins ) ) {
	require get_template_directory() . '/inc/widgets/contact-info.php';
	require get_template_directory() . '/inc/widgets/custom_menu.php';
	require get_template_directory() . '/inc/widgets/posts.php';
	require get_template_directory() . '/inc/widgets/recent_comment.php';
	require get_template_directory() . '/inc/widgets/recent_post.php';
	require get_template_directory() . '/inc/widgets/search.php';
	require get_template_directory() . '/inc/widgets/single_image.php';
	require get_template_directory() . '/inc/widgets/socials.php';
	require get_template_directory() . '/inc/widgets/user_profile.php';
	require get_template_directory() . '/inc/widgets/mortgage_calculator.php';
	require get_template_directory() . '/inc/widgets/recently-viewed.php';
	require get_template_directory() . '/inc/widgets/properties.php';
	define( 'HOMESWEET_FRAMEWORK_ACTIVED', true );
}
if( in_array( 'nextend-facebook-connect/nextend-facebook-connect.php', $active_plugins ) ) {
	define( 'HOMESWEET_FACEBOOK_CONNECT_ACTIVED', true );
}
if( in_array( 'nextend-google-connect/nextend-google-connect.php', $active_plugins ) ) {
	define( 'HOMESWEET_GOOGLE_CONNECT_ACTIVED', true );
}
if( in_array( 'nextend-twitter-connect/nextend-twitter-connect.php', $active_plugins ) ) {
	define( 'HOMESWEET_TWITTER_CONNECT_ACTIVED', true );
}
/**
 * Customizer additions.
 *
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Styles
 *
 */
require get_template_directory() . '/inc/custom-styles.php';