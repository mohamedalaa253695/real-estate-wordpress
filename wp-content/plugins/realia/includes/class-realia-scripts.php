<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Realia_Scripts
 *
 * @class Realia_Scripts
 * @package Realia/Classes
 * @author Pragmatic Mates
 */
class Realia_Scripts {
	/**
	 * Initialize scripts
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_frontend' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_backend' ) );
		add_action( 'wp_footer', array( __CLASS__, 'enqueue_footer' ) );
	}

	/**
	 * Loads frontend files
	 *
	 * @access public
	 * @return void
	 */
	public static function enqueue_frontend() {
		$browser_key = get_theme_mod( 'realia_general_google_browser_key' );
		$key = empty( $browser_key ) ? '' : 'key='. $browser_key . '&';

		wp_enqueue_script( 'google-maps', '//maps.googleapis.com/maps/api/js?'. $key .'libraries=weather,geometry,visualization,places,drawing' );

		wp_enqueue_script( 'infobox', plugins_url( '/realia/libraries/jquery-google-map/infobox.js' ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'markerclusterer', plugins_url( '/realia/libraries/jquery-google-map/markerclusterer.js' ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'mapescape', plugins_url( '/realia/libraries/mapescape/js/mapescape.js' ), array( 'jquery' ), false, true );
		wp_enqueue_style( 'mapescape.css', plugins_url( '/realia/libraries/mapescape/css/mapescape.css' ), array(), '20160604' );
		wp_enqueue_script( 'jquery-google-map', plugins_url( '/realia/libraries/jquery-google-map/jquery-google-map.js' ), array( 'jquery' ), '0.8.6', true );
		wp_enqueue_script( 'jquery-chained-remote', plugins_url( '/realia/libraries/jquery.chained.remote.custom.min.js' ), array( 'jquery' ), false, false );
		wp_enqueue_script( 'realia', plugins_url( '/realia/assets/js/realia.js' ), array( 'jquery' ), '1.2.1', true );

		if ( Realia_Recaptcha::is_recaptcha_enabled() ) {
			wp_enqueue_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js?onload=recaptchaCallback&render=explicit', array( 'jquery' ), false, true );
		}

		if ( ! current_theme_supports( 'realia-custom-styles' ) ) {
			wp_enqueue_style( 'realia', plugins_url( '/realia/assets/css/realia.css' ) );
		}
	}

	/**
	 * Loads backend files
	 *
	 * @access public
	 * @return void
	 */
	public static function enqueue_backend() {
		wp_enqueue_style( 'realia-admin', plugins_url( '/realia/assets/css/realia-admin.css' ) );
		wp_enqueue_style( 'realia-font', plugins_url( '/realia/assets/fonts/realia/style.css' ) );

		$browser_key = get_theme_mod( 'realia_general_google_browser_key' );
		$key = empty( $browser_key ) ? '' : 'key='. $browser_key . '&';

		wp_enqueue_script( 'google-maps', '//maps.googleapis.com/maps/api/js?'. $key .'libraries=weather,geometry,visualization,places,drawing' );
	}

	/**
	 * Loads javascript into footer
	 *
	 * @access public
	 * @return void
	 */
	public static function enqueue_footer() {
		if ( Realia_Recaptcha::is_recaptcha_enabled() && ! is_admin() ) {
			?>
            <script type="text/javascript">
				var recaptchaCallback = function() {
					var recaptchas = document.getElementsByClassName("g-recaptcha");

					for(var i=0; i<recaptchas.length; i++) {
						var recaptcha = recaptchas[i];
						var sitekey = recaptcha.dataset.sitekey;

						grecaptcha.render(recaptcha, {
							'sitekey' : sitekey
						});
					}
				};
            </script>
        <?php
		}
	}
}

Realia_Scripts::init();
