<?php

function homesweet_realia_add_fields( $metaboxes ) {
	
	$metaboxes[REALIA_PROPERTY_PREFIX . 'general']['fields'][] = array(
		'name' => esc_html__( 'Virtual Tour', 'homesweet' ),
		'id' => REALIA_PROPERTY_PREFIX . 'virtual_tour',
		'type' => 'textarea_code',
		'description' => esc_html__( 'Embed Iframe code', 'homesweet' ),
	);

	$metaboxes[REALIA_PROPERTY_PREFIX . 'general']['fields'][] = array(
		'name' => esc_html__( 'Attachments', 'homesweet' ),
		'id'   => REALIA_PROPERTY_PREFIX . 'attachments',
		'type' => 'file_list'
	);

	$metaboxes[REALIA_AGENT_PREFIX . 'contact_details']['fields'][] = array(
		'name'              => esc_html__( 'Job', 'homesweet' ),
		'id'                => REALIA_PROPERTY_PREFIX . 'job',
		'type'              => 'text',
	);

	return $metaboxes;
}
add_action( 'cmb2_meta_boxes', 'homesweet_realia_add_fields', 9999 );

function homesweet_get_properties( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'contract' => '',
		'orderby' => 'latest',
		'number' => 4,
		'page' => 1,
		'types' => array(),
		'statuses' => array(),
		'locations' => array(),
		'materials' => array(),
		'amenities' => array(),
		'ids' => array(),
	));

	remove_action( 'pre_get_posts', array( 'Homesweet_Realia_Filter', 'archive' ) );
	remove_action( 'pre_get_posts', array( 'Homesweet_Realia_Filter', 'taxonomy' ) );
	$query_args = array(
		'post_type' => 'property',
		'posts_per_page' => intval( $args['number'] ),
		'post_status' => 'publish',
		'paged' => intval( $args['page'] ),
	);
	if ( !empty($args['orderby']) ) {
		switch ($args['orderby']) {
			case 'featured':
				$query_args['meta_query'][] = array(
					'key'       => REALIA_PROPERTY_PREFIX . 'featured',
					'value'     => 'on',
					'compare'   => '==',
				);
				break;
			case 'reduced':
				$query_args['meta_query'][] = array(
					'key'       => REALIA_PROPERTY_PREFIX . 'reduced',
					'value'     => 'on',
					'compare'   => '==',
				);
				break;
			case 'sticky':
				$query_args['meta_query'][] = array(
					'key'       => REALIA_PROPERTY_PREFIX . 'sticky',
					'value'     => 'on',
					'compare'   => '==',
				);
				break;
			default:

				break;
		}
	}

	if ( !empty($args['contract']) && $args['contract'] ) {
		$query_args['meta_query'][] = array(
			'key'       => REALIA_PROPERTY_PREFIX . 'contract',
			'value'     => $args['contract'],
			'compare'   => '==',
		);
	}
	// types
	if ( !empty($args['types']) && is_array($args['types']) ) {
        $query_args['tax_query'][] = array(
            'taxonomy'      => 'property_types',
            'field'         => 'slug',
            'terms'         => $args['types'],
            'operator'      => 'IN'
        );
    }
    // statuses
    if ( !empty($args['statuses']) && is_array($args['statuses']) ) {
        $query_args['tax_query'][] = array(
            'taxonomy'      => 'statuses',
            'field'         => 'slug',
            'terms'         => $args['statuses'],
            'operator'      => 'IN'
        );
    }
    // locations
    if ( !empty($args['locations']) && is_array($args['locations']) ) {
        $query_args['tax_query'][] = array(
            'taxonomy'      => 'locations',
            'field'         => 'slug',
            'terms'         => $args['locations'],
            'operator'      => 'IN'
        );
    }
    // materials
    if ( !empty($args['materials']) && is_array($args['materials']) ) {
        $query_args['tax_query'][] = array(
                'taxonomy'      => 'materials',
                'field'         => 'slug',
                'terms'         => $args['materials'],
                'operator'      => 'IN'
            );
    }
    // amenities
    if ( !empty($args['amenities']) && is_array($args['amenities']) ) {
        $query_args['tax_query'][] = array(
            'taxonomy'      => 'amenities',
            'field'         => 'slug',
            'terms'         => $args['amenities'],
            'operator'      => 'IN'
        );
    }

    if ( !empty($args['ids']) ) {
		$query_args['post__in'] = $args['ids'];
	}
	$loop = new WP_Query($query_args);
	add_action( 'pre_get_posts', array( 'Homesweet_Realia_Filter', 'archive' ) );
	add_action( 'pre_get_posts', array( 'Homesweet_Realia_Filter', 'taxonomy' ) );
	return $loop;
}


if ( !function_exists('homesweet_agency_content_class') ) {
	function homesweet_agency_content_class( $class ) {
		$page = 'archive';
		if ( is_singular( 'post' ) ) {
            $page = 'single';
        }
		if ( homesweet_get_config('agency_'.$page.'_fullwidth') ) {
			return 'container-fluid';
		}
		return $class;
	}
}
add_filter( 'homesweet_agency_content_class', 'homesweet_agency_content_class', 1 , 1  );

