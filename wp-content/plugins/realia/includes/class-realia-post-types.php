<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Realia_Post_Types
 *
 * @class Realia_Post_Types
 * @package Realia/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Realia_Post_Types {
	/**
	 * Initialize property types
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_filter( 'realia_social_networks', array( __CLASS__, 'social_networks' ) );
		self::includes();
	}

	/**
	 * Loads property types
	 *
	 * @access public
	 * @return void
	 */
	public static function includes() {
		require_once REALIA_DIR . 'includes/post-types/class-realia-post-type-agency.php';
		require_once REALIA_DIR . 'includes/post-types/class-realia-post-type-agent.php';
		require_once REALIA_DIR . 'includes/post-types/class-realia-post-type-package.php';
		require_once REALIA_DIR . 'includes/post-types/class-realia-post-type-property.php';
		require_once REALIA_DIR . 'includes/post-types/class-realia-post-type-transaction.php';
		require_once REALIA_DIR . 'includes/post-types/class-realia-post-type-user.php';
	}

	public static function social_networks( $social_networks ) {
		$social_networks['facebook'] = 'Facebook';
		$social_networks['google_plus'] = 'Google+';
		$social_networks['twitter'] = 'Twitter';
		$social_networks['linkedin'] = 'LinkedIn';
		return $social_networks;
	}

	/**
	 * Gets all detail sections of current post and renders it
	 *
	 * @return void
	 */
	public static function render_property_detail_sections() {
		$post_type = get_post_type();

		$sections = array(
			'gallery' => esc_attr__( 'Gallery', 'realia' ),
			'overview' => esc_attr__( 'Overview', 'realia' ),
			'description' => esc_attr__( 'Description', 'realia' ),
			'video' => esc_attr__( 'Video', 'realia' ),
			'amenities' => esc_attr__( 'Amenities', 'realia' ),
			'floor-plans' => esc_attr__( 'Floor Plans', 'realia' ),
			'valuation' => esc_attr__( 'Land Valuation', 'realia' ),
			'public-facilities' => esc_attr__( 'Public facilities', 'realia' ),
			'location' => esc_attr__( 'Location', 'realia' ),
			'subproperties' => esc_attr__( 'Subproperties', 'realia' ),
			'similar-properties' => esc_attr__( 'Similar properties', 'realia' ),
			'agent-properties' => esc_attr__( 'More agent properties', 'realia' ),
			'comments' => null
		);

		$sections = apply_filters( 'realia_property_detail_sections', $sections, $post_type );

		// render each section
		foreach( $sections as $section => $section_title ) {
			$section_with_underscores = str_replace( '-', '_', $section );
			$section_with_hyphens = str_replace( '_', '-', $section );

			// action before property section
			do_action( 'realia_before_property_detail_' . $section_with_underscores );

			$plugin_dir = apply_filters( 'realia_property_detail_section_root_dir', REALIA_DIR, $section );

			$params = array(
				'section_title' => $section_title
			);

			try {
				echo Realia_Template_Loader::load( 'properties/detail/section-' . $section_with_hyphens, $params, $plugin_dir );
			} catch (Exception $e) {
				if ( strpos( $e->getMessage(), 'not found') !== false ) {
					// TODO: generic section
//					echo Realia_Template_Loader::load( 'properties/detail/section-generic', $params, $plugin_dir );
				}
			}

			// action after property section
			do_action( 'realia_after_property_detail_' . $section_with_underscores );
		}
	}

	/**
	 * Checks if property is featured
	 *
	 * @access public
	 * @param $post_id
	 * @return boolean
	 */
	public static function is_featured_property( $post_id = null ) {
		$post_id = $post_id == null ? get_the_ID() : $post_id;
		return get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'featured', true );
	}

	/**
	 * Checks if property is reduced
	 *
	 * @access public
	 * @param $post_id
	 * @return boolean
	 */
	public static function is_reduced_property( $post_id = null ) {
		$post_id = $post_id == null ? get_the_ID() : $post_id;
		return get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'reduced', true );
	}

	/**
	 * Checks if property is sticky
	 *
	 * @access public
	 * @param $post_id
	 * @return boolean
	 */
	public static function is_sticky_property( $post_id = null ) {
		$post_id = $post_id == null ? get_the_ID() : $post_id;
		return get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'sticky', true );
	}

	/**
	 * Checks if property has a parent property
	 *
	 * @access public
	 * @param $post_id
	 * @return boolean
	 */
	public static function is_child_property( $post_id = null ) {
		$post_id = $post_id == null ? get_the_ID() : $post_id;
		$parent_listing = get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'parent_property', true );
		return ! empty( $parent_listing );
	}
}

Realia_Post_Types::init();
