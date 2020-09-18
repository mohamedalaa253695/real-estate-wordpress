<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Realia_Filter
 *
 * @class Realia_Filter
 * @package Realia/Classes
 * @author Pragmatic Mates
 */
class Realia_Filter {
	/**
	 * Initialize filtering
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_filter( 'realia_filter_fields', array( __CLASS__, 'default_fields' ) );
		add_filter( 'realia_filter_field_names', array( __CLASS__, 'default_field_names' ) );

		add_action( 'pre_get_posts', array( __CLASS__, 'archive' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'taxonomy' ) );
	    add_action( 'realia_before_property_archive', array( __CLASS__, 'sort_template' ) );
		add_action( 'wp_ajax_nopriv_realia_select_chain_location_options', array( __CLASS__, 'location_ajax_options' ) );
		add_action( 'wp_ajax_realia_select_chain_location_options', array( __CLASS__, 'location_ajax_options' ) );
	}

	/**
	 * Gets sort template
	 *
	 * @access public
	 * @return void
	 * @throws Exception
	 */
	public static function sort_template() {
		if ( is_post_type_archive( array( 'property' ) ) ) {
			include Realia_Template_Loader::locate( 'properties/sort' );
		}
	}

	/**
	 * List of default fields defined by plugin
	 *
	 * @access public
	 * @return array
	 */
	public static function default_fields() {
		return array(
			'property_title'	=> __( 'Property title', 'realia' ),
			'id'            	=> __( 'Property ID', 'realia' ),
			'location'      	=> __( 'Location', 'realia' ),
			'property_type' 	=> __( 'Property type', 'realia' ),
			'amenity'       	=> __( 'Amenity', 'realia' ),
			'status'        	=> __( 'Status', 'realia' ),
			'contract'      	=> __( 'Contract', 'realia' ),
			'material'      	=> __( 'Material', 'realia' ),
			'price'         	=> __( 'Price', 'realia' ),
			'rooms'         	=> __( 'Rooms', 'realia' ),
			'baths'         	=> __( 'Baths', 'realia' ),
			'beds'          	=> __( 'Beds', 'realia' ),
			'year_built'    	=> __( 'Year built', 'realia' ),
			'home_area'     	=> __( 'Home area', 'realia' ),
			'lot_area'      	=> __( 'Lot area', 'realia' ),
			'garages'       	=> __( 'Garages', 'realia' ),
			'featured'      	=> __( 'Featured', 'realia' ),
			'reduced'       	=> __( 'Reduced', 'realia' ),
			'sticky'        	=> __( 'Sticky', 'realia' ),
			'sold'          	=> __( 'Sold', 'realia' ),
		);
	}

	/**
	 * Returns list of available filter fields templates
	 *
	 * @access public
	 * @return array
	 */
	public static function get_fields() {
		return apply_filters( 'realia_filter_fields', array() );
	}

	/**
	 * Default filter field names
	 *
	 * @access public
	 * @return array
	 */
	public static function default_field_names() {
		return array(
			'filter-property-title',
			'filter-id',
			'filter-location',
			'filter-property-type',
			'filter-amenity',
			'filter-status',
			'filter-contract',
			'filter-material',
			'filter-price-from',
			'filter-price-to',
			'filter-rooms',
			'filter-baths',
			'filter-beds',
			'filter-year-built',
			'filter-home-area-from',
			'filter-home-area-to',
			'filter-garages',
			'filter-featured',
			'filter-reduced',
			'filter-sticky',
			'filter-sold',
			'filter-lot-area-from',
			'filter-lot-area-to',
		);
	}

	/**
	 * Return all filter field names
	 *
	 * @access public
	 * @return array
	 */
	public static function get_field_names() {
		return apply_filters( 'realia_filter_field_names', array() );
	}