if ( !function_exists('homesweet_get_agency_layout_configs') ) {
	function homesweet_get_agency_layout_configs() {
		$page = 'archive';
		if ( is_singular( 'agency' ) ) {
            $page = 'single';
        }
		$left = homesweet_get_config('agency_'.$page.'_left_sidebar');
		$right = homesweet_get_config('agency_'.$page.'_right_sidebar');

		switch ( homesweet_get_config('agency_'.$page.'_layout') ) {
		 	case 'left-main':
		 		$configs['left'] = array( 'sidebar' => $left, 'class' => 'col-md-4 col-sm-12 col-xs-12'  );
		 		$configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12 pull-right' );
		 		break;
		 	case 'main-right':
		 		$configs['right'] = array( 'sidebar' => $right,  'class' => 'col-md-4 col-sm-12 col-xs-12 pull-right' ); 
		 		$configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12' );
		 		break;
	 		case 'main':
	 			$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
	 			break;
 			case 'left-main-right':
 				$configs['left'] = array( 'sidebar' => $left,  'class' => 'col-md-3 col-sm-12 col-xs-12'  );
		 		$configs['right'] = array( 'sidebar' => $right, 'class' => 'col-md-3 col-sm-12 col-xs-12' ); 
		 		$configs['main'] = array( 'class' => 'col-md-6 col-sm-12 col-xs-12' );
 				break;
		 	default:
		 		$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
		 		break;
		}

		return $configs; 
	}
}


if ( !function_exists('homesweet_agent_content_class') ) {
	function homesweet_agent_content_class( $class ) {
		$page = 'archive';
		if ( is_singular( 'post' ) ) {
            $page = 'single';
        }
		if ( homesweet_get_config('agent_'.$page.'_fullwidth') ) {
			return 'container-fluid';
		}
		return $class;
	}
}
add_filter( 'homesweet_agent_content_class', 'homesweet_agent_content_class', 1 , 1  );

if ( !function_exists('homesweet_get_agent_layout_configs') ) {
	function homesweet_get_agent_layout_configs() {
		$page = 'archive';
		if ( is_singular( 'post' ) ) {
            $page = 'single';
        }
		$left = homesweet_get_config('agent_'.$page.'_left_sidebar');
		$right = homesweet_get_config('agent_'.$page.'_right_sidebar');

		switch ( homesweet_get_config('agent_'.$page.'_layout') ) {
		 	case 'left-main':
		 		$configs['left'] = array( 'sidebar' => $left, 'class' => 'col-md-3 col-sm-12 col-xs-12'  );
		 		$configs['main'] = array( 'class' => 'col-md-9 col-sm-12 col-xs-12 pull-right' );
		 		break;
		 	case 'main-right':
		 		$configs['right'] = array( 'sidebar' => $right,  'class' => 'col-md-3 col-sm-12 col-xs-12 pull-right' ); 
		 		$configs['main'] = array( 'class' => 'col-md-9 col-sm-12 col-xs-12' );
		 		break;
	 		case 'main':
	 			$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
	 			break;
 			case 'left-main-right':
 				$configs['left'] = array( 'sidebar' => $left,  'class' => 'col-md-3 col-sm-12 col-xs-12'  );
		 		$configs['right'] = array( 'sidebar' => $right, 'class' => 'col-md-3 col-sm-12 col-xs-12' ); 
		 		$configs['main'] = array( 'class' => 'col-md-6 col-sm-12 col-xs-12' );
 				break;
		 	default:
		 		$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
		 		break;
		}

		return $configs; 
	}
}


if ( !function_exists('homesweet_property_content_class') ) {
	function homesweet_property_content_class( $class ) {
		$page = 'archive';
		if ( is_singular( 'post' ) ) {
            $page = 'single';
        }
		if ( homesweet_get_config('property_'.$page.'_fullwidth') ) {
			return 'container-fluid';
		}
		return $class;
	}
}
add_filter( 'homesweet_property_content_class', 'homesweet_property_content_class', 1 , 1  );


if ( !function_exists('homesweet_get_property_layout_configs') ) {
	function homesweet_get_property_layout_configs() {
		$page = 'archive';
		if ( is_singular( 'property' ) ) {
            $page = 'single';
        }
		$left = homesweet_get_config('property_'.$page.'_left_sidebar');
		$right = homesweet_get_config('property_'.$page.'_right_sidebar');

		switch ( homesweet_get_config('property_'.$page.'_layout') ) {
		 	case 'left-main':
		 		$configs['left'] = array( 'sidebar' => $left, 'class' => 'col-md-4 col-sm-12 col-xs-12'  );
		 		$configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12 pull-right' );
		 		break;
		 	case 'main-right':
		 		$configs['right'] = array( 'sidebar' => $right,  'class' => 'col-md-4 col-sm-12 col-xs-12 pull-right' ); 
		 		$configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12' );
		 		break;
	 		case 'main':
	 			$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
	 			break;
 			case 'left-main-right':
 				$configs['left'] = array( 'sidebar' => $left,  'class' => 'col-md-3 col-sm-12 col-xs-12'  );
		 		$configs['right'] = array( 'sidebar' => $right, 'class' => 'col-md-3 col-sm-12 col-xs-12' ); 
		 		$configs['main'] = array( 'class' => 'col-md-6 col-sm-12 col-xs-12' );
 				break;
		 	default:
		 		$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
		 		break;
		}

		return $configs; 
	}
}

function homesweet_property_page_link($keep_query = false ) {
    if ( is_post_type_archive( 'property' ) ) {
        $link = get_post_type_archive_link( 'property' );
    } else {
        $link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
    }

    if( $keep_query ) {
        foreach ( $_GET as $key => $val ) {
            if ( 'orderby' === $key || 'submit' === $key ) {
                continue;
            }
            $link = add_query_arg( $key, $val, $link );
        }
    }
    return $link;
}

remove_action( 'realia_before_property_archive', array( 'Realia_Filter', 'sort_template' ) );


if ( !function_exists('homesweet_realia_get_display_mode') ) {
    function homesweet_realia_get_display_mode() {
        $display_mode = get_theme_mod( 'realia_general_show_property_archive_as_grid', null );
        if ($display_mode == '1') {
        	$display_mode = 'grid';
        } else {
        	$display_mode = 'list';
        }
        if ( isset($_COOKIE['homesweet_realia_mode']) && ($_COOKIE['homesweet_realia_mode'] == 'list' || $_COOKIE['homesweet_realia_mode'] == 'grid') ) {
            $display_mode = $_COOKIE['homesweet_realia_mode'];
        }
        return $display_mode;
    }
}

