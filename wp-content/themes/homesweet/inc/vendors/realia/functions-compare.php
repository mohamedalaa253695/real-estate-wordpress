<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
 
add_action( 'wp_ajax_homesweet_add_to_compare', 'homesweet_add_to_compare' );
add_action( 'wp_ajax_nopriv_homesweet_add_to_compare', 'homesweet_add_to_compare' );




class Homesweet_Realia_Compare {
    
    public static function init() {
        add_action( 'wp_ajax_homesweet_add_to_compare', array( __CLASS__, 'add_to_compare' ) );
        add_action( 'wp_ajax_nopriv_homesweet_add_to_compare', array( __CLASS__, 'add_to_compare' ) );

        add_action( 'wp_ajax_homesweet_remove_compare', array( __CLASS__, 'remove_compare' ) );
        add_action( 'wp_ajax_nopriv_homesweet_remove_compare', array( __CLASS__, 'remove_compare' ) );

        add_action( 'wp_ajax_homesweet_remove_all_compare', array( __CLASS__, 'remove_all_compare' ) );
        add_action( 'wp_ajax_nopriv_homesweet_remove_all_compare', array( __CLASS__, 'remove_all_compare' ) );
    }

    public static function add_to_compare() {
        if ( isset($_POST['id']) ) {
            $comapre = array();
            if ( isset($_COOKIE['homesweet_compare']) ) {
                $compare = explode( ',', $_COOKIE['homesweet_compare'] );
                if ( !self::check_added($_POST['id'], $compare) ) {
                    $compare[] = $_POST['id'];
                }
            } else {
                $compare = array( $_POST['id'] );
            }
            setcookie( 'homesweet_compare', implode(',', $compare) , time()+3600*24*10, '/' );
            $_COOKIE['homesweet_compare'] = implode(',', $compare);

            $return = array(
                'status' => 'success',
                'msg' => Realia_Template_Loader::load( 'compares', array('compare_ids' => $compare) ),
                'count' => count($compare)
            );
        } else {
            $return = array( 'status' => 'error', 'msg' => esc_html__('Can not add property to compare', 'homesweet') );
        }
        echo json_encode( $return );
        exit();
    }

    public static function remove_compare() {
        if ( isset($_POST['id']) ) {
            $newcomapre = array();
            if ( isset($_COOKIE['homesweet_compare']) ) {
                $compare = explode( ',', $_COOKIE['homesweet_compare'] );

                foreach ($compare as $key => $value) {
                    if ( $_POST['id'] != $value ) {
                        unset($comapre[$key]);
                        $newcomapre[] = $value;
                    }
                }
            }
            setcookie( 'homesweet_compare', implode(',', $newcomapre) , time()+3600*24*10, '/' );
            $_COOKIE['homesweet_compare'] = implode(',', $newcomapre);

            $return = array(
                'status' => 'success',
                'msg' => Realia_Template_Loader::load( 'compares', array('compare_ids' => $newcomapre) ),
                'count' => count($newcomapre)
            );
        } else {
            $return = array( 'status' => 'error', 'msg' => esc_html__('Can not add property to compare', 'homesweet') );
        }
        echo json_encode( $return );
        exit();
    }

    public static function remove_all_compare() {
        $comapre = array();
        if ( isset($_COOKIE['homesweet_compare']) ) {
            setcookie( 'homesweet_compare', implode(',', $compare) , -100, '/' );
        }

        $return = array(
            'status' => 'success',
            'msg' => Realia_Template_Loader::load( 'compares', array('compare_ids' => $compare) ),
            'count' => 0
        );
        echo json_encode( $return );
        exit();
    }

    public static function get_compare_items() {
        if ( isset($_COOKIE['homesweet_compare']) && !empty($_COOKIE['homesweet_compare']) ) {
            return explode( ',', $_COOKIE['homesweet_compare'] );
        }
        return array();
    }

    public static function check_added($property_id, $compares = array()) {
        if ( empty($compares) && isset($_COOKIE['homesweet_compare']) && !empty($_COOKIE['homesweet_compare']) ) {
            $compares = explode( ',', $_COOKIE['homesweet_compare'] );
        }
        if ( in_array($property_id, $compares) ) {
            return true;
        }
        return false;
    }

