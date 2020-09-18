<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Realia_Packages
 *
 * @class Realia_Packages
 * @package Realia/Classes
 * @author Pragmatic Mates
 */
class Realia_Packages {
	/**
	 * Initialize packages functionality
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'wp', array( __CLASS__, 'check_properties' ) );
	}

	/**
	 * Returns list of package IDs and titles
	 *
	 * @access public
	 * @param bool $show_none
	 * @param bool $show_trial
	 * @param bool $show_free
	 * @param bool $show_private
	 * @return array
	 */
	public static function get_packages_choices( $show_none = false, $show_trial = false, $show_free = true, $show_private = false ) {
		$packages = Realia_Packages::get_packages( $show_trial, $show_free, $show_private );

		$choices = array();

		if ( $show_none ) {
			$choices[] = __( 'Not set', 'inventor-packages' );
		}

		foreach ( $packages as $package ) {
			$choices[ $package->ID ] = $package->post_title;
		}

		return $choices;
	}

	/**
	 * Returns list of packages
	 *
	 * @access public
	 * @param bool $include_trial
	 * @param bool $include_free
	 * @param bool $include_private
	 * @return array
	 */
	public static function get_packages( $include_trial = false, $include_free = true, $include_private = false ) {
		$packages_query = new WP_Query( array(
			'post_type'         => 'package',
			'posts_per_page'    => -1,
			'post_status'       => 'publish',
		) );

		$packages = array();

		foreach ( $packages_query->posts as $package ) {
			$duration = self::get_package_duration( $package->ID );
			$price = self::get_package_price( $package->ID );

			$is_regular = ! empty ( $price ) && $price > 0 && ! empty( $duration );
			$is_simple = ! empty ( $price ) && $price > 0 && empty( $duration );
			$is_trial = ( empty ( $price ) || $price == 0 ) && ! empty( $duration );
			$is_free = ( empty ( $price ) || $price == 0 ) && empty( $duration );
			$is_private = get_post_meta( $package->ID, REALIA_PACKAGE_PREFIX . 'private', true );

			if ( $is_regular || $is_simple || $is_trial && $include_trial || $is_free && $include_free ) {
				if ( ! ( $is_private && ! $include_private ) ) {
					$packages[] = $package;
				}
			}
		}

		return $packages;
	}

	/**
	 * Gets all durations for packages
	 *
	 * @access public
	 * @param bool $show_none
	 * @return array
	 */
	public static function get_package_durations( $show_none = false ) {
		$durations = array();

		if ( $show_none ) {
			$durations[] = __( 'Not set', 'realia' );
		}

		return array_merge( $durations, array(
			'1_week'        => __( '1 week', 'realia' ),
			'1_month'       => __( '1 month', 'realia' ),
			'1_year'        => __( '1 year', 'realia' ),
		) );
	}

	/**
	 * Gets package for user
	 *
	 * @access public
	 * @param $user_id
	 * @return bool|WP_Post
	 */
	public static function get_package_for_user( $user_id ) {
		$current_package_array = get_user_meta( $user_id, REALIA_USER_PREFIX . 'package' );

		if ( count( $current_package_array ) == 0 ) {
			return false;
		}

		$current_package_id = array_shift( $current_package_array );
		return get_post( $current_package_id );
	}

	/**
	 * Gets package valid until data for user
	 *
	 * @access public
	 * @param $user_id
	 * @return bool|string
	 */
	public static function get_package_valid_date_for_user( $user_id ) {
		$valid = get_user_meta( $user_id, REALIA_USER_PREFIX . 'package_valid', true );

		if ( ! empty( $valid ) ) {
			$date_format = get_option( 'date_format' );
			return date( $date_format, $valid );
		}

		return false;
	}

	/**
	 * Checks if user's package is valid
	 *
	 * @access public
	 * @param $user_id
	 * @return bool
	 */
	public static function is_package_valid_for_user( $user_id ) {
		$valid = get_user_meta( $user_id, REALIA_USER_PREFIX . 'package_valid', true );
		$today = strtotime( 'today' );

		if ( empty( $valid ) ) {
			return false;
		}

		if ( $today > $valid ) {
			return false;
		}

		return true;
	}

	/**
	 * Gets remaining properties from user package
	 *
	 * @access public
	 * @param $user_id
	 * @return int|mixed|string
	 */
	public static function get_remaining_properties_count_for_user( $user_id ) {
		$package = self::get_package_for_user( $user_id );

		if ( $package && self::is_package_valid_for_user( $user_id ) ) {
			$of_properties = get_post_meta( $package->ID, REALIA_PACKAGE_PREFIX . 'of_properties', true );

			if ( '-1' == $of_properties ) {
				return 'unlimited';
			}

			$user_properties = count( Realia_Query::get_properties_by_user( $user_id )->posts );
			return $of_properties - $user_properties;
		}

		return 0;
	}