function homesweet_realia_get_property_tax( $post_id = null, $tax = 'property_types' ) {
	if ( null == $post_id ) {
		$post_id = get_the_ID();
	}
	$types = wp_get_post_terms( $post_id, $tax );
	if ( is_array( $types ) && count( $types ) > 0 ) {
		$type = array_shift( $types );
		return $type;
	}

	return false;
}

function homesweet_realia_get_property_agent($post_id = null) {
	$property_agents = Realia_Query::get_property_agents($post_id);

	if ( count( $property_agents ) > 0 ) {
		$agent_id = $property_agents[0];
		$agents = get_posts( array(
			'post_type' => 'agent',
			'post__in' => array($agent_id),
			'post_status' => 'public',
			'number' => 1
		) );
		if ( !empty($agents) ) {
			return $agents[0];
		}
	}
	return false;
}

function homesweet_realia_display_property_agent($post_id) {
	$agent = homesweet_realia_get_property_agent();
	if ( !empty($agent) ) {
		?>
		<a href="<?php echo esc_url(get_permalink($agent->ID)); ?>" class="agent-small-image-inner">
			<i class="fa fa-user-o"></i>
			<span><?php echo trim($agent->post_title); ?></span>
		</a>
		<?php
	} else {
		?>
		<div class="agent-small-image-inner">
			<i class="fa fa-user-o"></i>
			<span><?php echo get_the_author();?></span>
		</div>
		<?php
	}
}
function homesweet_realia_agent_social_icons() {
	$social_icons = array(
        'facebook' => 'fa fa-facebook ',
        'google_plus' => 'fa fa-google-plus',
        'twitter' => 'fa fa-twitter ',
        'linkedin' => 'fa fa-linkedin',
    );
    return apply_filters( 'homesweet_realia_agent_social_icons', $social_icons );
}

// ajax request
function homesweet_is_ajax_request() {
    if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
        return true;
    }
    return false;
}

function homesweet_get_current_url() {
	global $wp;
	$link = home_url( $wp->request ); // Base page URL
			
	// Unset query strings used for Ajax shop filters
	unset( $_GET['shop_load'] );
	unset( $_GET['_'] );
	
	$qs_count = count( $_GET );
	
	// Any query strings to add?
	if ( $qs_count > 0 ) {
		$i = 0;
		$link .= '?';
		
		// Build query string
		foreach ( $_GET as $key => $value ) {
			$i++;
			$link .= $key . '=' . $value;
			if ( $i != $qs_count ) {
				$link .= '&';
			}
		}
	}
	return $link;
}

function homesweet_get_content_sort() {
	$contents = homesweet_get_config( 'property_sort_content', array() );

	if ( isset( $contents['enabled'] ) ) {
		$contents = $contents['enabled'];
		if ( isset($contents['placebo']) ) {
			unset($contents['placebo']);
		}
		return $contents;
	}

	return array();
}