	/**
	 * Checks if in URI are filter conditions
	 *
	 * @access public
	 * @return bool
	 */
	public static function has_filter() {
		if ( ! empty( $_GET ) && is_array( $_GET ) ) {
			foreach ( $_GET as $key => $value ) {
				if ( strrpos( $key, 'filter-', -strlen( $key ) ) !== false ) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * When accessing taxonomy page order properties by sticky
	 *
	 * @access public
	 * @param $query
	 * @return array
	 */
	public static function taxonomy( $query ) {
		$is_correct_taxonomy = false;
		if ( is_tax( 'statuses' ) || is_tax( 'property_types' ) || is_tax( 'amenities' ) || is_tax( 'locations' ) || is_tax( 'materials' ) ) {
			$is_correct_taxonomy = true;
		}

		if ( ! $is_correct_taxonomy  || ! $query->is_main_query() || is_admin() ) {
			return;
		}

		if ( ! empty( $_GET['filter-sort-order'] ) ) {
			$query->set( 'order', $_GET['filter-sort-order'] );
		}

		if ( ! empty( $_GET['filter-sort-by'] ) ) {
			switch ( $_GET['filter-sort-by'] ) {
				case 'title':
					$query->set( 'orderby', 'title' );
					break;
				case 'published':
					$query->set( 'orderby', 'date' );
					break;
				case 'price':
					$query->set( 'meta_key', REALIA_PROPERTY_PREFIX . 'price' );
					$query->set( 'orderby', 'meta_value_num' );
					break;
			}
		} else {
			if ( ! self::has_filter() ) {
				// TODO: WP 4.2 order by multiple custom fields
				// We need this filter to have sticky at the top of posts
				// https://core.trac.wordpress.org/ticket/19653
				$query->set( 'order', 'DESC' );
				$query->set( 'orderby', 'meta_value date' );
				$query->set( 'meta_key', REALIA_PROPERTY_PREFIX . 'sticky' );
				add_filter( 'get_meta_sql', array( __CLASS__, 'filter_get_meta_sql_19653' ) );
			}
		}

		return self::filter_query( $query );
	}


	/**
	 * Filter properties on archive page
	 *
	 * @access public
	 * @param $query
	 * @return void
	 */
	public static function archive( $query ) {
		$suppress_filters = ! empty( $query->query_vars['suppress_filters'] ) ? $query->query_vars['suppress_filters'] : '';

		if ( ! is_post_type_archive( 'property' ) || ! $query->is_main_query() || is_admin() || $query->query_vars['post_type'] != 'property' || $suppress_filters ) {
			return;
		}

		if ( ! empty( $_GET['filter-sort-order'] ) ) {
			$query->set( 'order', $_GET['filter-sort-order'] );
		}

		if ( ! empty( $_GET['filter-sort-by'] ) ) {
			switch ( $_GET['filter-sort-by'] ) {
				case 'title':
					$query->set( 'orderby', 'title' );
					break;
				case 'published':
					$query->set( 'orderby', 'date' );
					break;
				case 'price':
					$query->set( 'meta_key', REALIA_PROPERTY_PREFIX . 'price' );
					$query->set( 'orderby', 'meta_value_num' );
					break;
			}
		} else {
			if ( ! self::has_filter() ) {
				// TODO: WP 4.2 order by multiple custom fields
				// We need this filter to have sticky at the top of posts
				// https://core.trac.wordpress.org/ticket/19653
				$query->set( 'order', 'DESC' );
				$query->set( 'orderby', 'meta_value date' );
				$query->set( 'meta_key', REALIA_PROPERTY_PREFIX . 'sticky' );
				add_filter( 'get_meta_sql', array( __CLASS__, 'filter_get_meta_sql_19653' ) );
			}
		}

		return self::filter_query( $query );
	}


	/**
	 * Add params into query object
	 *
	 * @access public
	 * @param $query
	 * @param $params
	 * @return mixed
	 */
	public static function filter_query( $query = null, $params = array() ) {
		global $wpdb;
		global $wp_query;

		if ( empty( $query ) ) {
			$query = $wp_query;
		}

		if ( empty( $params ) ) {
			$params = $_GET;
		}

		// Filter params
		$params = apply_filters( 'realia_filter_params', $params );

		// Initialize variables
		$meta = array();
		$taxonomies = array();
		$ids = null;

		// Property title
		if ( ! empty( $params['filter-property-title'] ) ) {
			$title_ids = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT ID FROM {$wpdb->posts} WHERE post_status = \"publish\" AND post_title LIKE '%s'", '%' . esc_attr( $_GET['filter-property-title'] ) . '%' ) );
			$ids = self::build_post_ids( $ids, $title_ids );
		}

		// Location
		if ( 'single-select' == get_theme_mod( 'realia_filter_location_field_type', 'single-select' ) ) {
			if ( ! empty( $params[ 'filter-location' ] ) ) {
				$location_id = esc_attr( $params['filter-location'] );
			}
		} else {
			foreach( array( 'subsub', 'sub', '' ) as $location_depth ) {
				$location_filter_param = 'filter-' . $location_depth . 'location';

				if ( ! empty( $params[ $location_filter_param ] ) ) {
					$location_id = esc_attr( $params[ $location_filter_param ] ) ;
					break;
				}
			}
		}

		if ( ! empty( $location_id ) ) {
			$taxonomies[] = array(
				'taxonomy'  => 'locations',
				'field'     => 'id',
				'terms'     => $location_id,
			);
		}

	    // Search by distance
	    if ( ! empty( $params['filter-center-latitude'] ) && ! empty( $params['filter-center-longitude'] ) && ! empty( $params['filter-distance'] ) ) {
		    $properties = self::filter_by_distance( $params['filter-center-latitude'], $params['filter-center-longitude'], $params['filter-distance'] );

			$distance_ids = array();
		    foreach ( $properties as $property ) {
				$distance_ids[] = $property->ID;
		    }

			$ids = self::build_post_ids( $ids, $distance_ids );
	    }

		// Property type
		if ( ! empty( $params['filter-property-type'] ) ) {
			$taxonomies[] = array(
				'taxonomy'  => 'property_types',
				'field'     => 'id',
				'terms'     => $params['filter-property-type'],
			);
		}

	    // Amenity
	    if ( ! empty( $params['filter-amenity'] ) ) {
		    $taxonomies[] = array(
			    'taxonomy'  => 'amenities',
			    'field'     => 'id',
			    'terms'     => $params['filter-amenity'],
		    );
	    }

		// Status
		if ( ! empty( $params['filter-status'] ) ) {
			$taxonomies[] = array(
				'taxonomy'  => 'statuses',
				'field'     => 'id',
				'terms'     => $params['filter-status'],
			);
		}

	    // Material
	    if ( ! empty( $params['filter-material'] ) ) {
		    $taxonomies[] = array(
			    'taxonomy'  => 'materials',
			    'field'     => 'id',
			    'terms'     => $params['filter-material'],
		    );
	    }

	    // Property contract
	    if ( ! empty( $params['filter-contract'] ) ) {
		    $meta[] = array(
			    'key'       => REALIA_PROPERTY_PREFIX . 'contract',
			    'value'     => $params['filter-contract'],
			    'compare'   => '==',
		    );
	    }

	    // Featured
	    if ( ! empty( $params['filter-featured'] ) ) {
		    $meta[] = array(
			    'key'       => REALIA_PROPERTY_PREFIX . 'featured',
			    'value'     => 'on',
			    'compare'   => '==',
		    );
	    }

	    // Reduced
	    if ( ! empty( $params['filter-reduced'] ) ) {
		    $meta[] = array(
			    'key'       => REALIA_PROPERTY_PREFIX . 'reduced',
			    'value'     => 'on',
			    'compare'   => '==',
		    );
	    }

	    // Sticky
	    if ( ! empty( $params['filter-sticky'] ) ) {
		    $meta[] = array(
			    'key'       => REALIA_PROPERTY_PREFIX . 'sticky',
			    'value'     => 'on',
			    'compare'   => '==',
		    );
	    }

	    // Sold
	    if ( ! empty( $params['filter-sold'] ) ) {
		    $meta[] = array(
			    'key'       => REALIA_PROPERTY_PREFIX . 'sold',
			    'value'     => 'on',
			    'compare'   => '==',
		    );
	    }

		// Property ID
		if ( ! empty( $params['filter-id'] ) ) {
			$meta[] = array(
				'key'       => REALIA_PROPERTY_PREFIX . 'id',
				'value'     => $params['filter-id'],
				'compare'   => 'LIKE',
			);
		}

		// Price from
		if ( ! empty( $params['filter-price-from'] ) ) {
			$meta[] = array(
				'key'       => REALIA_PROPERTY_PREFIX . 'price',
				'value'     => $params['filter-price-from'],
				'compare'   => '>=',
				'type'      => 'NUMERIC',
			);
		}

		// Price to
		if ( ! empty( $params['filter-price-to'] ) ) {
			$meta[] = array(
				'key'       => REALIA_PROPERTY_PREFIX . 'price',
				'value'     => $params['filter-price-to'],
				'compare'   => '<=',
				'type'      => 'NUMERIC',
			);
		}

	    // Contract
	    if ( ! empty( $params['filter-contract'] ) ) {
		    $meta[] = array(
			    'key'       => REALIA_PROPERTY_PREFIX . 'contract',
			    'value'     => $params['filter-contract'],
		    );
	    }

	    // Rooms
	    if ( ! empty( $params['filter-rooms'] ) ) {
		    $meta[] = array(
			    'key'       => REALIA_PROPERTY_PREFIX . 'rooms',
			    'value'     => $params['filter-rooms'],
			    'compare'   => '>=',
			    'type'      => 'NUMERIC',
		    );
	    }

		// Beds
		if ( ! empty( $params['filter-beds'] ) ) {
			$meta[] = array(
				'key'       => REALIA_PROPERTY_PREFIX . 'beds',
				'value'     => $params['filter-beds'],
				'compare'   => '>=',
				'type'      => 'NUMERIC',
			);
		}

	    // Year built
	    if ( ! empty( $params['filter-year-built'] ) ) {
		    $meta[] = array(
			    'key'       => REALIA_PROPERTY_PREFIX . 'year_built',
			    'value'     => $params['filter-year-built'],
			    'compare'   => '>=',
			    'type'      => 'NUMERIC',
		    );
	    }

		// Baths
		if ( ! empty( $params['filter-baths'] ) ) {
			$meta[] = array(
				'key'       => REALIA_PROPERTY_PREFIX . 'baths',
				'value'     => $params['filter-baths'],
				'compare'   => '>=',
				'type'      => 'NUMERIC',
			);
		}

		// Home area from
		if ( ! empty( $params['filter-home-area-from'] ) ) {
			$meta[] = array(
				'key'       => REALIA_PROPERTY_PREFIX . 'home_area',
				'value'     => $params['filter-home-area-from'],
				'compare'   => '>=',
				'type'      => 'NUMERIC',
			);
		}

	    // Home area to
	    if ( ! empty( $params['filter-home-area-to'] ) ) {
		    $meta[] = array(
			    'key'       => REALIA_PROPERTY_PREFIX . 'home_area',
			    'value'     => $params['filter-home-area-to'],
			    'compare'   => '<=',
			    'type'      => 'NUMERIC',
		    );
	    }

	    // Lot area from
	    if ( ! empty( $params['filter-lot-area-from'] ) ) {
		    $meta[] = array(
			    'key'       => REALIA_PROPERTY_PREFIX . 'lot_area',
			    'value'     => $params['filter-lot-area-from'],
			    'compare'   => '>=',
			    'type'      => 'NUMERIC',
		    );
	    }

	    // Lot area to
	    if ( ! empty( $params['filter-lot-area-to'] ) ) {
		    $meta[] = array(
			    'key'       => REALIA_PROPERTY_PREFIX . 'lot_area',
			    'value'     => $params['filter-lot-area-to'],
			    'compare'   => '<=',
			    'type'      => 'NUMERIC',
		    );
	    }

		// Garages
		if ( ! empty( $params['filter-garages'] ) ) {
			$meta[] = array(
				'key'       => REALIA_PROPERTY_PREFIX . 'garages',
				'value'     => $params['filter-garages'],
				'compare'   => '>=',
				'type'      => 'NUMERIC',
			);
		}

		// Post IDs
		if ( is_array( $ids ) ) {
			if ( count( $ids ) > 0 ) {
				if ( ! empty ( $params['count'] ) && count ( $params['count'] ) >= 0 ) {
					$ids = array_slice( $ids, 0, $params['count'] );
				}
				$query->set( 'post__in', $ids );
			} else {
				$query->set( 'post__in', array( 0 ) );
			}
		}

		// Exclude subproperties
		$subproperties_ids = $wpdb->get_col( "SELECT DISTINCT post_id FROM {$wpdb->postmeta} WHERE meta_key = \"" . REALIA_PROPERTY_PREFIX . "parent_property\" AND meta_value != '';" );

		if ( count( $subproperties_ids ) ) {
			$query->set( 'post__not_in', $subproperties_ids );
		}

		// Meta query, tax query
		$query->set( 'meta_query', $meta );
		$query->set( 'tax_query', $taxonomies );
		return $query;
	}

	/**
	 * Helper method to build an array of post ids
	 *
	 * Purpose is to build proper array of post ids which will be used in WP_Query. For certain queries we need
	 * an array for post__in so we have to make array intersect, new array or just return null (post__in is not required).
	 *
	 * @access public
	 * @param null|array $haystack
	 * @param array $ids
	 * @return null|array
	 */
	public static function build_post_ids( $haystack, array $ids ) {
		if ( ! is_array( $haystack ) ) {
			$haystack = array();
		}

		if ( is_array( $haystack ) && count( $haystack ) > 0 ) {
			return array_intersect( $haystack, $ids );
		} else {
			$haystack = $ids;
		}

		return $haystack;
	}

	/**
	 * Tweak for displaying sticky posts at the top
	 *
	 * @access public
	 * @param $clauses
	 * @return mixed
	 */
	public static function filter_get_meta_sql_19653( $clauses ) {
		remove_filter( 'get_meta_sql', array( __CLASS__, 'filter_get_meta_sql_19653' ) );

		// Change the inner join to a left join,
		// and change the where so it is applied to the join, not the results of the query.
		$clauses['join']  = str_replace( 'INNER JOIN', 'LEFT JOIN', $clauses['join'] ) . $clauses['where'];
		$clauses['where'] = '';

		return $clauses;
	}

	/**
	 * Find properties by GPS position matching the distance
	 *
	 * @access public
	 * @param $latitude
	 * @param $longitude
	 * @param $distance
	 *
	 * @return mixed
	 */
	public static function filter_by_distance($latitude, $longitude, $distance) {
		global $wpdb;

		$sql = 'SELECT SQL_CALC_FOUND_ROWS ID, ( 3959 * acos( cos( radians(' . $latitude . ') ) * cos(radians( latitude.meta_value ) ) * cos( radians( longitude.meta_value ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitude.meta_value ) ) ) ) AS distance
    				FROM ' . $wpdb->prefix . 'posts
                    INNER JOIN ' . $wpdb->prefix . 'postmeta ON (' . $wpdb->prefix . 'posts.ID = ' . $wpdb->prefix . 'postmeta.post_id)
                    INNER JOIN ' . $wpdb->prefix . 'postmeta AS latitude ON ' . $wpdb->prefix . 'posts.ID = latitude.post_id
                    INNER JOIN ' . $wpdb->prefix . 'postmeta AS longitude ON ' . $wpdb->prefix . 'posts.ID = longitude.post_id
                    WHERE ' . $wpdb->prefix . 'posts.post_type = "property"
                        AND ' . $wpdb->prefix . 'posts.post_status = "publish"
                        AND latitude.meta_key="property_map_location_latitude"
                        AND longitude.meta_key="property_map_location_longitude"
					GROUP BY ' . $wpdb->prefix . 'posts.ID HAVING distance <= ' . $distance . ';';

		return $wpdb->get_results( $sql );
	}

	/**
	 * Get children locations via ajax
	 *
	 * @access public
	 * @return string
	 */
	public function location_ajax_options() {
		header( 'HTTP/1.0 200 OK' );
		header( 'Content-Type: application/json' );

		// default label
		$label = __( 'Ajax', 'realia' );

		if ( ! empty( $_GET['value_param'] ) ) {
			if ( 'filter-location' == $_GET['value_param'] ) {
				$label = __( 'Sublocation', 'realia' );
			} elseif ( 'filter-sublocation' == $_GET['value_param'] ) {
				$label = __( 'Subsublocation', 'realia' );
			}
		}

		$data = array(
			"" => $label
		);

		$selected_terms = array();

		if( ! empty( $_GET['selected'] ) ) {
			$selected_terms = explode( ',', $_GET['selected'] );
		}

		$taxonomy = 'locations';
		$parent_term_id = $_GET[ $_GET['value_param'] ];

		$parent_term = get_term_by( 'id', $parent_term_id, $taxonomy );

		if( ! empty( $parent_term_id ) ) {
			$terms = get_terms( $taxonomy, array(
				'hide_empty'    => false,
				'parent'        => $parent_term->term_id,
			) );

			if ( ! empty( $terms ) && is_array( $terms ) ) {
				foreach( $terms as $term ) {
					$data[ $term->term_id ] = $term->name;

					if ( in_array( $term->term_id, $selected_terms ) ) {
						$data['selected'] = $term->term_id;
					}
				}
			}
		}

		$data = json_encode( $data );
		echo $data;
		exit();
	}
}

Realia_Filter::init();