	/**
	 * Get package title
	 *
	 * @access public
	 * @param $package_id
	 * @return bool|string
	 */
	public static function get_package_title( $package_id ) {
		$packages = Realia_Query::package_find( $package_id );

		if ( is_array( $packages->posts ) && count( $packages->posts ) > 0 ) {
			$package = array_shift( $packages->posts );
			return $package->post_title;
		}

		return false;
	}

	/**
	 * Gets full package title
	 *
	 * @acces public
	 * @param $package_id
	 * @param $include_details
	 * @return string
	 */
	public static function get_full_package_title( $package_id, $include_details = true ) {
		$package = self::get_package( $package_id );

		if( ! $include_details ) {
			return $package->post_title;
		}

		$price_formatted = self::get_package_formatted_price( $package_id );
		$duration_formatted = self::get_package_duration( $package_id, true );

		$price_and_duration = sprintf( ' (%s/%s)', $price_formatted, $duration_formatted );

		# free package
		$price_and_duration = str_replace( ' (/)', '', $price_and_duration );

		# package without duration
		$price_and_duration = str_replace( '/)', ')', $price_and_duration );

		return trim( sprintf( '%s%s', $package->post_title, $price_and_duration ) );
	}

	/**
	 * Gets package price
	 *
	 * @access public
	 * @param $package_id
	 * @return bool|float
	 */
	public static function get_package_price( $package_id ) {
		$price = get_post_meta( $package_id, REALIA_PACKAGE_PREFIX . 'price', true );

		if ( empty( $price ) || ! is_numeric( $price ) ) {
			return false;
		}

		return $price;
	}

	/**
	 * Gets package formatted price
	 *
	 * @access public
	 * @param $package_id
	 * @return bool|string
	 */
	public static function get_package_formatted_price( $package_id ) {
		$price = get_post_meta( $package_id, REALIA_PACKAGE_PREFIX . 'price', true );
		return Realia_Price::format_price( $price );
	}

	/**
	 * Checks if package exists
	 *
	 * @access public
	 * @param null $package_id
	 * @return bool
	 */
	public static function package_exists( $package_id = null ) {
		if ( empty( $package_id ) ) {
			return false;
		}

		$query = Realia_Query::package_find( $package_id );

		if ( count( $query->posts ) > 0 ) {
			return true;
		}

		return false;
	}

	/**
	 * Sets package for user
	 *
	 * @access public
	 * @param $user_id
	 * @param $package_id
	 * @return bool
	 */
	public static function set_package_for_user( $user_id, $package_id ) {
		if ( empty( $user_id ) || empty( $package_id ) ) {
			return false;
		}

		$duration = get_post_meta( $package_id, REALIA_PACKAGE_PREFIX . 'duration', true );

		if ( ! $duration ) {
			return false;
		}

		switch ( $duration ) {
			case '1_week':
				update_user_meta( $user_id, REALIA_USER_PREFIX . 'package_valid', strtotime( '+1 week' ) );
				break;
			case '1_month':
				update_user_meta( $user_id, REALIA_USER_PREFIX . 'package_valid', strtotime( '+1 month' ) );
				break;
			case '1_year':
				update_user_meta( $user_id, REALIA_USER_PREFIX . 'package_valid', strtotime( '+1 year' ) );
				break;
			default:
				return false;
				break;
		}

		update_user_meta( $user_id, REALIA_USER_PREFIX . 'package', $package_id );
		return true;
	}

	/**
	 * Checks if user is allowed to add submision
	 *
	 * @access public
	 * @param $user_id
	 * @return bool
	 */
	public static function is_allowed_to_add_submission( $user_id ) {
		if ( get_theme_mod( 'realia_submission_type', 'free' ) == 'packages' ) {
			if ( self::is_package_valid_for_user( $user_id ) && ( self::get_remaining_properties_count_for_user( $user_id ) > 0 || self::get_remaining_properties_count_for_user( $user_id ) === 'unlimited' ) ) {
				return true;
			}

			return false;
		}

		return true;
	}

	/**
	 * Unpublish properties
	 *
	 * @access public
	 * @param $properties
	 * @return void
	 */
	public static function unpublish_properties( $properties ) {
		$items_to_unpublish = array();

		foreach ( $properties as $item ) {
			if ( $item->post_status != 'publish' ) {
				continue;
			}

			$items_to_unpublish[] += $item->ID;
		}

		if ( count( $items_to_unpublish ) > 0 ) {
			global $wpdb;
	
			$sql = 'UPDATE ' . $wpdb->prefix . 'posts SET post_status = \'draft\' WHERE ID IN (' . implode( ",", $items_to_unpublish ) . ');';
	
			$wpdb->get_results( $sql );
		}
	}