function homesweet_get_default_places() {
	$options = array(
        "accounting" => esc_html__('Accounting', 'homesweet'),
        "airport" => esc_html__('Airport', 'homesweet'),
        "amusement_park" => esc_html__('Amusement Park', 'homesweet'),
        "aquarium" => esc_html__('Aquarium', 'homesweet'),
        "atm" => esc_html__('Atm', 'homesweet'),
        "bakery" => esc_html__('Bakery', 'homesweet'),
        "bank" => esc_html__('Bank', 'homesweet'),
        "bar" => esc_html__('Bar', 'homesweet'),
        "beauty_salon" => esc_html__('Beauty Salon', 'homesweet'),
        "bicycle_store" => esc_html__('Bicycle Store', 'homesweet'),
        "book_store" => esc_html__('Book Store', 'homesweet'),
        "bowling_alley" => esc_html__('Bowling Alley', 'homesweet'),
        "bus_station" => esc_html__('Bus Station', 'homesweet'),
        "cafe" => esc_html__('Cafe', 'homesweet'),
        "campground" => esc_html__('Campground', 'homesweet'),
        "car_rental" => esc_html__('Car Rental', 'homesweet'),
        "car_repair" => esc_html__('Car Repair', 'homesweet'),
        "car_wash" => esc_html__('Car Wash', 'homesweet'),
        "casino" => esc_html__('Casino', 'homesweet'),
        "cemetery" => esc_html__('Cemetery', 'homesweet'),
        "church" => esc_html__('Church', 'homesweet'),
        "city_hall" => esc_html__('City Center', 'homesweet'),
        "clothing_store" => esc_html__('Clothing Store', 'homesweet'),
        "convenience_store" => esc_html__('Convenience Store', 'homesweet'),
        "courthouse" => esc_html__('Courthouse', 'homesweet'),
        "dentist" => esc_html__('Dentist', 'homesweet'),
        "department_store" => esc_html__('Department Store', 'homesweet'),
        "doctor" => esc_html__('Doctor', 'homesweet'),
        "electrician" => esc_html__('Electrician', 'homesweet'),
        "electronics_store" => esc_html__('Electronics Store', 'homesweet'),
        "embassy" => esc_html__('Embassy', 'homesweet'),
        "establishment" => esc_html__('Establishment', 'homesweet'),
        "finance" => esc_html__('Finance', 'homesweet'),
        "fire_station" => esc_html__('Fire Station', 'homesweet'),
        "florist" => esc_html__('Florist', 'homesweet'),
        "food" => esc_html__('Food', 'homesweet'),
        "gas_station" => esc_html__('Gas Station', 'homesweet'),
        "grocery_or_supermarket" => esc_html__('Grocery', 'homesweet'),
        "gym" => esc_html__('Gym', 'homesweet'),
        "hair_care" => esc_html__('Hair Care', 'homesweet'),
        "hardware_store" => esc_html__('Hardware Store', 'homesweet'),
        "health" => esc_html__('Health', 'homesweet'),
        "home_goods_store" => esc_html__('Home Goods Store', 'homesweet'),
        "hospital" => esc_html__('Hospital', 'homesweet'),
        "jewelry_store" => esc_html__('Jewelry Store', 'homesweet'),
        "laundry" => esc_html__('Laundry', 'homesweet'),
        "lawyer" => esc_html__('Lawyer', 'homesweet'),
        "library" => esc_html__('Library', 'homesweet'),
        "lodging" => esc_html__('Lodging', 'homesweet'),
        "movie_theater" => esc_html__('Movie Theater', 'homesweet'),
        "moving_company" => esc_html__('Moving Company', 'homesweet'),
        "night_club" => esc_html__('Night Club', 'homesweet'),
        "park" => esc_html__('Park', 'homesweet'),
        "pharmacy" => esc_html__('Pharmacy', 'homesweet'),
        "place_of_worship" => esc_html__('Place Of Worship', 'homesweet'),
        "plumber" => esc_html__('Plumber', 'homesweet'),
        "police" => esc_html__('Police', 'homesweet'),
        "post_office" => esc_html__('Post Office', 'homesweet'),
        "restaurant" => esc_html__('Restaurant', 'homesweet'),
        "school" => esc_html__('School', 'homesweet'),
        "shopping_mall" => esc_html__('Shopping Mall', 'homesweet'),
        "spa" => esc_html__('Spa', 'homesweet'),
        "stadium" => esc_html__('Stadium', 'homesweet'),
        "storage" => esc_html__('Storage', 'homesweet'),
        "store" => esc_html__('Store', 'homesweet'),
        "subway_station" => esc_html__('Subway Station', 'homesweet'),
        "synagogue" => esc_html__('Synagogue', 'homesweet'),
        "taxi_stand" => esc_html__('Taxi Stand', 'homesweet'),
        "train_station" => esc_html__('Train Station', 'homesweet'),
        "travel_agency" => esc_html__('Travel Agency', 'homesweet'),
        "university" => esc_html__('University', 'homesweet'),
        "veterinary_care" => esc_html__('Veterinary Care', 'homesweet'),
        "zoo" => esc_html__('Zoo', 'homesweet'),
    );
	return apply_filters( 'homesweet_get_default_places', $options );
}

