<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
 
class Homesweet_Realia_Save_Search {
    
    public static function init() {
        add_action( 'wp_ajax_homesweet_save_search', array(__CLASS__, 'save_search') );
        add_action( 'wp_ajax_nopriv_homesweet_save_search', array(__CLASS__, 'save_search') );

        add_action( 'wp_ajax_homesweet_save_search_remove', array(__CLASS__, 'remove_search') );
        add_action( 'wp_ajax_nopriv_homesweet_save_search_remove', array(__CLASS__, 'remove_search') );
    }

    public static function save_search() {
        check_ajax_referer( 'ajax-save-search-nonce', 'save-search-security' );
        if ( is_user_logged_in() ) {
            $user_id = get_current_user_id();
            $datas = get_the_author_meta( 'save_search_info', $user_id );
            $datas[time()] = $_POST;
            update_user_meta( $user_id, 'save_search_info', $datas );
            $return = array( 'class' => 'text-success', 'msg' => esc_html__('Save this search successful', 'homesweet') );
        } else {
            $return = array( 'class' => 'text-error', 'msg' => esc_html__('Please login to save this search', 'homesweet') );
        }
        echo json_encode( $return );
        exit();
    }

    public static function remove_search() {
        $id = $_POST['id'];
        if ( is_user_logged_in() ) {
            $user_id = get_current_user_id();
            $datas = get_the_author_meta( 'save_search_info', $user_id );
            if ( isset($datas[$id]) ) {
                unset($datas[$id]);
            }
            update_user_meta( $user_id, 'save_search_info', $datas );
            $return = array( 'status' => 'success' );
        } else {
            $return = array( 'status' => 'error' );
        }
        echo json_encode( $return );
        exit();
    }

    public static function render_data($datas) {
        $filters = array();
        $url = get_post_type_archive_link( 'property' );
        if ( is_array($datas) ) {
            foreach ($datas as $key => $value) {
                if (preg_match('/filter-/', $key)) {
                    $url = add_query_arg( $key, $value, $url );
                    if ( !empty($value) ) {
                        $filters[$key] = self::get_data($key, $value);
                    }
                }
            }
        }
        $url = apply_filters('homesweet_render_property_page_link', $url, $datas);
        return array( 'url' => $url, 'filters' => $filters );
    }

    public static function get_data($type, $value) {
        switch ($type) {
            case 'filter-baths':
                $key = esc_html__('Baths', 'homesweet');
                break;
            case 'filter-beds':
                $key = esc_html__('Beds', 'homesweet');
                break;
            case 'filter-contract':
                $key = esc_html__('Contract', 'homesweet');
                break;
            case 'filter-garages':
                $key = esc_html__('Garages', 'homesweet');
                break;
            case 'id':
                $key = esc_html__('ID', 'homesweet');
                break;
            case 'filter-property-title':
                $key = esc_html__('Title', 'homesweet');
                break;
            case 'filter-rooms':
                $key = esc_html__('Rooms', 'homesweet');
                break;
            case 'filter-year-built':
                $key = esc_html__('Year Built', 'homesweet');
                break;
            // taxonomy
            case 'filter-amenities':
                $key = esc_html__('Amenities', 'homesweet');
                
                $terms = get_terms( array('taxonomy' => 'amenities', 'include' => $value ) );
                $value = '';
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                    foreach ($terms as $term) {
                       $value .= ', ' . $term->name;
                    }
                }
                $value = ltrim($value, ', ');
                break;
            case 'filter-property-type':
                $key = esc_html__('Type', 'homesweet');
                $term = get_term_by('id', $value, 'property_types');
                if ( !empty($term) ) {
                    $value = $term->name;
                }
                break;
            case 'filter-status':
                $key = esc_html__('Status', 'homesweet');
                $term = get_term_by('id', $value, 'statuses');
                if ( !empty($term) ) {
                    $value = $term->name;
                }
                break;
            case 'filter-material':
                $key = esc_html__('Material', 'homesweet');
                $term = get_term_by('id', $value, 'materials');
                if ( !empty($term) ) {
                    $value = $term->name;
                }
                break;
            case 'filter-location':
                $key = esc_html__('Location', 'homesweet');
                $term = get_term_by('id', $value, 'locations');
                if ( !empty($term) ) {
                    $value = $term->name;
                }
                break;
            // <>
            case 'filter-home-area-from':
                $key = esc_html__('Home Area From', 'homesweet');
                $value = $value.' '.get_theme_mod( 'realia_measurement_area_unit', 'sqft' );
                break;
            case 'filter-lot-area-from':
                $key = esc_html__('Lot Area From', 'homesweet');
                $value = $value.' '.get_theme_mod( 'realia_measurement_area_unit', 'sqft' );
                break;
            case 'filter-home-area-to':
                $key = esc_html__('Home Area To', 'homesweet');
                $value = $value.' '.get_theme_mod( 'realia_measurement_area_unit', 'sqft' );
                break;
            case 'filter-lot-area-to':
                $key = esc_html__('Lot Area To', 'homesweet');
                $value = $value.' '.get_theme_mod( 'realia_measurement_area_unit', 'sqft' );
                break;
            case 'filter-price-from':
                $key = esc_html__('Price From', 'homesweet');
                $value = Realia_Price::format_price($value);
                break;
            case 'filter-price-to':
                $key = esc_html__('Price To', 'homesweet');
                $value = Realia_Price::format_price($value);
                break;
            // yes/no
            case 'filter-featured':
                $key = esc_html__('Featured', 'homesweet');
                $value = ($value == 'on' ? esc_html__('Yes', 'homesweet') : esc_html__('No', 'homesweet'));
                break;
            case 'filter-reduced':
                $key = esc_html__('Reduced', 'homesweet');
                $value = ($value == 'on' ? esc_html__('Yes', 'homesweet') : esc_html__('No', 'homesweet'));
                break;
            case 'filter-sold':
                $key = esc_html__('Sold', 'homesweet');
                $value = ($value == 'on' ? esc_html__('Yes', 'homesweet') : esc_html__('No', 'homesweet'));
                break;
            case 'filter-sticky':
                $key = esc_html__('Sticky', 'homesweet');
                $value = ($value == 'on' ? esc_html__('Yes', 'homesweet') : esc_html__('No', 'homesweet'));
                break;
            default:
                $key = esc_html__('', 'homesweet');
                break;
        }
        return $key.': '.$value;
    }

    public static function get_property_price( $price ) {
        if ( empty( $price ) || ! is_numeric( $price ) ) {
            return false;
        }

        $price = self::format_price( $price );

        $prefix = get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'price_prefix', true );
        $suffix = get_post_meta( $post_id, REALIA_PROPERTY_PREFIX . 'price_suffix', true );

        if ( ! empty( $prefix ) ) {
            $price = $prefix . ' ' . $price;
        }

        if ( ! empty( $suffix ) ) {
            $price = $price .  ' ' . $suffix;
        }

        return $price;
    }
}

Homesweet_Realia_Save_Search::init();
