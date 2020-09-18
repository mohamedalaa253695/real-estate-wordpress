<?php

if ( in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	
	function homesweet_get_tax_childs( $categories, $id_parent, $level, &$dropdown ) {
        foreach ( $categories as $key => $category ) {
            if ( $category->category_parent == $id_parent ) {
                $dropdown = array_merge( $dropdown, array( str_repeat( "- ", $level ) . $category->name  => $category->slug ) );
                unset($categories[$key]);
                homesweet_get_tax_childs( $categories, $category->term_id, $level + 1, $dropdown );
            }
        }
    }

    function homesweet_get_taxs( $tax = 'property_types' ) {
        $return = array( esc_html__(' --- Choose a Tax --- ', 'homesweet') => '' );

        $args = array(
            'type' => 'post',
            'child_of' => 0,
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => false,
            'hierarchical' => 1,
            'taxonomy' => $tax
        );
        $categories = get_categories( $args );
        homesweet_get_tax_childs( $categories, 0, 0, $return );

        return $return;
    }


    if ( !function_exists('homesweet_vc_get_term_object')) {
		function homesweet_vc_get_term_object($term) {
			$vc_taxonomies_types = vc_taxonomies_types();

			return array(
				'label' => $term->name,
				'value' => $term->slug,
				'group_id' => $term->taxonomy,
				'group' => isset( $vc_taxonomies_types[ $term->taxonomy ], $vc_taxonomies_types[ $term->taxonomy ]->labels, $vc_taxonomies_types[ $term->taxonomy ]->labels->name ) ? $vc_taxonomies_types[ $term->taxonomy ]->labels->name : esc_html__( 'Taxonomies', 'homesweet' ),
			);
		}
	}

	// types
	if ( !function_exists('homesweet_types_field_search')) {
		function homesweet_types_field_search( $search_string ) {
			$data = array();
			$vc_taxonomies_types = array('property_types');
			$vc_taxonomies = get_terms( $vc_taxonomies_types, array(
				'hide_empty' => false,
				'search' => $search_string
			) );
			if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
				foreach ( $vc_taxonomies as $t ) {
					if ( is_object( $t ) ) {
						$data[] = homesweet_vc_get_term_object( $t );
					}
				}
			}
			return $data;
		}
	}
	if ( !function_exists('homesweet_types_render')) {
		function homesweet_types_render( $query ) {
			$category = get_term_by('slug', $query['value'], 'property_types');
			if ( ! empty( $query ) && !empty($category)) {
				$data = array();
				$data['value'] = $category->slug;
				$data['label'] = $category->name;
				return ! empty( $data ) ? $data : false;
			}
			return false;
		}
	}

	// statuses
	if ( !function_exists('homesweet_statuses_field_search')) {
		function homesweet_statuses_field_search( $search_string ) {
			$data = array();
			$vc_taxonomies_types = array('statuses');
			$vc_taxonomies = get_terms( $vc_taxonomies_types, array(
				'hide_empty' => false,
				'search' => $search_string
			) );
			if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
				foreach ( $vc_taxonomies as $t ) {
					if ( is_object( $t ) ) {
						$data[] = homesweet_vc_get_term_object( $t );
					}
				}
			}
			return $data;
		}
	}

	// statuses
	if ( !function_exists('homesweet_statuses_field_search')) {
		function homesweet_statuses_field_search( $search_string ) {
			$data = array();
			$vc_taxonomies_types = array('statuses');
			$vc_taxonomies = get_terms( $vc_taxonomies_types, array(
				'hide_empty' => false,
				'search' => $search_string
			) );
			if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
				foreach ( $vc_taxonomies as $t ) {
					if ( is_object( $t ) ) {
						$data[] = homesweet_vc_get_term_object( $t );
					}
				}
			}
			return $data;
		}
	}
	if ( !function_exists('homesweet_statuses_render')) {
		function homesweet_statuses_render( $query ) {
			$category = get_term_by('slug', $query['value'], 'statuses');
			if ( ! empty( $query ) && !empty($category)) {
				$data = array();
				$data['value'] = $category->slug;
				$data['label'] = $category->name;
				return ! empty( $data ) ? $data : false;
			}
			return false;
		}
	}

	// locations
	if ( !function_exists('homesweet_locations_field_search')) {
		function homesweet_locations_field_search( $search_string ) {
			$data = array();
			$vc_taxonomies_types = array('locations');
			$vc_taxonomies = get_terms( $vc_taxonomies_types, array(
				'hide_empty' => false,
				'search' => $search_string
			) );
			if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
				foreach ( $vc_taxonomies as $t ) {
					if ( is_object( $t ) ) {
						$data[] = homesweet_vc_get_term_object( $t );
					}
				}
			}
			return $data;
		}
	}
	if ( !function_exists('homesweet_locations_render')) {
		function homesweet_locations_render( $query ) {
			$category = get_term_by('slug', $query['value'], 'locations');
			if ( ! empty( $query ) && !empty($category)) {
				$data = array();
				$data['value'] = $category->slug;
				$data['label'] = $category->name;
				return ! empty( $data ) ? $data : false;
			}
			return false;
		}
	}

	// materials
	if ( !function_exists('homesweet_materials_field_search')) {
		function homesweet_materials_field_search( $search_string ) {
			$data = array();
			$vc_taxonomies_types = array('materials');
			$vc_taxonomies = get_terms( $vc_taxonomies_types, array(
				'hide_empty' => false,
				'search' => $search_string
			) );
			if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
				foreach ( $vc_taxonomies as $t ) {
					if ( is_object( $t ) ) {
						$data[] = homesweet_vc_get_term_object( $t );
					}
				}
			}
			return $data;
		}
	}
	if ( !function_exists('homesweet_materials_render')) {
		function homesweet_materials_render( $query ) {
			$category = get_term_by('slug', $query['value'], 'materials');
			if ( ! empty( $query ) && !empty($category)) {
				$data = array();
				$data['value'] = $category->slug;
				$data['label'] = $category->name;
				return ! empty( $data ) ? $data : false;
			}
			return false;
		}
	}

	// amenities
	if ( !function_exists('homesweet_amenities_field_search')) {
		function homesweet_amenities_field_search( $search_string ) {
			$data = array();
			$vc_taxonomies_types = array('amenities');
			$vc_taxonomies = get_terms( $vc_taxonomies_types, array(
				'hide_empty' => false,
				'search' => $search_string
			) );
			if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
				foreach ( $vc_taxonomies as $t ) {
					if ( is_object( $t ) ) {
						$data[] = homesweet_vc_get_term_object( $t );
					}
				}
			}
			return $data;
		}
	}
	if ( !function_exists('homesweet_amenities_render')) {
		function homesweet_amenities_render( $query ) {
			$category = get_term_by('slug', $query['value'], 'amenities');
			if ( ! empty( $query ) && !empty($category)) {
				$data = array();
				$data['value'] = $category->slug;
				$data['label'] = $category->name;
				return ! empty( $data ) ? $data : false;
			}
			return false;
		}
	}

	$tags = array(
		'apus_properties' => array( 'types' => 'types', 'statuses' => 'statuses', 'locations' => 'locations' ),
		'apus_location_banner' => array( 'location' => 'locations' )
	);
	foreach( $tags as $tag => $param_names ){
		if ( is_array($param_names) ) {
			foreach ($param_names as $param_name => $tax) {
				add_filter( 'vc_autocomplete_'.$tag .'_'.$param_name.'_callback', 'homesweet_'.$tax.'_field_search', 10, 1 );
		 		add_filter( 'vc_autocomplete_'.$tag .'_'.$param_name.'_render', 'homesweet_'.$tax.'_render', 10, 1 );
			}
		} else {
			add_filter( 'vc_autocomplete_'.$tag .'_'.$param_names.'_callback', 'homesweet_'.$param_names.'_field_search', 10, 1 );
		 	add_filter( 'vc_autocomplete_'.$tag .'_'.$param_names.'_render', 'homesweet_'.$param_names.'_render', 10, 1 );
		}
	}

}