add_action( 'wp_ajax_homesweet_properties_map', 'homesweet_properties_map' );
add_action( 'wp_ajax_nopriv_homesweet_properties_map', 'homesweet_properties_map' );
function homesweet_properties_map() {
	$types = array();
	if ( isset($_REQUEST['types']) && !empty($_REQUEST['types']) ) {
	    $types = explode(',', $_REQUEST['types']);
	}

	$statuses = array();
	if ( isset($_REQUEST['statuses']) && !empty($_REQUEST['statuses']) ) {
	    $statuses = explode(',', $_REQUEST['statuses']);
	}

	$locations = array();
	if ( isset($_REQUEST['locations']) && !empty($_REQUEST['locations']) ) {
	    $locations = explode(',', $_REQUEST['locations']);
	}
	$contract = isset($_REQUEST['contract']) && !empty($_REQUEST['contract']) ? $_REQUEST['contract'] : '';
	$orderby = isset($_REQUEST['orderby']) && !empty($_REQUEST['orderby']) ? $_REQUEST['orderby'] : '';
	$number = isset($_REQUEST['number']) && !empty($_REQUEST['number']) ? $_REQUEST['number'] : 4;

	$property_groups = array();
	$data = array();
	$args = array(
		'contract' => $contract,
		'orderby' => $orderby,
		'number' => $number,
		'types' => $types,
		'statuses' => $statuses,
		'locations' => $locations,
	);
	$loop = homesweet_get_properties( $args );
	if ( $loop->have_posts() ) {
		while ( $loop->have_posts() ) { $loop->the_post();
			$latitude = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'map_location_latitude', true );
			$longitude = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'map_location_longitude', true );

			// Build on array of property groups. We need to know how
			// many and which properties are at the same position.
			if ( ! empty( $latitude ) && ! empty( $longitude ) ) {
				$hash = sha1( $latitude . $longitude );
				$property_groups[ $hash ][] = get_the_ID();

			}
		}
		wp_reset_postdata();
	}

	foreach ( $property_groups as $group ) {
		$args = array(
			'post_type'         => 'property',
			'posts_per_page'    => -1,
			'post_status'       => 'publish',
			'post__in'          => $group,
		);

		query_posts( $args );
		if ( have_posts() ) {
			if ( count( $group ) > 1 ) {
				$latitude = get_post_meta( $group[0], REALIA_PROPERTY_PREFIX . 'map_location_latitude', true );
				$longitude = get_post_meta( $group[0], REALIA_PROPERTY_PREFIX . 'map_location_longitude', true );

				// Marker
				$output = Realia_Template_Loader::load( 'misc/google-map-infowindow-group' );
				$content = str_replace( array( "\r\n", "\n", "\t" ), '', $output );

				// Infowindow
				$output = Realia_Template_Loader::load( 'misc/google-map-marker-group' );
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

function homesweet_realia_get_property_type() {
	$terms = get_the_terms( get_the_ID(), 'property_types' );
	if ( ! is_wp_error( $terms ) && ( is_array( $terms ) || is_object( $terms ) ) ) {
		return $terms[0];
	}
}

function homesweet_realia_get_term_icon_url( $term_id ) {
	return Taxonomy_MetaData_CMB2::get( 'property_types', $term_id, 'icon' );
}

function homesweet_realia_display_price_html($price) {
	$price = Realia_Utilities::format_number( $price );
	$currencies = get_theme_mod( 'realia_currencies' );
	$currency_index = 0;
	$currency_symbol = ! empty( $currencies[ $currency_index ]['symbol'] ) ? $currencies[ $currency_index ]['symbol'] : '$';
	$currency_show_symbol_after = ! empty( $currencies[ $currency_index ]['show_after'] ) ? true : false;
	$price_html = $price;
	if ( ! empty( $currency_symbol ) ) {
		if ( $currency_show_symbol_after ) {
			$price_html = sprintf('<span class="price">%s</span> <span class="currency-symbol">%s</span>', $price, $currency_symbol);
		} else {
			$price_html = sprintf('<span class="currency-symbol">%s</span> <span class="price">%s</span>', $currency_symbol, $price);
		}
	}
	echo trim($price_html);
}

add_action( 'wp_ajax_homesweet_get_nearby_yelp', 'homesweet_get_nearby_yelp' );
add_action( 'wp_ajax_nopriv_homesweet_get_nearby_yelp', 'homesweet_get_nearby_yelp' );
function homesweet_get_nearby_yelp() {
	$return = array();
	if ( isset($_POST['id']) ) {
		$property_id = (int)$_POST['id'];
		$access_token = homesweet_get_config('api_settings_yelp_access_token', '');

		$all_cats = homesweet_get_yelp_categories();
		$terms = homesweet_get_config('yelp_category');
		$terms_title = homesweet_get_config('yelp_title');
		$terms_icon = homesweet_get_config('yelp_icon');
		$map_location = get_post_meta( $property_id, REALIA_PROPERTY_PREFIX . 'map_location', true );
		$limit = 3;

		if ( is_array($terms) && $access_token != '' && ! empty( $map_location ) && 2 == count( $map_location ) ) {
			$result = Realia_Template_Loader::load( 'single/yelp-content', array(
				'property_id' => $property_id,
				'access_token' => $access_token,
				'all_cats' => $all_cats,
				'terms' => $terms,
				'map_location' => $map_location,
				'limit' => $limit,
				'terms_title' => $terms_title,
				'terms_icon' => $terms_icon,
			) );
			$html = '';
			$result = trim($result);
			if ( !empty($result) ) {
				$html = '<div class="property-section property-yelp-places">
						<div class="property-section-heading">
        					<h3>'.esc_html__('Yelp Nearby Places', 'homesweet').'</h3>
        					<div class="yelp-logo">
								<a href="//yelp.com" target="_blank">
									<span>'.esc_html__('Powered by', 'homesweet').'</span>
									<img src="' . get_template_directory_uri() . '/images/yelp-logo.png" alt="">
								</a>
							</div>
        				</div>
        				<div class="property-section-content">'.$result.'</div>
        			</div>';

    			$return = array( 'status' => 'success', 'html' => $html );
			}
		}
	}

	if ( empty($return) ) {
		$return = array( 'status' => 'error', 'html' => esc_html__('do not have yelp', 'homesweet') );
	}
	echo json_encode( $return );
	exit();
}

function homesweet_get_yelp_star_img($star) {
	switch ($star) {
		case '1':
		case '2':
		case '3':
		case '4':
		case '5':
			$class = 'regular_'.$star.'.png';
			break;
		case '1.5':
			$class = 'regular_1_half.png';
			break;
		case '2.5':
			$class = 'regular_2_half.png';
			break;
		case '3.5':
			$class = 'regular_3_half.png';
			break;
		case '4.5':
			$class = 'regular_4_half.png';
			break;
		default:
			$class = 'regular_0.png';
			break;
	}
	return apply_filters( 'homesweet_get_yelp_star_img', $class, $star );
}

function homesweet_get_yelp_categories() {
    return apply_filters( 'homesweet_get_yelp_categories', array(
        'food' => esc_html__('Food', 'homesweet'),
        'nightlife' => esc_html__('Nightlife', 'homesweet'),
        'restaurants' => esc_html__('Restaurants', 'homesweet'),
        'shopping' => esc_html__('Shopping', 'homesweet'),
        'active-life' => esc_html__('Active Life', 'homesweet'),
        'arts-entertainment' => esc_html__('Arts & Entertainment', 'homesweet'),
        'automotive' => esc_html__('Automotive', 'homesweet'),
        'beauty-spas' => esc_html__('Beauty & Spas', 'homesweet'),
        'education' => esc_html__('Education', 'homesweet'),
        'event-planning-services' => esc_html__('Event Planning & Services', 'homesweet'),
        'health-medical' => esc_html__('Health & Medical', 'homesweet'),
        'home-services' => esc_html__('Home Services', 'homesweet'),
        'local-services' => esc_html__('Local Services', 'homesweet'),
        'financial-services' => esc_html__('Financial Services', 'homesweet'),
        'hotels-travel' => esc_html__('Hotels & Travel', 'homesweet'),
        'local-flavor' => esc_html__('Local Flavor', 'homesweet'),
        'mass-media' => esc_html__('Mass Media', 'homesweet'),
        'pets' => esc_html__('Pets', 'homesweet'),
        'professional-services' => esc_html__('Professional Services', 'homesweet'),
        'public-services-govt' => esc_html__('Public Services & Government', 'homesweet'),
        'real-estate' => esc_html__('Real Estate', 'homesweet'),
        'religious-organizations' => esc_html__('Religious Organizations', 'homesweet'),
    ));
}

add_action( 'wp_ajax_homesweet_get_walk_score', 'homesweet_get_walk_score' );
add_action( 'wp_ajax_nopriv_homesweet_get_walk_score', 'homesweet_get_walk_score' );
function homesweet_get_walk_score() {
	$return = array();
	if ( isset($_POST['id']) ) {
		$property_id = (int)$_POST['id'];
		$walkscore_api_key = homesweet_get_config('api_settings_walk_score_api_key', '');
		$map_location = get_post_meta( $property_id, REALIA_PROPERTY_PREFIX . 'map_location', true );

		if ( $walkscore_api_key != '' && ! empty( $map_location ) && 2 == count( $map_location ) ) {

			$result = Realia_Template_Loader::load( 'single/walk_score-content', array(
				'property_id' => $property_id,
				'walkscore_api_key' => $walkscore_api_key,
				'map_location' => $map_location,
			) );
			$html = '';
			$result = trim($result);
			if ( !empty($result) ) {

				$html = '<div class="property-section property-walk-score">
						<div class="property-section-heading">
        					<h3>'.esc_html__('Walk Score', 'homesweet').'</h3>
        					<div class="walkscore-logo">
				                <a href="https://www.walkscore.com" target="_blank">
				                    <img src="//cdn.walk.sc/images/api-logo.png" alt="'.esc_html__('Walk Scores', 'homesweet').'">
				                </a>
				            </div>
        				</div>
        				<div class="property-section-content">'.$result.'</div>
        			</div>';

    			$return = array( 'status' => 'success', 'html' => $html );
			}
		}
	}
	if ( empty($return) ) {
		$return = array( 'status' => 'error', 'html' => esc_html__('do not have walk score', 'homesweet') );
	}

	echo json_encode( $return );
	exit();
}

function homesweet_get_yelp_access_token() {
    $yelp_client_id = isset($_POST['yelp_id']) ? $_POST['yelp_id'] : '';
    $yelp_secret_id = isset($_POST['yelp_secret']) ? $_POST['yelp_secret'] : '';
    $post_data = array(
        'client_id' => urlencode($yelp_client_id),
        'client_secret' => urlencode($yelp_secret_id),
    );

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($post_data),
        )
    );

    $context = stream_context_create($options);
    $yelp_data = homesweet_realia_get_file_contents('https://api.yelp.com/oauth2/token', false, $context);

    $yelp_data = json_decode($yelp_data, true);

    $token = isset($yelp_data['access_token']) ? $yelp_data['access_token'] : '';
    echo json_encode(array( 'token' => $token ));
    die;
}
add_action('wp_ajax_homesweet_get_yelp_access_token', 'homesweet_get_yelp_access_token');

function homesweet_realia_get_file_contents($url, $use_include_path, $context) {
	if ( function_exists('apus_framework_get_file_contents') ) {
		return apus_framework_get_file_contents($url, $use_include_path, $context);
	}
	return array();
}

// package custom field
function homesweet_realia_package_support() {
	add_post_type_support( 'package', 'editor' );
}
add_action( 'init', 'homesweet_realia_package_support' );

// track property view
function homesweet_track_property_view() {
    if ( ! is_singular( 'property' ) ) {
        return;
    }
    global $post;

    if ( empty( $_COOKIE['homesweet_recently_viewed'] ) )
        $viewed_properties = array();
    else
        $viewed_properties = (array) explode( '|', $_COOKIE['homesweet_recently_viewed'] );

    if ( ! in_array( $post->ID, $viewed_properties ) ) {
        $viewed_properties[] = $post->ID;
    }

    if ( sizeof( $viewed_properties ) > 15 ) {
        array_shift( $viewed_properties );
    }
    // Store for session only
    setcookie( 'homesweet_recently_viewed', implode( '|', $viewed_properties ) , time()+3600*24*10, '/' );
    $_COOKIE['homesweet_recently_viewed'] = implode( '|', $viewed_properties );
}
add_action( 'template_redirect', 'homesweet_track_property_view', 20 );


if ( !function_exists('homesweet_get_page_idx_layout_configs') ) {
	function homesweet_get_page_idx_layout_configs() {
		
		$left = homesweet_get_config('page_idx_left_sidebar');
		$right = homesweet_get_config('page_idx_right_sidebar');

		switch ( homesweet_get_config('page_idx_layout') ) {
		 	case 'left-main':
		 		$configs['left'] = array( 'sidebar' => $left, 'class' => 'col-md-4 col-sm-12 col-xs-12'  );
		 		$configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12 pull-right' );
		 		break;
		 	case 'main-right':
		 		$configs['right'] = array( 'sidebar' => $right,  'class' => 'col-md-4 col-sm-12 col-xs-12 pull-right' ); 
		 		$configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12' );
		 		break;
	 		case 'main':
	 			$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
	 			break;
 			case 'left-main-right':
 				$configs['left'] = array( 'sidebar' => $left,  'class' => 'col-md-3 col-sm-12 col-xs-12'  );
		 		$configs['right'] = array( 'sidebar' => $right, 'class' => 'col-md-3 col-sm-12 col-xs-12' ); 
		 		$configs['main'] = array( 'class' => 'col-md-6 col-sm-12 col-xs-12' );
 				break;
		 	default:
		 		$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
		 		break;
		}

		return $configs; 
	}
}

function homesweet_realia_post_thumbnail($property, $thumb = 'full') {
	$html = '';
	if ( has_post_thumbnail( $property ) ) {
		if ( homesweet_get_config('image_lazy_loading') ) {
			$product_thumbnail_id = get_post_thumbnail_id( $property->ID );
	        $product_thumbnail = wp_get_attachment_image_src( $product_thumbnail_id, $thumb );
	        $placeholder_image = homesweet_create_placeholder(array($product_thumbnail[1],$product_thumbnail[2]));
	        $html .= '<div class="image-wrapper">';
	        $html .= '<img src="' . trim( $placeholder_image ) . '" data-src="' . esc_url( $product_thumbnail[0] ) . '" width="' . esc_attr( $product_thumbnail[1] ) . '" height="' . esc_attr( $product_thumbnail[2] ) . '" alt="' . esc_attr( get_the_title() ) . '" class="attachment-'.esc_attr($thumb).' unveil-image" />';
	        $html .= '</div>';
	    } else {
			$html .= get_the_post_thumbnail( $property->ID, $thumb, array( 'alt' => $property->post_title ) );
		}
	}

	echo trim($html);
}

function homesweet_realia_post_thumbnails($property, $thumb = 'full') {
	$html = '';
	$gallery = homesweet_realia_get_full_gallery_ids($property);
	if ( !empty($gallery) ) {
		$html .= '<div class="owl-carousel property-gallery-preview-owl" data-smallmedium="1" data-extrasmall="1" data-items="1" data-carousel="owl" data-pagination="false" data-nav="true" data-margin="0">';
		foreach ($gallery as $id => $full_src) {
			if ( homesweet_get_config('image_lazy_loading') ) {
		        $product_thumbnail = wp_get_attachment_image_src( $id, $thumb );
		        $placeholder_image = homesweet_create_placeholder(array($product_thumbnail[1],$product_thumbnail[2]));
		        $html .= '<a href="'.get_permalink().'" class="property-box-image-inner">';
		        $html .= '<div class="image-wrapper">';
		        $html .= '<img src="' . trim( $placeholder_image ) . '" data-src="' . esc_url( $product_thumbnail[0] ) . '" width="' . esc_attr( $product_thumbnail[1] ) . '" height="' . esc_attr( $product_thumbnail[2] ) . '" alt="' . esc_attr( get_the_title() ) . '" class="attachment-'.esc_attr($thumb).' unveil-image" />';
		        $html .= '</div>';
		        $html .= '</a>';
		    } else {
				$html .= get_the_post_thumbnail( $property->ID, $thumb, array( 'alt' => $property->post_title ) );
			}
		}
		$html .= '</div>';
	}

	echo trim($html);
}

function homesweet_realia_get_full_gallery_ids($property){
	$gallery = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'gallery', true );
	$return = !empty($gallery) && is_array($gallery) ? $gallery : array();
	if ( has_post_thumbnail( $property ) ) {
		$thumbnail_id = get_post_thumbnail_id( $property->ID );
        $product_thumbnail = wp_get_attachment_image_src( $thumbnail_id, 'full' );
	    if ( !empty($product_thumbnail[0]) ) {
	    	$return = array($thumbnail_id => $product_thumbnail[0]) + $return;
	    }
	}
	return $return;
}

