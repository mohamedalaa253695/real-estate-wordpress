<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Realia_Post_Type_User
 *
 * @class Realia_Post_Type_User
 * @package Realia/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Realia_Post_Type_User {
	/**
	 * Initialize custom post type
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'fields' ) );
		add_action( 'init', array( __CLASS__, 'process_change_profile_form' ), 9999 );
		add_action( 'init', array( __CLASS__, 'process_change_password_form' ), 9999 );
		add_action( 'init', array( __CLASS__, 'process_login_form' ), 9999 );
		add_action( 'init', array( __CLASS__, 'process_register_form' ), 9999 );

		add_action( 'pre_get_posts', array( __CLASS__, 'media_files' ) );
		add_filter( 'wp_count_attachments', array( __CLASS__, 'recount_attachments' ) );
		add_action( 'init', array( __CLASS__, 'set_subscriber_permissions' ) );
		add_filter( 'show_admin_bar', array( __CLASS__, 'show_admin_bar_for_admins_only' ) );
	}

	/**
	 * Defines custom fields
	 *
	 * @access public
	 * @param array $metaboxes
	 * @return array
	 */
	public static function fields( array $metaboxes ) {
		if ( is_super_admin() ) {
			$fields = array(
				array(
					'id'        => 'phone',
					'name'      => __( 'Phone', 'realia' ),
					'type'      => 'text',
				),
				array(
					'id'        => REALIA_USER_PREFIX . 'package_title',
					'name'      => __( 'Package Information', 'realia' ),
					'type'      => 'title',
				),
				array(
					'id'        => REALIA_USER_PREFIX . 'package',
					'name'      => __( 'Package', 'realia' ),
					'type'      => 'select',
					'options'   => Realia_Packages::get_packages_choices( true, true, true, true ),
				),
				array(
					'id'        => REALIA_USER_PREFIX . 'package_valid',
					'name'      => __( 'Valid', 'realia' ),
					'type'      => 'text_date_timestamp',
				),
			);

			if ( get_theme_mod( 'realia_submission_enable_agents', false ) ) {
				$agents = array();
				$agents_objects = Realia_Query::get_agents();

				if ( ! empty( $agents_objects->posts ) && is_array( $agents_objects->posts ) ) {
					foreach ( $agents_objects->posts as $agent ) {
						$agents[ $agent->ID ] = $agent->post_title;
					}
				}

				$fields[] = array(
					'id'        => REALIA_USER_PREFIX . 'agent_title',
					'name'      => __( 'Agent', 'realia' ),
					'type'      => 'title',
				);

				$fields[] = array(
					'id'                => REALIA_USER_PREFIX . 'agent_object',
					'name'              => __( 'Agent object', 'realia' ),
					'type'              => 'select',
					'show_option_none'  => true,
					'options'           => $agents,
				);
			}

			$metaboxes['user_general'] = array(
				'id'            => REALIA_USER_PREFIX .'general',
				'title'         => __( 'General', 'realia' ),
				'object_types'  => array( 'user' ),
				'context'       => 'normal',
				'priority'      => 'high',
				'show_names'    => true,
				'fields'        => $fields,
			);
		}

		return $metaboxes;
	}

	/**
	 * Process change profile form
	 *
	 * @access public
	 * @return void
	 */
	public static function process_change_profile_form() {
		if ( ! isset( $_POST['change_profile_form'] ) ) {
			return;
		}
		$user = wp_get_current_user();

		$nickname = sanitize_user( $_POST['nickname'] );
		$email = sanitize_email( $_POST['email'] );
		$first_name = sanitize_text_field( $_POST['first_name'] );
		$last_name = sanitize_text_field( $_POST['last_name'] );
		$phone = sanitize_text_field( $_POST['phone'] );

		if ( empty( $nickname ) ) {
			$_SESSION['messages'][] = array( 'warning', __( 'Nickname is required.', 'realia' ) );
			return;
		}

		if ( empty( $email ) ) {
			$_SESSION['messages'][] = array( 'warning', __( 'E-mail is required.', 'realia' ) );
			return;
		}

		update_user_meta( $user->ID, 'nickname', $nickname );

		update_user_meta( $user->ID, 'user_email', $email );
		wp_update_user( array(
			'ID'            => $user->ID,
			'user_email'    => $email,
		) );
		update_user_meta( $user->ID, 'last_name', $last_name );
		update_user_meta( $user->ID, 'first_name', $first_name );
		update_user_meta( $user->ID, 'phone', $phone );

		$_SESSION['messages'][] = array( 'success', __( 'Profile has been successfully updated.', 'realia' ) );
	}

	/**
	 * Process change password form
	 *
	 * @access public
	 * @return void
	 */
	public static function process_change_password_form() {
		if ( ! isset( $_POST['change_password_form'] ) ) {
			return;
		}

		$old_password = sanitize_text_field( $_POST['old_password'] );
		$new_password = sanitize_text_field( $_POST['new_password'] );
		$retype_password = sanitize_text_field( $_POST['retype_password'] );

		if ( empty( $old_password ) || empty( $new_password ) || empty( $retype_password ) ) {
			$_SESSION['messages'][] = array( 'warning', __( 'All fields are required.', 'realia' ) );
			return;
		}

		if ( $new_password != $retype_password ) {
			$_SESSION['messages'][] = array( 'warning', __( 'New and retyped password are not same.', 'realia' ) );
		}

		$user = wp_get_current_user();

		if ( ! wp_check_password( $old_password, $user->data->user_pass, $user->ID ) ) {
			$_SESSION['messages'][] = array( 'warning', __( 'Your old password is not correct.', 'realia' ) );
			return;
		}

		wp_set_password( $new_password, $user->ID );
		$_SESSION['messages'][] = array( 'success', __( 'Your password has been successfully changed.', 'realia' ) );
	}

	/**
	 * Process login form
	 *
	 * @access public
	 * @return void
	 */
	public static function process_login_form() {
		if ( ! isset( $_POST['login_form'] ) ) {
			return;
		}

		$redirect = site_url();
		if ( ! empty( $_SERVER['HTTP_REFERER'] ) ) {
			$redirect = $_SERVER['HTTP_REFERER'];
		}

		if ( empty( $_POST['login'] ) || empty( $_POST['password'] ) ) {
			$_SESSION['messages'][] = array( 'warning', __( 'Login and password are required.', 'realia' ) );
			wp_redirect( $redirect );
			exit();
		}

		$login = sanitize_text_field( $_POST['login'] );
		$password = sanitize_text_field( $_POST['password'] );

		$user = wp_signon( array(
			'user_login'        => $login,
			'user_password'     => $password,
		) );

		if ( is_wp_error( $user ) ) {
			$_SESSION['messages'][] = array( 'danger', $user->get_error_message() );
			wp_redirect( $redirect );
			exit();
		}

		$_SESSION['messages'][] = array( 'success', __( 'You have been successfully logged in.', 'realia' ) );
		$after_login_page_id = get_theme_mod( 'realia_general_after_login_page' );
		wp_redirect( $after_login_page_id ? get_permalink( $after_login_page_id ) : site_url() );
		exit();
	}

	/**
	 * Process register form
	 *
	 * @access public
	 * @return void
	 */
	public static function process_register_form() {
		if ( ! isset( $_POST['register_form'] ) ) {
			return;
		}

		if ( ! get_option( 'users_can_register' ) ) {
			$_SESSION['messages'][] = array( 'danger', __( 'Registrations are not allowed.', 'realia' ) );
			wp_redirect( $_SERVER['HTTP_REFERER'] );
			exit();
		}

		if ( empty( $_POST['name'] ) || empty( $_POST['email'] ) ) {
			$_SESSION['messages'][] = array( 'danger', __( 'Username and e-mail are required.', 'realia' ) );
			wp_redirect( $_SERVER['HTTP_REFERER'] );
			exit();
		}

		$name = sanitize_user( $_POST['name'] );
		$email = sanitize_email( $_POST['email'] );
		$password = sanitize_text_field( $_POST['password'] );
		$first_name = sanitize_text_field( $_POST['first_name'] );
		$last_name = sanitize_text_field( $_POST['last_name'] );
		$phone = sanitize_text_field( $_POST['phone'] );

		$user_id = username_exists( $name );

		if ( ! empty( $user_id ) ) {
			$_SESSION['messages'][] = array( 'danger', __( 'User already exists.', 'realia' ) );
			wp_redirect( $_SERVER['HTTP_REFERER'] );
			exit();
		}

		if ( $_POST['password'] != $_POST['password_retype'] ) {
			$_SESSION['messages'][] = array( 'danger', __( 'Passwords must be same.', 'realia' ) );
			wp_redirect( $_SERVER['HTTP_REFERER'] );
			exit();
		}

		$terms_id = get_theme_mod( 'realia_submission_terms', false );

		if ( $terms_id && empty( $_POST['agree_terms'] ) ) {
			$_SESSION['messages'][] = array( 'danger', __( 'You must agree terms &amp; conditions.', 'realia' ) );
			wp_redirect( $_SERVER['HTTP_REFERER'] );
			exit();
		}

		if ( $_POST['password'] != $_POST['password_retype'] ) {
			$_SESSION['messages'][] = array( 'danger', __( 'Passwords must be same.', 'realia' ) );
			wp_redirect( $_SERVER['HTTP_REFERER'] );
			exit();
		}

		$user = wp_create_user( $name, $password, $email );

		if ( is_wp_error( $user ) ) {
			$_SESSION['messages'][] = array( 'danger', $user->get_error_message() );
			wp_redirect( site_url() );
			exit();
		}

		// 'admin' / 'both'
		wp_new_user_notification( $user, null, 'both' );

		update_user_meta( $user, 'last_name', $last_name );
		update_user_meta( $user, 'first_name', $first_name );
		update_user_meta( $user, 'phone', $phone );

		$_SESSION['messages'][] = array(
			'success',
		__( 'You have been successfully registered.', 'realia' ),
		);

		$after_register_page_id = get_theme_mod( 'realia_general_after_register_page' );
		wp_redirect( $after_register_page_id ? get_permalink( $after_register_page_id ) : site_url() );
		exit();
	}

	/**
	 * In media library display only current user's files
	 *
	 * @access public
	 * @param array $wp_query
	 * @return void
	 */
	public static function media_files( $wp_query ) {
		global $current_user;

		if ( ! current_user_can( 'manage_options' ) && ( is_admin() && $wp_query->query['post_type'] === 'attachment' ) ) {
			$wp_query->set( 'author', $current_user->ID );
		}
	}

	/**
	 * Count of items in media library
	 *
	 * @access public
	 * @param $counts_in
	 * @return int
	 */
	public static function recount_attachments( $counts_in ) {
		global $wpdb;
		global $current_user;

		$and = wp_post_mime_type_where( '' );
		$count = $wpdb->get_results( "SELECT post_mime_type, COUNT( * ) AS num_posts FROM $wpdb->posts WHERE post_type = 'attachment' AND post_status != 'trash' AND post_author = {$current_user->ID} $and GROUP BY post_mime_type", ARRAY_A );

		$counts = array();
		foreach ( (array) $count as $row ) {
			$counts[ $row['post_mime_type'] ] = $row['num_posts'];
		}

		$counts['trash'] = $wpdb->get_var( "SELECT COUNT( * ) FROM $wpdb->posts WHERE post_type = 'attachment' AND post_author = {$current_user->ID} AND post_status = 'trash' $and" );
		return $counts;
	}

	/**
	 * Allow subscribers to upload images
	 *
	 * @access public
	 * @return void
	 */
	public static function set_subscriber_permissions( ) {
		$subscriber = get_role( 'subscriber' );
		$subscriber->add_cap( 'upload_files' );
		$subscriber->add_cap( 'delete_posts' );
		$subscriber->add_cap( 'edit_post' );
	}

	/**
	 * Disable admin bar for subscribers
	 *
	 * @access public
	 * @param string $content
	 * @return string
	 */
	public static function show_admin_bar_for_admins_only( $content ) {
		return current_user_can( 'administrator' ) ? $content : false;
	}
}

Realia_Post_Type_User::init();
