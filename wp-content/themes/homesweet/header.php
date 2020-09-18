<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Homesweet
 * @since Homesweet 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php
	if ( !function_exists( 'wp_site_icon' ) ) {
		$favicon = homesweet_get_config('media-favicon');
		if ( (isset($favicon['url'])) && (trim($favicon['url']) != "" ) ) {
	        if (is_ssl()) {
	            $favicon_image_img = str_replace("http://", "https://", $favicon['url']);		
	        } else {
	            $favicon_image_img = $favicon['url'];
	        }
		?>
	    	<link rel="shortcut icon" href="<?php echo esc_url($favicon_image_img); ?>" />
	    <?php } ?>
    <?php } ?>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if ( homesweet_get_config('preload') ) { ?>
	<div class="apus-page-loading">
	  	<div class="spinner">
		  <div class="rect1"></div>
		  <div class="rect2"></div>
		  <div class="rect3"></div>
		  <div class="rect4"></div>
		  <div class="rect5"></div>
		</div>
	</div>
	
<?php } ?>
<div id="wrapper-container" class="wrapper-container">

	<?php get_template_part( 'headers/mobile/offcanvas-menu' ); ?>

	<?php get_template_part( 'headers/mobile/header-mobile' ); ?>

	<?php $header = apply_filters( 'homesweet_get_header_layout', homesweet_get_config('header_type') );
		if ( empty($header) ) {
			$header = 'v1';
		}
	?>
	<?php get_template_part( 'headers/'.$header ); ?>
	<div id="apus-main-content">