function homesweet_realia_scripts() {
	// google map
	wp_dequeue_script('dsidxpress_google_maps_geocode_api');
	wp_dequeue_script('google-maps');
	$browser_key = get_theme_mod( 'realia_general_google_browser_key' );
	$key = empty( $browser_key ) ? '' : 'key='. $browser_key;
	wp_enqueue_script('google-maps-places', '//maps.googleapis.com/maps/api/js?libraries=places&language='.get_locale().'&'.$key, array('jquery'), '1.0', false);
	wp_dequeue_script('jquery-google-map');
	wp_enqueue_script('jquery-google-map-custom', get_template_directory_uri() . '/js/maps/jquery-google-map-custom.js', array('jquery'), '1.2', false);
	wp_enqueue_script('homesweet-map-script', get_template_directory_uri() . '/js/maps/script.js', array('jquery'), '1.0', false);

	wp_enqueue_script('chart', get_template_directory_uri() . '/js/chart.min.js', array('jquery'), '1.0', false);
}
add_action( 'wp_enqueue_scripts', 'homesweet_realia_scripts', 99 );

add_action( 'wp_ajax_homesweet_get_properties', 'homesweet_get_ajax_properties' );
add_action( 'wp_ajax_nopriv_homesweet_get_properties', 'homesweet_get_ajax_properties' );
function homesweet_get_ajax_properties() {
	$columns = isset($_REQUEST['columns']) ? $_REQUEST['columns'] : 4;
	$item_style = isset($_REQUEST['item_style']) ? $_REQUEST['item_style'] : '';
	$layout_type = isset($_REQUEST['layout_type']) ? $_REQUEST['layout_type'] : 'mansory';
	$contract = isset($_REQUEST['contract']) ? $_REQUEST['contract'] : '';
	$orderby = isset($_REQUEST['orderby']) ? $_REQUEST['orderby'] : '';
	$number = isset($_REQUEST['number']) ? $_REQUEST['number'] : 4;
	$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
	$types = isset($_REQUEST['types']) ? $_REQUEST['types'] : '';
	$statuses = isset($_REQUEST['statuses']) ? $_REQUEST['statuses'] : '';
	$locations = isset($_REQUEST['locations']) ? $_REQUEST['locations'] : '';

	$ptypes = array();
	if ( isset($types) && !empty($types) ) {
	    $ptypes = explode(',', $types);
	}

	$pstatuses = array();
	if ( isset($statuses) && !empty($statuses) ) {
	    $pstatuses = explode(',', $statuses);
	}

	$plocations = array();
	if ( isset($locations) && !empty($locations) ) {
	    $plocations = explode(',', $locations);
	}
	$args = array(
		'contract' => $contract,
		'orderby' => $orderby,
		'number' => $number,
		'types' => $ptypes,
		'statuses' => $pstatuses,
		'locations' => $plocations,
		'page' => $page,
	);
	$loop = homesweet_get_properties( $args );
	if ( $loop->have_posts() ) {
		echo Realia_Template_Loader::load( 'loop-layout/'.$layout_type, array( 'loop' => $loop, 'columns' => $columns, 'item_style' => $item_style, 'ajax_load' => true ) );
	}
	die();
}