	/**
	 * Publish properties
	 *
	 * @access public
	 * @param $properties
	 * @return void
	 */
	public static function publish_properties( $properties ) {
		$review_before_publish = get_theme_mod( 'realia_submission_review_before', false );

		$items_to_publish = array();

		foreach ( $properties as $item ) {
			if ( $item->post_status == 'publish' ) {
				continue;
			}

			if ( $review_before_publish && $item->post_status == 'draft' || ! $review_before_publish ) {
				$items_to_publish[] += $item->ID;
			}
		}

		if ( count( $items_to_publish ) > 0 ) {
			global $wpdb;
	
			$sql = 'UPDATE ' . $wpdb->prefix . 'posts SET post_status = \'publish\' WHERE ID IN (' . implode(",", $items_to_publish) . ');';
	
			$wpdb->get_results( $sql );
		}
	}

	/**
	 * Set property status for properties
	 *
	 * @access public
	 * @return void
	 */
	public static function check_properties() {
		if ( get_theme_mod( 'realia_submission_type' ) != 'packages' ) {
			return;
		}

		$options = array();
		$users = get_users( $options );

		foreach ( $users as $user ) {
			$query = Realia_Query::get_properties_by_user( $user->ID );

			$items = $query->posts;

			if ( count( $items ) == 0 ) {
				continue;
			}

			// Check if package is valid
			$is_package_valid = self::is_package_valid_for_user( $user->ID );

			if ( ! $is_package_valid ) {
				// Unpublish all properties
				self::unpublish_properties( $items );
			} else {
				// Get remaining posts available to create
				$remaining = self::get_remaining_properties_count_for_user( $user->ID );

				if ( 'unlimited' == $remaining || $remaining >= 0 ) {
					// Publish all properties
					self::publish_properties( $items );
				} else {
					// Publish available properties
					self::publish_properties( array_slice( $items, abs( $remaining ) , count( $items ) - abs( $remaining ) ) );

					// Unpublish abs(remaining) properties
					self::unpublish_properties( array_slice( $items, 0, abs( $remaining ) ) );
				}
			}
		}
	}

	/**
	 * Get package by id
	 *
	 * @access public
	 * @param $package_id int
	 * @return object
	 */
	public static function get_package( $package_id ) {
		$post = get_post( $package_id );

		if( ! $post || $post->post_type != 'package' || $post->post_status != 'publish' ) {
			return false;
		}

		return $post;
	}

	/**
	 * Gets package duration
	 *
	 * @access public
	 * @param $package_id
	 * @param $as_string
	 * @return float|string
	 */
	public static function get_package_duration( $package_id, $as_string = false ) {
		$duration = get_post_meta( $package_id, REALIA_PACKAGE_PREFIX . 'duration', true );

		if ( empty( $duration ) ) {
			return $as_string ? '' : false;
		}

		$durations = self::get_package_durations();

		$duration_formatted = ! empty ( $durations[ $duration ] ) ? $durations[ $duration ] : '';

		return $as_string ? $duration_formatted : $duration;
	}

	/**
	 * Checks if package is trial
	 *
	 * @access public
	 * @param int $package_id
	 * @return bool
	 */
	public static function is_package_trial( $package_id ) {
		$package = self::get_package( $package_id );

		if ( ! $package ) {
			return false;
		}

		$duration = self::get_package_duration( $package->ID );
		$price = self::get_package_price( $package->ID );

		$is_trial = ( empty ( $price ) || $price == 0 ) && ! empty( $duration );

		return $is_trial;
	}

	/**
	 * Checks if package is free
	 *
	 * @access public
	 * @param int $package_id
	 * @return bool
	 */
	public static function is_package_free( $package_id ) {
		$package = self::get_package( $package_id );

		if ( ! $package ) {
			return false;
		}

		$duration = self::get_package_duration( $package->ID );
		$price = self::get_package_price( $package->ID );

		$is_free = ( empty ( $price ) || $price == 0 ) && empty( $duration );

		return $is_free;
	}

	/**
	 * Checks if package is simple (one-time fee)
	 *
	 * @access public
	 * @param int $package_id
	 * @return bool
	 */
	public static function is_package_simple( $package_id ) {
		$package = self::get_package( $package_id );

		if ( ! $package ) {
			return false;
		}

		$duration = self::get_package_duration( $package->ID );
		$price = self::get_package_price( $package->ID );

		$is_simple = ! empty ( $price ) && $price > 0 && empty( $duration );

		return $is_simple;
	}

	/**
	 * Checks if package is regular
	 *
	 * @access public
	 * @param int $package_id
	 * @return bool
	 */
	public static function is_package_regular( $package_id ) {
		$package = self::get_package( $package_id );

		if ( ! $package ) {
			return false;
		}

		$duration = self::get_package_duration( $package->ID );
		$price = self::get_package_price( $package->ID );

		$is_regular = ! empty ( $price ) && $price > 0 && ! empty( $duration );

		return $is_regular;
	}
}

Realia_Packages::init();
