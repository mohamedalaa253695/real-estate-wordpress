<?php

if ( function_exists('apus_framework_add_param') ) {
	apus_framework_add_param();
}

function homesweet_admin_init_scripts(){
	$browser_key = get_theme_mod( 'realia_general_google_browser_key' );
	$key = empty( $browser_key ) ? '' : 'key='. $browser_key;
	wp_enqueue_script('googlemap_admin_js', '//maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&amp;'.$key );
	wp_enqueue_script('googlemap_geocomplete_js', get_template_directory_uri().'/js/admin/jquery.geocomplete.min.js');

	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('jquery-ui-css', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
	wp_enqueue_script( 'homesweet-admin-scripts', get_template_directory_uri() . '/js/admin/custom.js', array( 'jquery'  ), '20131022', true );
}
add_action( 'admin_enqueue_scripts', 'homesweet_admin_init_scripts' );

function homesweet_map_init_scripts() {
	wp_enqueue_script('gmap3-js', get_template_directory_uri().'/js/gmap3.js', array( 'jquery'  ), '20131022', true );
}
add_action('wp_enqueue_scripts', 'homesweet_map_init_scripts');