function homesweet_realia_property_views( $property_id ) {
    $views = intval( get_post_meta($property_id, 'homesweet_property_views', true) );
    if( $views != '' ) {
        $views++;
    } else {
        $views = 1;
    }
    update_post_meta( $property_id, 'homesweet_property_views', $views );

    $today = date('m-d-Y', time());

    $views_by_date = get_post_meta($property_id, 'homesweet_views_by_date', true);

    if( $views_by_date != '' || is_array($views_by_date) ) {
        if (!isset($views_by_date[$today])) {
            if (count($views_by_date) > 60) {
                array_shift($views_by_date);
            }
            $views_by_date[$today] = 1;
        } else {
            $views_by_date[$today] = intval($views_by_date[$today]) + 1;
        }
    } else {
        $views_by_date = array();
        $views_by_date[$today] = 1;
    }

    update_post_meta($property_id, 'homesweet_views_by_date', $views_by_date);
    update_post_meta($property_id, 'homesweet_recently_viewed', $today);
}

function homesweet_return_traffic_labels( $property_id ) {

    $number_days = homesweet_get_config('property_stats_number_days', 15);
    if( empty($number_days) ) {
        $number_days = 15;
    }

    $views_by_date = get_post_meta($property_id, 'homesweet_views_by_date', true);

    if (!is_array($views_by_date)) {
        $views_by_date = array();
    }
    $array_labels = array_keys($views_by_date);
    $array_labels = array_slice( $array_labels, -1 * $number_days, $number_days, false );

    return $array_labels;
}

