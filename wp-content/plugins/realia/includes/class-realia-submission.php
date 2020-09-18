<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Realia_Submission
 *
 * @class Realia_Submission
 * @package Realia/Classes
 * @author Pragmatic Mates
 */
class Realia_Submission {
	/**
	 * Initialize submission
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'process_remove_form' ), 9999 );
		add_filter( 'realia_payment_gateways', array( __CLASS__, 'payment_gateways' ) );
		add_filter( 'the_posts', array( __CLASS__, 'show_pending_listings_visible_to_author' ), 10, 2 );
	}

	/**
	 * Defines default payment gateways
	 *
	 * @access public
	 * @return array
	 */
	public static function payment_gateways() {
		$gateways = array();

		if ( self::is_wire_transfer_active() ) {
			array_push($gateways,
				array(
					'id'    => 'wire-transfer',
					'title' => __( 'Wire Transfer', 'realia' ),
					'proceed' => false,
					'content' => Realia_Template_Loader::load( 'submission/wire-transfer' ),
				)
			);
		}

		return $gateways;
	}

	/**
	 * Process remove listing form
	 *
	 * @access public
	 * @return void
	 */
	public static function process_remove_form() {
		if ( ! isset( $_POST['remove_property_form'] ) || empty( $_POST['property_id'] ) ) {
			return;
		}

		if ( wp_delete_post( $_POST['property_id'] ) ) {
			$_SESSION['messages'][] = array( 'success', __( 'Property has been successfully removed.', 'realia' ) );
		} else {
			$_SESSION['messages'][] = array( 'danger', __( 'An error occured when removing an item.', 'realia' ) );
		}
	}

	/**
	 * Checks if Wire Transfer is active
	 *
	 * @access public
	 * @return bool
	 */
	public static function is_wire_transfer_active() {
		$account_number = get_theme_mod( 'realia_wire_transfer_account_number', null );
		$swift = get_theme_mod( 'realia_wire_transfer_swift', null );
		$full_name = get_theme_mod( 'realia_wire_transfer_full_name', null );
		$country = get_theme_mod( 'realia_wire_transfer_country', null );

		return ( ! empty( $account_number ) && ! empty( $swift ) && ! empty( $full_name ) && ! empty( $country ) );
	}

	/**
	 * Makes pending listings visible to listing author
	 *
	 * @access public
	 * @param $posts
	 * @param $wp_query
	 * @return array
	 */
	public static function show_pending_listings_visible_to_author( $posts, $wp_query ) {
		if ( ! is_user_logged_in() || empty( $wp_query->query['p'] ) || empty( $wp_query->query['post_type'] ) ) {
			return $posts;
		}

		$post_id = $wp_query->query['p'];
		$post = get_post( $post_id );

		if ( $post && $post->post_author == get_current_user_id() ) {
			return array( $post );
		}

		return $posts;
	}
}

Realia_Submission::init();
