<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Realia_Post_Type_Property
 *
 * @class Realia_Post_Type_Property
 * @package Realia/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Realia_Post_Type_Property {
	/**
	 * Initialize custom post type
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_action( 'admin_menu', array( __CLASS__, 'add_pending_count_to_menu' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'fields' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'fields_front' ) );
		add_filter( 'manage_edit-property_columns', array( __CLASS__, 'custom_columns' ) );
		add_action( 'manage_property_posts_custom_column', array( __CLASS__, 'custom_columns_manage' ) );
		add_action( 'init', array( __CLASS__, 'process_enquire_form' ), 9999 );
		add_action( 'template_redirect', array( __CLASS__, 'catch_template' ) );
		add_filter( 'query_vars', array( __CLASS__, 'add_query_vars' ) );
		add_action( 'init', array( __CLASS__, 'process_property_form' ), 10000 );
	}

	/**
	 * Custom post type definition
	 *
	 * @access public
	 * @return void
	 */
	public static function definition() {
		$labels = array(
			'name'                  => __( 'Properties', 'realia' ),
			'singular_name'         => __( 'Property', 'realia' ),
			'add_new'               => __( 'Add New Property', 'realia' ),
			'add_new_item'          => __( 'Add New Property', 'realia' ),
			'edit_item'             => __( 'Edit Property', 'realia' ),
			'new_item'              => __( 'New Property', 'realia' ),
			'all_items'             => __( 'All Properties', 'realia' ),
			'view_item'             => __( 'View Property', 'realia' ),
			'search_items'          => __( 'Search Property', 'realia' ),
			'not_found'             => __( 'No Properties found', 'realia' ),
			'not_found_in_trash'    => __( 'No Properties found in Trash', 'realia' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Properties', 'realia' ),
		);

		register_post_type( 'property',
			array(
				'labels'            => $labels,
				'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author' ),
				'public'            => true,
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => __( 'properties', 'realia' ) ),
				'menu_position'     => 51,
				'categories'        => array(),
				'menu_icon'         => 'dashicons-admin-home',
				'show_in_rest'		=> true,
			)
		);
	}

	/**
	 * Adds pending count to WP admin menu label
	 *
	 * @access public
	 * @return void
	 */
	public static function add_pending_count_to_menu() {
		global $menu;
		$menu_item_index = null;

		foreach( $menu as $index => $menu_item ) {
			if ( ! empty( $menu_item[5] ) && $menu_item[5] == 'menu-posts-property' ) {
				$menu_item_index = $index;
				break;
			}
		}

		if ( $menu_item_index ) {
			$pending = wp_count_posts( 'property' )->pending;
			$count = $pending;

			if ( $count > 0 ) {
				$menu_title = $menu[ $menu_item_index ][0];
				$menu_title = sprintf('%s <span class="awaiting-mod"><span class="pending-count">%d</span></span>', $menu_title, $count );
				$menu[ $menu_item_index ][0] = $menu_title;
			}
		}
	}

	/**
	 * Return array of contract options
	 *
	 * @access public
	 * @return array
	 */
	public static function contract_options() {
		return apply_filters( 'realia_contract_options', array(
			REALIA_CONTRACT_RENT    => __( 'Rent', 'realia' ),
			REALIA_CONTRACT_SALE    => __( 'Sale', 'realia' ),
		) );
	}

	/**
	 * Returns contract display value
	 *
	 * @access public
	 * @param string $key
	 * @return string
	 */
	public static function get_contract_option( $key ) {
		$contract_options = self::contract_options();
		return $contract_options[ $key ];
	}

	/**
	 * Defines custom fields
	 *
	 * @access public
	 * @param array $metaboxes
	 * @return array
	 */
	public static function fields( array $metaboxes ) {
		$metaboxes[ REALIA_PROPERTY_PREFIX . 'general' ] = array(
			'id'                        => REALIA_PROPERTY_PREFIX . 'general',
			'title'                     => __( 'General Options', 'realia' ),
			'object_types'              => array( 'property' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'show_in_rest'				=> true,
			'fields'                    => array(
				array(
					'name'              => __( 'Reference', 'realia' ),
					'id'                => REALIA_PROPERTY_PREFIX . 'id',
					'type'              => 'text',
				),
				array(
					'name'              => __( 'Year built', 'realia' ),
					'id'                => REALIA_PROPERTY_PREFIX . 'year_built',
					'type'              => 'text',
					'attributes' 	    => array(
						'type' 				=> 'number',
						'pattern' 			=> '\d*',
					)
				),
				array(
					'name'              => __( 'Address', 'realia' ),
					'id'                => REALIA_PROPERTY_PREFIX . 'address',
					'type'              => 'textarea',
				),
				array(
					'name'              => __( 'ZIP', 'realia' ),
					'id'                => REALIA_PROPERTY_PREFIX . 'zip',
					'type'              => 'text',
				),
				array(
					'name'              => __( 'Contract', 'realia' ),
					'id'                => REALIA_PROPERTY_PREFIX . 'contract',
					'type'              => 'select',
					'options'           => array_merge( array('' => ''), self::contract_options() )
				),
				array(
					'name'              => __( 'Gallery', 'realia' ),
					'id'                => REALIA_PROPERTY_PREFIX . 'gallery',
					'type'              => 'file_list',
				),
				array(
					'name'              => __( 'Floor Plans', 'realia' ),
					'id'                => REALIA_PROPERTY_PREFIX . 'plans',
					'type'              => 'file_list',
				),
				array(
					'name'              => __( 'Video link', 'realia' ),
					'id'                => REALIA_PROPERTY_PREFIX . 'video',
					'type'              => 'text',
					'description'       => __( 'For more information about embeding videos and video links support please read this <a href="http://codex.wordpress.org/Embeds">article</a>.', 'realia' ),
				),

				array(
					'name'      		=> __( 'Parent property', 'realia' ),
					'desc'      		=> __( 'Useful for types like Condominium', 'realia' ),
					'id'        		=> REALIA_PROPERTY_PREFIX . 'parent_property',
					'type'      		=> 'select',
					'show_option_none' 	=> true,
					'options'          	=> Realia_Post_Type_Property::get_property_choices(),
					'attributes' 	    => array(
						'type' 				=> 'number',
						'pattern' 			=> '\d*',
					)
				),
			),
		);

		$metaboxes[ REALIA_PROPERTY_PREFIX . 'flags' ] = array(
			'id'                        => REALIA_PROPERTY_PREFIX . 'flags',
			'title'                     => __( 'Flags', 'realia' ),
			'object_types'              => array( 'property' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'show_in_rest'				=> WP_REST_SERVER::READABLE,
			'fields'                    => array(
				array(
					'name'              => __( 'Featured', 'realia' ),
					'id'                => REALIA_PROPERTY_PREFIX . 'featured',
					'type'              => 'checkbox',
				),
				array(
					'name'              => __( 'Sticky', 'realia' ),
					'id'                => REALIA_PROPERTY_PREFIX . 'sticky',
					'type'              => 'checkbox',
				),
				array(
					'name'              => __( 'Reduced', 'realia' ),
					'id'                => REALIA_PROPERTY_PREFIX . 'reduced',
					'type'              => 'checkbox',
				),
				array(
					'name'              => __( 'Sold', 'realia' ),
					'id'                => REALIA_PROPERTY_PREFIX . 'sold',
					'type'              => 'checkbox',
				),
			),
		);

		$metaboxes[ REALIA_PROPERTY_PREFIX . 'contact' ] = array(
			'id'                        => REALIA_PROPERTY_PREFIX . 'contact',
			'title'                     => __( 'Contact', 'realia' ),
			'description'               => __( 'Owner, agent or Agency', 'realia' ),
			'object_types'              => array( 'property' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'show_in_rest'				=> true,
			'fields'                    => array(
				array(
					'name'              => __( 'Contact name', 'realia' ),
					'description'       => __( 'Owner, agent or Agency', 'realia' ),
					'id'                => REALIA_PROPERTY_PREFIX . 'contact_name',
					'type'              => 'text',
				),
				array(
					'name'              => __( 'Contact phone', 'realia' ),
					'description'       => __( 'Phone number', 'realia' ),
					'id'                => REALIA_PROPERTY_PREFIX . 'contact_phone',
					'type'              => 'text',
				)
			)
		);

		$metaboxes[ REALIA_PROPERTY_PREFIX . 'pricing' ] = array(
			'id'                        => REALIA_PROPERTY_PREFIX . 'pricing',
			'title'                     => __( 'Pricing', 'realia' ),
			'object_types'              => array( 'property' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'show_in_rest'				=> true,
			'fields'                    => array(
				array(
					'id'                => REALIA_PROPERTY_PREFIX . 'price',
					'name'              => __( 'Price', 'realia' ),
					'type'              => 'text',
					'description'       => __( 'Enter amount without currency.', 'realia' ),
					'attributes'		=> array(
						'type'				=> 'number',
						'min'				=> 0,
						'pattern'			=> '\d*',
					)
				),
				array(
					'id'                => REALIA_PROPERTY_PREFIX . 'price_prefix',
					'name'              => __( 'Prefix', 'realia' ),
					'type'              => 'text',
					'description'       => __( 'Any text shown before price (for example "from").', 'realia' ),
				),
				array(
					'id'                => REALIA_PROPERTY_PREFIX . 'price_suffix',
					'name'              => __( 'Suffix', 'realia' ),
					'type'              => 'text',
					'description'       => __( 'Any text shown after price (for example "per night").', 'realia' ),
				),
				array(
					'id'                => REALIA_PROPERTY_PREFIX . 'price_custom',
					'name'              => __( 'Custom', 'realia' ),
					'type'              => 'text',
					'description'       => __( 'Any text instead of price (for example "by agreement"). Prefix and Suffix will be ignored.', 'realia' ),
				),
			),
		);

		$metaboxes[ REALIA_PROPERTY_PREFIX . 'attributes' ] = array(
			'id'                        => REALIA_PROPERTY_PREFIX . 'attributes',
			'title'                     => __( 'Attributes', 'realia' ),
			'object_types'              => array( 'property' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'show_in_rest'				=> true,
			'fields'                    => array(
				array(
					'id'                => REALIA_PROPERTY_PREFIX . 'rooms',
					'name'              => __( 'Rooms', 'realia' ),
					'type'              => 'text',
					'attributes' 	    => array(
						'type' 				=> 'number',
						'min'				=> 0,
						'pattern' 			=> '\d*',
					)
				),
				array(
					'id'                => REALIA_PROPERTY_PREFIX . 'beds',
					'name'              => __( 'Beds', 'realia' ),
					'type'              => 'text',
					'attributes' 	    => array(
						'type' 				=> 'number',
						'min'				=> 0,
						'pattern' 			=> '\d*',
					)
				),
				array(
					'id'                => REALIA_PROPERTY_PREFIX . 'baths',
					'name'              => __( 'Baths', 'realia' ),
					'type'              => 'text',
					'attributes' 	    => array(
						'type' 				=> 'number',
						'step'				=> 'any',
						'min'				=> 0,
						'pattern'			=> '\d*(\.\d*)?',
					)
				),
				array(
					'id'                => REALIA_PROPERTY_PREFIX . 'garages',
					'name'              => __( 'Garages', 'realia' ),
					'type'              => 'text',
					'attributes' 	    => array(
						'type' 				=> 'number',
						'min'				=> 0,
						'pattern' 			=> '\d*',
					)
				),
				array(
					'id'                => REALIA_PROPERTY_PREFIX . 'home_area',
					'name'              => __( 'Home area', 'realia' ),
					'type'              => 'text',
					'description'       => __( 'In unit set in settings.', 'realia' ),
					'attributes'		=> array(
						'type'				=> 'number',
						'step'				=> 'any',
						'min'				=> 0,
						'pattern'			=> '\d*(\.\d*)?',
					)
				),
				array(
					'id'                => REALIA_PROPERTY_PREFIX . 'lot_dimensions',
					'name'              => __( 'Lot dimensions', 'realia' ),
					'type'              => 'text',
					'description'       => __( 'e.g. 20x30, 20x30x40, 20x30x40x50', 'realia' ),
				),
				array(
					'id'                => REALIA_PROPERTY_PREFIX . 'lot_area',
					'name'              => __( 'Lot area', 'realia' ),
					'type'              => 'text',
					'description'       => __( 'In unit set in settings.', 'realia' ),
					'attributes'		=> array(
						'type'				=> 'number',
						'step'				=> 'any',
						'min'				=> 0,
						'pattern'			=> '\d*(\.\d*)?',
					)
				),
			),
		);

		$metaboxes[ REALIA_PROPERTY_PREFIX . 'valuation' ] = array(
			'id'                        => REALIA_PROPERTY_PREFIX . 'valuation',
			'title'                     => __( 'Valuation', 'realia' ),
			'object_types'              => array( 'property' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'show_in_rest'				=> true,
			'fields'                    => array(
				array(
					'id'                => REALIA_PROPERTY_PREFIX . 'valuation_group',
					'type'              => 'group',
					'fields'            => array(
						array(
							'id'                => REALIA_PROPERTY_PREFIX . 'valuation_key',
							'name'              => __( 'Key', 'realia' ),
							'type'              => 'text',
						),
						array(
							'id'                => REALIA_PROPERTY_PREFIX . 'valuation_value',
							'name'              => __( 'Value', 'realia' ),
							'type'              => 'text',
							'attributes' 	    => array(
								'type' 				=> 'number',
								'min'				=> 0,
								'pattern' 			=> '\d*',
							)
						),
					),
				),
			),
		);

		$metaboxes[ REALIA_PROPERTY_PREFIX . 'public_facilities' ] = array(
			'id'                        => REALIA_PROPERTY_PREFIX . 'public_facilities',
			'title'                     => __( 'Public facilities', 'realia' ),
			'object_types'              => array( 'property' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'show_in_rest'				=> true,
			'fields'                    => array(
				array(
					'id'                => REALIA_PROPERTY_PREFIX . 'public_facilities_group',
					'type'              => 'group',
					'fields'            => array(
						array(
							'id'                => REALIA_PROPERTY_PREFIX . 'public_facilities_key',
							'name'              => __( 'Key', 'realia' ),
							'type'              => 'text',
						),
						array(
							'id'                => REALIA_PROPERTY_PREFIX . 'public_facilities_value',
							'name'              => __( 'Value', 'realia' ),
							'type'              => 'text',
						),
					),
				),
			),
		);

		$metaboxes[ REALIA_PROPERTY_PREFIX . 'map_location' ] = array(
			'id'                        => REALIA_PROPERTY_PREFIX . 'map_location',
			'title'                     => __( 'Location', 'realia' ),
			'object_types'              => array( 'property' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'show_in_rest'				=> true,
			'fields'                    => array(
				array(
					'id'                => REALIA_PROPERTY_PREFIX . 'map_location',
					'name'              => __( 'Location', 'realia' ),
					'type'              => 'pw_map',
					'sanitization_cb'   => 'pw_map_sanitise',
					'split_values'      => true,
				),
			),
		);

		$agents = array();
		$agents_objects = Realia_Query::get_agents();

		if ( ! empty( $agents_objects->posts ) && is_array( $agents_objects->posts ) ) {
			foreach ( $agents_objects->posts as $object ) {
				$agents[ $object->ID ] = $object->post_title;
			}
		}

		$metaboxes[ REALIA_PROPERTY_PREFIX . 'relations' ] = array(
			'id'                        => REALIA_PROPERTY_PREFIX . 'relations',
			'title'                     => __( 'Relations', 'realia' ),
			'object_types'              => array( 'property' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'show_in_rest'				=> true,
			'fields'                    => array(
				array(
					'name'              => __( 'Agents', 'realia' ),
					'id'                => REALIA_PROPERTY_PREFIX . 'agents',
					'type'              => 'multicheck',
					'options'           => $agents,
				),
			),
		);

		return $metaboxes;
	}

	/**
	 * Defines custom front end fields
	 *
	 * @access public
	 * @param array $metaboxes
	 * @return array
	 */
	public static function fields_front( array $metaboxes ) {
		if ( ! is_admin() ) {
			$post_id = empty( $_GET['id'] ) ? false : intval( $_GET['id'] );

			if ( ! empty( $post_id ) ) {
				$post = get_post( $post_id );
				$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ) );
			}

			$metaboxes[ REALIA_PROPERTY_PREFIX . 'front' ] = array(
				'id'                        => REALIA_PROPERTY_PREFIX . 'front',
				'title'                     => __( 'General Options', 'realia' ),
				'object_types'              => array( 'property' ),
				'context'                   => 'normal',
				'priority'                  => 'high',
				'show_names'                => true,
				'fields'                    => array(
					array(
						'id'                => REALIA_PROPERTY_PREFIX . 'post_type',
						'type'              => 'hidden',
						'default'           => 'property',
					),
					array(
						'name'              => __( 'Title', 'realia' ),
						'id'                => REALIA_PROPERTY_PREFIX . 'title',
						'type'              => 'text',
						'default'           => ! empty( $post ) ? $post->post_title : '',
						'attributes'		=> array(
							'required'			=> 'required'
						)
					),
					array(
						'name'              => __( 'Description', 'realia' ),
						'id'                => REALIA_PROPERTY_PREFIX . 'text',
						'type'              => 'textarea',
						'default'           => ! empty( $post ) ? $post->post_content : '',
					),
					array(
						'name'              => __( 'Featured Image', 'realia' ),
						'id'                => REALIA_PROPERTY_PREFIX . 'featured_image',
						'type'              => 'file',
						'default'           => ! empty( $featured_image ) ? $featured_image[0] : '',
					),
					array(
						'name'              => __( 'Reference', 'realia' ),
						'id'                => REALIA_PROPERTY_PREFIX . 'id',
						'type'              => 'text',
					),
					array(
						'name'              => __( 'Year built', 'realia' ),
						'id'                => REALIA_PROPERTY_PREFIX . 'year_built',
						'type'              => 'text',
						'attributes' 	    => array(
							'type' 				=> 'number',
							'min'				=> 0,
							'pattern' 			=> '\d*',
						)
					),
					array(
						'name'              => __( 'Gallery', 'realia' ),
						'id'                => REALIA_PROPERTY_PREFIX . 'gallery',
						'type'              => 'file_list',
					),
					array(
						'id'                => REALIA_PROPERTY_PREFIX . 'price',
						'name'              => __( 'Price', 'realia' ),
						'type'              => 'text',
						'description'       => __( 'Enter amount without currency.', 'realia' ),
						'attributes'		=> array(
							'type'				=> 'number',
							'min'				=> 0,
							'pattern'			=> '\d*',
						)
					),
					array(
						'id'                => REALIA_PROPERTY_PREFIX . 'rooms',
						'name'              => __( 'Rooms', 'realia' ),
						'type'              => 'text',
						'attributes' 	    => array(
							'type' 				=> 'number',
							'min'				=> 0,
							'pattern' 			=> '\d*',
						)
					),
					array(
						'id'                => REALIA_PROPERTY_PREFIX . 'beds',
						'name'              => __( 'Beds', 'realia' ),
						'type'              => 'text',
						'attributes' 	    => array(
							'type' 				=> 'number',
							'min'				=> 0,
							'pattern' 			=> '\d*',
						)
					),
					array(
						'id'                => REALIA_PROPERTY_PREFIX . 'baths',
						'name'              => __( 'Baths', 'realia' ),
						'type'              => 'text',
						'attributes' 	    => array(
							'type' 				=> 'number',
							'step'				=> 'any',
							'min'				=> 0,
							'pattern'			=> '\d*(\.\d*)?',
						)
					),
					array(
						'id'                => REALIA_PROPERTY_PREFIX . 'garages',
						'name'              => __( 'Garages', 'realia' ),
						'type'              => 'text',
						'attributes' 	    => array(
							'type' 				=> 'number',
							'min'				=> 0,
							'pattern' 			=> '\d*',
						)
					),
					array(
						'id'                => REALIA_PROPERTY_PREFIX . 'home_area',
						'name'              => __( 'Home area', 'realia' ),
						'type'              => 'text',
						'description'       => get_theme_mod( 'realia_measurement_area_unit', 'sqft' ),
						'attributes'		=> array(
							'type'				=> 'number',
							'step'				=> 'any',
							'min'				=> 0,
							'pattern'			=> '\d*(\.\d*)?',
						)
					),
					array(
						'id'                => REALIA_PROPERTY_PREFIX . 'lot_dimensions',
						'name'              => __( 'Lot dimensions', 'realia' ),
						'type'              => 'text',
						'description'       => __( 'e.g. 20x30, 20x30x40, 20x30x40x50', 'realia' ),
					),
					array(
						'id'                => REALIA_PROPERTY_PREFIX . 'lot_area',
						'name'              => __( 'Lot area', 'realia' ),
						'type'              => 'text',
						'description'       => get_theme_mod( 'realia_measurement_area_unit', 'sqft' ),
						'attributes'		=> array(
							'type'				=> 'number',
							'step'				=> 'any',
							'min'				=> 0,
							'pattern'			=> '\d*(\.\d*)?',
						)
					),
					array(
						'name'              => __( 'Contract', 'realia' ),
						'id'                => REALIA_PROPERTY_PREFIX . 'contract',
						'type'              => 'select',
						'options'           => self::contract_options()
					),
					array(
						'name'              => __( 'Floor Plans', 'realia' ),
						'id'                => REALIA_PROPERTY_PREFIX . 'plans',
						'type'              => 'file_list',
					),
					array(
						'name'              => __( 'Video link', 'realia' ),
						'id'                => REALIA_PROPERTY_PREFIX . 'video',
						'type'              => 'text',
						'description'       => __( 'For more information about embeding videos and video links support please read this <a href="http://codex.wordpress.org/Embeds">article</a>.', 'realia' ),
					),
					array(
						'name'              => __( 'Contact name', 'realia' ),
						'description'       => __( 'Owner, agent or Agency', 'realia' ),
						'id'                => REALIA_PROPERTY_PREFIX . 'contact_name',
						'type'              => 'text',
					),
					array(
						'name'              => __( 'Contact phone', 'realia' ),
						'description'       => __( 'Phone number', 'realia' ),
						'id'                => REALIA_PROPERTY_PREFIX . 'contact_phone',
						'type'              => 'text',
					),
					array(
						'id'                => REALIA_PROPERTY_PREFIX . 'map_location',
						'name'              => __( 'Location', 'realia' ),
						'type'              => 'pw_map',
						'sanitization_cb'   => 'pw_map_sanitise',
						'split_values'      => true,
					),
					array(
						'name'      		=> __( 'Locations', 'realia' ),
						'id'        		=> REALIA_PROPERTY_PREFIX . 'location',
						'type'      		=> 'taxonomy_multicheck',
						'taxonomy'  		=> 'locations',
					),
					array(
						'name'      		=> __( 'Statuses', 'realia' ),
						'id'        		=> REALIA_PROPERTY_PREFIX . 'status',
						'type'      		=> 'taxonomy_multicheck',
						'taxonomy'  		=> 'statuses',
					),
					array(
						'name'      		=> __( 'Types', 'realia' ),
						'id'        		=> REALIA_PROPERTY_PREFIX . 'type',
						'type'      		=> 'taxonomy_multicheck',
						'taxonomy'  		=> 'property_types',
					),
					array(
						'name'      		=> __( 'Materials', 'realia' ),
						'id'        		=> REALIA_PROPERTY_PREFIX . 'material',
						'type'      		=> 'taxonomy_multicheck',
						'taxonomy'  		=> 'materials',
					),
					array(
						'name'      		=> __( 'Amenities', 'realia' ),
						'id'        		=> REALIA_PROPERTY_PREFIX . 'amenity',
						'type'      		=> 'taxonomy_multicheck',
						'taxonomy'  		=> 'amenities',
					),
					array(
						'name'      		=> __( 'Parent property', 'realia' ),
						'desc'      		=> __( 'Useful for types like Condominium', 'realia' ),
						'id'        		=> REALIA_PROPERTY_PREFIX . 'parent_property',
						'type'      		=> 'select',
						'show_option_none' 	=> true,
						'options'          	=> Realia_Post_Type_Property::get_property_choices( get_current_user_id() ),
						'attributes' 	    => array(
							'type' 				=> 'number',
							'pattern' 			=> '\d*',
						)
					),
					array(
						'name'              => __( 'Public facilities', 'realia' ),
						'object_types'      => array( 'property' ),
						'id'                => REALIA_PROPERTY_PREFIX . 'public_facilities_group',
						'type'              => 'group',
						'fields'            => array(
							array(
								'id'                => REALIA_PROPERTY_PREFIX . 'public_facilities_key',
								'name'              => __( 'Key', 'realia' ),
								'type'              => 'text',
							),
							array(
								'id'                => REALIA_PROPERTY_PREFIX . 'public_facilities_value',
								'name'              => __( 'Value', 'realia' ),
								'type'              => 'text',
							)
						)
					),
					array(
						'name'              => __( 'Valuation', 'realia' ),
						'object_types'      => array( 'property' ),
						'id'                => REALIA_PROPERTY_PREFIX . 'valuation_group',
						'type'              => 'group',
						'fields'            => array(
							array(
								'id'                => REALIA_PROPERTY_PREFIX . 'valuation_key',
								'name'              => __( 'Key', 'realia' ),
								'type'              => 'text',
							),
							array(
								'id'                => REALIA_PROPERTY_PREFIX . 'valuation_value',
								'name'              => __( 'Value', 'realia' ),
								'type'              => 'text',
								'attributes' 	    => array(
									'type' 				=> 'number',
									'min'				=> 0,
									'pattern' 			=> '\d*',
								)
							)
						)
					),
				),
			);
		}
		return $metaboxes;
	}

	/**
	 * Custom admin columns for post type
	 *
	 * @access public
	 * @return array
	 */
	public static function custom_columns() {
		$fields = array(
			'cb' 				=> '<input type="checkbox" />',
			'title' 			=> __( 'Title', 'realia' ),
			'thumbnail' 		=> __( 'Thumbnail', 'realia' ),
			'price' 			=> __( 'Price', 'realia' ),
			'location' 			=> __( 'Location', 'realia' ),
			'type' 				=> __( 'Type', 'realia' ),
			'status' 			=> __( 'Status', 'realia' ),
			'sticky'            => __( 'TOP', 'realia' ),
			'featured' 			=> __( 'Featured', 'realia' ),
			'reduced' 			=> __( 'Reduced', 'realia' ),
			'author' 			=> __( 'Author', 'realia' ),
		);

		if ( 'pay-per-post' == get_theme_mod( 'realia_submission_type' ) ) {
			$fields['paid'] = __( 'Paid', 'realia' );
		}

		return $fields;
	}

	/**
	 * Custom admin columns implementation
	 *
	 * @access public
	 * @param string $column
	 * @return array
	 */
	public static function custom_columns_manage( $column ) {
		switch ( $column ) {
			case 'thumbnail':
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'thumbnail', array(
						'class' => 'attachment-thumbnail attachment-thumbnail-small',
					) );
				} else {
					echo '-';
				}
				break;
			case 'price':
				$price = Realia_Price::get_property_price( get_the_ID() );
				if ( ! empty( $price ) ) {
					echo wp_kses( $price, wp_kses_allowed_html( 'post' ) );
				} else {
					echo '-';
				}
				break;
			case 'location':
				$terms = get_the_terms( get_the_ID(), 'locations' );
				if ( ! empty( $terms ) ) {
					$location = array_shift( $terms );
					echo sprintf( '<a href="?post_type=property&location=%s">%s</a>', $location->slug, $location->name );
				} else {
					echo '-';
				}
				break;
			case 'type':
				$terms = get_the_terms( get_the_ID(), 'property_types' );
				if ( is_array( $terms ) ) {
					$property_type = array_shift( $terms );
					echo sprintf( '<a href="?post_type=property&property_type=%s">%s</a>', $property_type->slug, $property_type->name );
				} else {
					echo '-';
				}
				break;
			case 'status':
				$terms = get_the_terms( get_the_ID(), 'statuses' );
				if ( ! empty( $terms ) ) {
					$status_type = array_shift( $terms );
					echo sprintf( '<a href="?post_type=property&status=%s">%s</a>', $status_type->slug, $status_type->name );
				} else {
					echo '-';
				}
				break;
			case 'material':
				$terms = get_the_terms( get_the_ID(), 'materials' );
				if ( ! empty( $terms ) ) {
					$material = array_shift( $terms );
					echo sprintf( '<a href="?post_type=property&material=%s">%s</a>', $material->slug, $material->name );
				} else {
					echo '-';
				}
				break;
			case 'sticky':
				$sticky = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'sticky', true );

				if ( ! empty( $sticky ) ) {
					echo '<div class="dashicons-before dashicons-yes green"></div>';
				} else {
					echo '<div class="dashicons-before dashicons-no red"></div>';
				}
				break;
			case 'featured':
				$featured = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'featured', true );

				if ( ! empty( $featured ) ) {
					echo '<div class="dashicons-before dashicons-yes green"></div>';
				} else {
					echo '<div class="dashicons-before dashicons-no red"></div>';
				}
				break;
			case 'reduced':
				$featured = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'reduced', true );

				if ( ! empty( $featured ) ) {
					echo '<div class="dashicons-before dashicons-yes green"></div>';
				} else {
					echo '<div class="dashicons-before dashicons-no red"></div>';
				}
				break;
			case 'paid':
				$paid = Realia_Query::is_property_paid();

				if ( $paid ) {
					echo '<div class="dashicons-before dashicons-yes green"></div>';
				} else {
					echo '<div class="dashicons-before dashicons-no red"></div>';
				}

				break;
		}
	}

	/**
	 * Process enquire form
	 *
	 * @access public
	 * @return void
	 */
	public static function process_enquire_form() {
		if ( ! isset( $_POST['enquire_form'] ) || empty( $_POST['post_id'] ) ) {
			return;
		}

		$post_id = intval( $_POST['post_id'] );

		if ( ! $post_id ) {
			return;
		}

		$post = get_post( $post_id );
		$email = sanitize_email( $_POST['email'] );
		$phone = sanitize_text_field( $_POST['phone'] );
		$name = sanitize_text_field( $_POST['name'] );

		$subject = __( 'Message from enquire form', 'realia' );
		$headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $name, $email );

		$is_recaptcha = Realia_Recaptcha::is_recaptcha_enabled();
		$is_recaptcha_valid = array_key_exists( 'g-recaptcha-response', $_POST ) ? Realia_Recaptcha::is_recaptcha_valid( sanitize_text_field( $_POST['g-recaptcha-response'] ) ) : false;

		if ( $is_recaptcha && ! $is_recaptcha_valid ) {
			$_SESSION['messages'][] = array( 'danger', __( 'CAPTCHA is not valid.', 'realia' ) );
			return;
		}

		ob_start();
		include Realia_Template_Loader::locate( 'mails/enquire' );
		$message = ob_get_contents();
		ob_end_clean();

		$emails = array();

		// Author
		if ( ! empty( $_POST['receive_author'] ) ) {
			$emails[] = get_the_author_meta( 'user_email', $post->post_author );
		}

		// Admin
		if ( ! empty( $_POST['receive_admin'] ) ) {
			$emails[] = get_bloginfo( 'admin_email' );
		}

		// Agent
		if ( ! empty( $_POST['receive_agent'] ) ) {
			$agents = Realia_Query::get_property_agents( $post->ID );
			if ( is_array( $agents ) && count( $agents ) > 0 ) {
				foreach ( $agents as $agent_id ) {
					$email = get_post_meta( $agent_id, REALIA_AGENT_PREFIX . 'email', true );

					if ( ! empty( $email ) ) {
						$emails[] = $email;
					}
				}
			}
		}

		// Default fallback
		if ( empty( $_POST['receive_admin'] ) && empty( $_POST['receive_agent'] ) && empty( $_POST['receive_author'] ) ) {
			$emails[] = get_the_author_meta( 'user_email', $post->post_author );
		}

		$emails = array_unique( $emails );

		foreach ( $emails as $email ) {
			$status = wp_mail( $email, $subject, $message, $headers );
		}

		if ( ! empty( $status ) && 1 == $status ) {
			$_SESSION['messages'][] = array( 'success', __( 'Message has been successfully sent.', 'realia' ) );
		} else {
			$_SESSION['messages'][] = array( 'danger', __( 'Unable to send a message.', 'realia' ) );
		}
	}

	/**
	 * Process property form - front end submission
	 *
	 * @access public
	 * @return void
	 */
	public static function process_property_form() {
		if ( ! isset( $_POST['submit-cmb'] ) && ! empty( $_POST['post_type'] ) && 'property' == $_POST['post_type'] ) {
			return;
		}

		// Setup and sanitize data
		if ( isset( $_POST[ REALIA_PROPERTY_PREFIX . 'title' ] ) ) {
			$post_id = ! empty( $_GET['id'] ) ? $_GET['id'] : false;

			$review_before = get_theme_mod( 'realia_submission_review_before', false );
			$post_status = 'publish';

			if ( $review_before && get_post_status( $post_id ) != 'publish' ) {
				$post_status = 'pending';
			}

			// If we are updating the post get old one. We need old post to set proper
			// post_date value because just modified post will at the top in archive pages.
			if ( ! empty( $post_id ) ) {
				$old_post = get_post( $post_id );
				$post_date = $old_post->post_date;
			} else {
				$post_date = '';
			}

			$data = array(
				'post_title'     => sanitize_text_field( $_POST[ REALIA_PROPERTY_PREFIX . 'title' ] ),
				'post_author'    => get_current_user_id(),
				'post_status'    => $post_status,
				'post_type'      => 'property',
				'post_date'      => $post_date,
				'post_content'   => wp_kses( $_POST[ REALIA_PROPERTY_PREFIX . 'text' ], '<b><strong><i><em><h1><h2><h3><h4><h5><h6><pre><code><span>' ),
			);

			if ( ! empty( $post_id ) ) {
				$data['ID'] = $post_id;
			}

			$new_post = empty( $post_id );

			$post_id = wp_insert_post( $data, true );
			$agent_id = Realia_Query::get_current_user_assigned_agent_id();

			if ( ! empty( $agent_id ) ) {
				Realia_Query::set_property_agent( $post_id, $agent_id );
			}

			if ( ! empty( $post_id ) && ! empty( $_POST['object_id'] ) ) {
				$_POST['object_id'] = $post_id; // object_id in POST contains page ID instead of property ID

				$metaboxes = apply_filters( 'cmb2_meta_boxes', array() );
				cmb2_get_metabox_form( $metaboxes[ REALIA_PROPERTY_PREFIX . 'front' ], $post_id );

				// Create featured image
				$featured_image = get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'featured_image', true );
				if ( ! empty( $_POST[ REALIA_PROPERTY_PREFIX . 'featured_image' ] ) ) {
					$featured_image_id = get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'featured_image_id', true );
					set_post_thumbnail( $post_id, $featured_image_id );
				} else {
					update_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'featured_image', null );
					delete_post_thumbnail( $post_id );
				}

				if( $new_post ) {
					$_SESSION['messages'][] = array( 'success', __( 'Property has been successfully created.', 'realia' ) );
				} else {
					$_SESSION['messages'][] = array( 'success', __( 'Property has been successfully updated.', 'realia' ) );
				}
			}

			$redirect_url = get_permalink( get_theme_mod( 'realia_submission_list_page' ) );
			if ( ! $redirect_url ) {
				$redirect_url = '/';
			}

			wp_redirect( $redirect_url );
			exit();
		}

		return;
	}

	/**
	 * Adding query variable
	 *
	 * @param $vars
	 * @return array
	 */
	public static function add_query_vars( $vars ) {
		$vars[] = 'properties-feed';
		return $vars;
	}

	/**
	 * Catch template and render JSON output
	 *
	 * @access public
	 * @return string
	 */
	public static function catch_template() {
		if ( get_query_var( 'properties-feed' ) ) {
			header( 'HTTP/1.0 200 OK' );
			header( 'Content-Type: application/json' );

			$property_groups = array();
			$data = array();

			Realia_Query::loop_properties_all();
			Realia_Query::loop_properties_filter();

			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					// Property GPS positions. We will use these values
					// for genearating unique md5 hash for property groups.
					$latitude = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'map_location_latitude', true );
					$longitude = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'map_location_longitude', true );

					// Build on array of property groups. We need to know how
					// many and which properties are at the same position.
					if ( ! empty( $latitude ) && ! empty( $longitude ) ) {
						$hash = sha1( $latitude . $longitude );
						$property_groups[ $hash ][] = get_the_ID();

					}
				}
			}
			wp_reset_query();

			foreach ( $property_groups as $group ) {
				$args = array(
					'post_type'         => 'property',
					'posts_per_page'    => -1,
					'post_status'       => 'publish',
					'post__in'          => $group,
				);

				query_posts( $args );
				if ( have_posts() ) {
					// Group of properties at the same position so we will process
					// property loop inside the template.
					if ( count( $group ) > 1 ) {
						$latitude = get_post_meta( $group[0], REALIA_PROPERTY_PREFIX . 'map_location_latitude', true );
						$longitude = get_post_meta( $group[0], REALIA_PROPERTY_PREFIX . 'map_location_longitude', true );

						// Marker
						ob_start();
						$template = Realia_Template_Loader::locate( 'misc/google-map-infowindow-group' );
						include( $template );
						$output = ob_get_contents();
						ob_end_clean();

						$content = str_replace( array( "\r\n", "\n", "\t" ), '', $output );

						// Infowindow
						ob_start();
						$template = Realia_Template_Loader::locate( 'misc/google-map-marker-group' );
						include( $template );
						$output = ob_get_contents();
						ob_end_clean();

						$marker_content = str_replace( array( "\r\n", "\n", "\t" ), '', $output );
						// Just one property. We can get current post here.
					} else {
						the_post();
						$latitude = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'map_location_latitude', true );
						$longitude = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'map_location_longitude', true );

						$content = str_replace( array( "\r\n", "\n", "\t" ), '', Realia_Template_Loader::load( 'misc/google-map-infowindow' ) );
						$marker_content = str_replace( array( "\r\n", "\n", "\t" ), '', Realia_Template_Loader::load( 'misc/google-map-marker' ) );
					}

					// Array of values passed into markers[] array in jquery-google-map.js library
					$data[] = array(
						'latitude'          => $latitude,
						'longitude'         => $longitude,
						'content'           => $content,
						'marker_content'    => $marker_content,
					);
				}

				wp_reset_query();
			}

			echo json_encode( $data );
			exit();
		}
	}

	/**
	 * Returns user properties
	 *
	 * @access public
	 * @param $user_id
	 * @param $status
	 * @param $parent_property_id
	 * @return array
	 */
	public static function get_properties( $user_id = null, $status = 'any', $parent_property_id = null ) {
		$args = array(
			'post_type'     	=> 'property',
			'post_status'   	=> $status,
			'posts_per_page' 	=> -1,
		);

		if ( $user_id ) {
			$args['author'] = $user_id;
		}

		if ( $parent_property_id ) {
			$args['meta_key'] = REALIA_PROPERTY_PREFIX . 'parent_property';
			$args['meta_value'] = $parent_property_id;
		}

		$query = new WP_Query( $args );

		return $query->get_posts();
	}

	/**
	 * Returns ids of properties and their titles
	 *
	 * @access public
	 * @return array
	 */
	public static function get_property_choices( $user_id = null ) {
		$choices = array();
		$properties = self::get_properties( $user_id );

		if( is_array( $properties ) ) {
			foreach ( $properties as $property) {
				$choices[ $property->ID ] = $property->post_title;
			}
		}
		return $choices;
	}
}

Realia_Post_Type_Property::init();