function homesweet_return_traffic_data($property_id) {

    $number_days = homesweet_get_config('property_stats_number_days', 15);
    if( empty($number_days) ) {
        $number_days = 15;
    }

    $views_by_date = get_post_meta( $property_id, 'homesweet_views_by_date', true );
    if ( !is_array( $views_by_date ) ) {
        $views_by_date = array();
    }
    $array_values = array_values( $views_by_date );
    $array_values = array_slice( $array_values, -1 * $number_days, $number_days, false );

    return $array_values;
}

add_action( 'wp_ajax_homesweet_get_chart', 'homesweet_realia_get_chart' );
add_action( 'wp_ajax_nopriv_homesweet_get_chart', 'homesweet_realia_get_chart' );
function homesweet_realia_get_chart() {
	if ( empty($_REQUEST['id']) ) {
		die();
	}
	$id = $_REQUEST['id'];
	$return = array(
		'stats_labels' => homesweet_return_traffic_labels($id),
		'stats_values' => homesweet_return_traffic_data($id),
		'stats_view' => esc_html__('Views', 'homesweet'),
		'chart_type' => homesweet_get_config('property_stats_type', 'line'),
		'bg_color' => homesweet_get_config('property_stats_bg_color', 'rgb(255, 99, 132)'),
        'border_color' => homesweet_get_config('property_stats_border_color', 'rgb(255, 99, 132)'),
	);
	echo json_encode($return);
	die();
}

function homesweet_get_attachment_metadata($attachment_id)
{
    $thumbnail_image = get_posts(array('p' => $attachment_id, 'post_type' => 'attachment'));

    if ($thumbnail_image && isset($thumbnail_image[0])) {
        return $thumbnail_image[0];
    }
}

function homesweet_login_register_popup() {
	if ( !is_user_logged_in() ) {
		get_template_part('page-templates/parts/login-register');
	}
}
add_action( 'wp_footer', 'homesweet_login_register_popup' );

remove_action( 'init', array( 'Realia', 'image_sizes' ) );

class Homesweet_Realia_Price {
	/**
	 * Gets property price
	 *
	 * @access public
	 * @param null $post_id
	 * @return bool|string
	 */
	public static function homesweet_get_property_price( $post_id = null ) {
		if ( null == $post_id ) {
			$post_id = get_the_ID();
		}

		$custom = get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'price_custom', true );

		if ( ! empty( $custom ) ) {
			return $custom;
		}

		$price = get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'price', true );

		if ( empty( $price ) || ! is_numeric( $price ) ) {
			return false;
		}

		$price = self::homesweet_format_price( $price );

		$prefix = get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'price_prefix', true );
		$suffix = get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'price_suffix', true );

		if ( ! empty( $prefix ) ) {
			$price = '<span class="subfix">'.$prefix .'<span> '.$price;
		}

		if ( ! empty( $suffix ) ) {
			$price = $price .  ' ' .'<span class="subfix">'. $suffix.'<span>';
		}

		return $price;
	}

	/**
	 * Formats price
	 *
	 * @access public
	 * @param $price
	 * @return bool|string
	 */
	public static function homesweet_format_price( $price ) {
		if ( empty( $price ) || ! is_numeric( $price ) ) {
			return false;
		}

		$price = Realia_Utilities::format_number( $price );

		$currency_index = 0;
		$currencies = get_theme_mod( 'realia_currencies' );
		$currency_symbol = ! empty( $currencies[ $currency_index ]['symbol'] ) ? $currencies[ $currency_index ]['symbol'] : '$';
		$currency_show_symbol_after = ! empty( $currencies[ $currency_index ]['show_after'] ) ? true : false;

		if ( ! empty( $currency_symbol ) ) {
			if ( $currency_show_symbol_after ) {
				$price = $price .  ' ' . $currency_symbol;
			} else {
				$price = $currency_symbol . ' ' . $price;
			}
		}

		return $price;
	}
}

remove_action( 'tgmpa_register', array( 'Realia', 'register_plugins' ) );