    public static function display_compare_btn($post_id = null) {
        if ( empty($post_id) ) {
            $post_id = get_the_ID();
        }
        if ( homesweet_get_config('enable_compare_property', true) ) {
            $check = self::check_added($post_id);
            $link = '';
            if ( homesweet_get_config('property_compare_page_slug') ) {
                $args = array(
                    'name'        => homesweet_get_config('property_compare_page_slug'),
                    'post_type'   => 'page',
                    'post_status' => 'publish',
                    'numberposts' => 1
                );
                $s_posts = get_posts($args);
                if( $s_posts ) {
                    $link = get_permalink($s_posts[0]->ID);
                }
            }
        ?>
            <div class="property-box-compare pull-left">
                <a class="<?php echo esc_attr($check ? 'added' : ''); ?>" href="<?php echo esc_url($link); ?>" data-toggle="tooltip"
                    data-placement="top" title="<?php echo esc_attr($check ? esc_html__( 'Added Compare', 'homesweet' ) : esc_html__( 'Compare', 'homesweet' )); ?>"
                    data-id="<?php echo esc_attr($post_id); ?>">
                    <?php if ( $check ) { ?>
                        <i class="icon-ap_check-circle"></i>
                    <?php } else { ?>
                        <i class="icon-ap_plus-outline"></i>
                    <?php } ?>
                </a>
            </div>
        <?php
        }
    }

    public static function get_data($key) {
        switch ($key) {
            case 'baths':
            case 'beds':
            case 'contract':
            case 'garages':
            case 'id':
            case 'rooms':
            case 'year_built':
                $value = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . $key, true );
                break;
            // taxonomy
            case 'amenity':
                $terms = get_the_terms(get_the_ID(), 'amenities');
                $value = '';
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                    ?>
                    <ul class="list-amenities">
                    <?php
                    foreach ($terms as $term) {
                       $value .= '<li><a href="'.esc_url(get_term_link($term)).'">'.$term->name.'</a></li>';
                    }
                    ?>
                    </ul>
                    <?php
                }
                $value = ltrim($value, ', ');
                break;
            case 'property_type':
                $terms = get_the_terms(get_the_ID(), 'property_types');
                $value = '';
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                    foreach ($terms as $term) {
                       $value .= ', ' . '<a href="'.esc_url(get_term_link($term)).'">'.$term->name.'</a>';
                    }
                }
                $value = ltrim($value, ', ');
                break;
            case 'status':
                $terms = get_the_terms(get_the_ID(), 'statuses');
                $value = '';
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                    foreach ($terms as $term) {
                       $value .= ', ' . '<a href="'.esc_url(get_term_link($term)).'">'.$term->name.'</a>';
                    }
                }
                $value = ltrim($value, ', ');
                break;
            case 'material':
                $terms = get_the_terms(get_the_ID(), 'materials');
                $value = '';
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                    foreach ($terms as $term) {
                       $value .= ', ' . '<a href="'.esc_url(get_term_link($term)).'">'.$term->name.'</a>';
                    }
                }
                $value = ltrim($value, ', ');
                break;
            case 'location':
                $terms = get_the_terms(get_the_ID(), 'locations');
                $value = '';
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                    foreach ($terms as $term) {
                       $value .= ', ' . '<a href="'.esc_url(get_term_link($term)).'">'.$term->name.'</a>';
                    }
                }
                $value = ltrim($value, ', ');
                break;
            // <>
            case 'home_area':
            case 'lot_area':
                $value = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . $key, true );
                $value = $value.' '.get_theme_mod( 'realia_measurement_area_unit', 'sqft' );
                break;
            case 'price':
                $value = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . $key, true );
                $value = Realia_Price::format_price($value);
                break;
            // yes/no
            case 'featured':
            case 'reduced':
            case 'sold':
            case 'sticky':
                $value = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . $key, true );
                $value = ($value == 'on' ? '<span class="yes"><i class="icon-ap_check-circle"></i><span>' : '<span class="no"><i class="icon-ap_close"></i></span>');
                break;
            default:
                $value = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . $key, true );
                break;
        }
        return $value;
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

Homesweet_Realia_Compare::init();