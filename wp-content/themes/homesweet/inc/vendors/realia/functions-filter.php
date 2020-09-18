<?php


if ( class_exists('Realia_Filter') ) {
	class Homesweet_Realia_Filter extends Realia_Filter
	{
		public static function init() {
			
			remove_action( 'pre_get_posts', array( 'Realia_Filter', 'archive' ) );
			remove_action( 'pre_get_posts', array( 'Realia_Filter', 'taxonomy' ) );

			add_action( 'pre_get_posts', array( __CLASS__, 'archive' ) );
			add_action( 'pre_get_posts', array( __CLASS__, 'taxonomy' ) );
		}
		
		public static function archive( $query ) {
			$suppress_filters = ! empty( $query->query_vars['suppress_filters'] ) ? $query->query_vars['suppress_filters'] : '';
			if ( ! is_post_type_archive( 'property' ) || ! $query->is_main_query() || is_admin() || $query->query_vars['post_type'] != 'property' || $suppress_filters ) {
				return;
			}
			parent::archive($query);
			self::filter_query($query);
		}

		public static function taxonomy( $query ) {
			$is_correct_taxonomy = false;
			if ( is_tax( 'statuses' ) || is_tax( 'property_types' ) || is_tax( 'amenities' ) || is_tax( 'locations' ) || is_tax( 'materials' ) ) {
				$is_correct_taxonomy = true;
			}

			if ( ! $is_correct_taxonomy  || ! $query->is_main_query() || is_admin() ) {
				return;
			}
			parent::taxonomy($query);
			self::filter_query($query);
		}

		public static function filter_query( $query = null, $params = array() ) {
			$query = parent::filter_query($query);

			if ( ! empty( $_REQUEST['filter-amenities'] ) ) {
				$taxonomies = $query->get( 'tax_query' );
			    $taxonomies[] = array(
				    'taxonomy'  => 'amenities',
				    'field'     => 'id',
				    'terms'     => $_REQUEST['filter-amenities'],
			    );
			    $query->set( 'tax_query', $taxonomies );
		    }
		    
		    if ( ! empty( $_GET['filter-sort-order'] ) ) {
				$query->set( 'order', $_GET['filter-sort-order'] );
			} elseif ( isset($_COOKIE['filter-sort-by']) && $_COOKIE['filter-sort-by'] ) {
				$query->set( 'order', $_COOKIE['filter-sort-by'] );
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
			} elseif ( !empty($_COOKIE['filter-sort-by']) ) {
				switch ( $_COOKIE['filter-sort-by'] ) {
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
					$query->set( 'order', 'DESC' );
					$query->set( 'orderby', 'meta_value date' );
					$query->set( 'meta_key', REALIA_PROPERTY_PREFIX . 'price' );
					add_filter( 'get_meta_sql', array( 'Realia_Filter', 'filter_get_meta_sql_19653' ) );
				}
			}

		    return $query;
		}
	}
	
	Homesweet_Realia_Filter::init();
}