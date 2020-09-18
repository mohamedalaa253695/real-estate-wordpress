<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
 
class Homesweet_Realia_Submition_Form {
    
    public static function init() {
        add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'fields_front' ), 99 );
    }

    public static function default_fields() {
        return apply_filters('realia_submition_form_default_fields', array(
            'title' => esc_html__('Title', 'homesweet'),
            'text' => esc_html__('Description', 'homesweet'),
            'featured_image' => esc_html__('Featured Image', 'homesweet'),
            'id' => esc_html__('Reference', 'homesweet'),
            'year_built' => esc_html__('Year built', 'homesweet'),
            'gallery' => esc_html__('Gallery', 'homesweet'),
            'price' => esc_html__('Price', 'homesweet'),
            'price_prefix' => esc_html__('Price Prefix', 'homesweet'),
            'price_suffix' => esc_html__('Price Suffix', 'homesweet'),
            'price_custom' => esc_html__('Price Custom', 'homesweet'),
            'rooms' => esc_html__('Rooms', 'homesweet'),
            'beds' => esc_html__('Beds', 'homesweet'),
            'baths' => esc_html__('Baths', 'homesweet'),
            'garages' => esc_html__('Garages', 'homesweet'),
            'home_area' => esc_html__('Home Area', 'homesweet'),
            'lot_dimensions' => esc_html__('Lot Dimensions', 'homesweet'),
            'lot_area' => esc_html__('Lot Area', 'homesweet'),
            'contract' => esc_html__('Contract', 'homesweet'),
            'plans' => esc_html__('Floor Plans', 'homesweet'),
            'video' => esc_html__('Video', 'homesweet'),
            'virtual_tour' => esc_html__('Virtual Tour', 'homesweet'),
            'contact_name' => esc_html__('Contact Name', 'homesweet'),
            'contact_phone' => esc_html__('Contact Phone', 'homesweet'),
            'map_location' => esc_html__('Map Location', 'homesweet'),
            'location' => esc_html__('Location', 'homesweet'),
            'status' => esc_html__('Status', 'homesweet'),
            'type' => esc_html__('Type', 'homesweet'),
            'material' => esc_html__('Material', 'homesweet'),
            'amenity' => esc_html__('Amenity', 'homesweet'),
            'parent_property' => esc_html__('Parent property', 'homesweet'),
            'public_facilities_group' => esc_html__('Public facilities', 'homesweet'),
            'valuation_group' => esc_html__('Valuation', 'homesweet')
        ));
    }

    public static function fields_front( array $metaboxes ) {
        if ( !is_admin() ) {
            if ( isset($metaboxes[ REALIA_PROPERTY_PREFIX . 'front' ]) ) {
                if ( !empty($metaboxes[ REALIA_PROPERTY_PREFIX . 'front' ]['fields']) ) {
                    $t_fields = array();
                    $fields = array();
                    foreach ($metaboxes[ REALIA_PROPERTY_PREFIX . 'front' ]['fields'] as $field) {
                        $t_fields[$field['id']] = $field;
                        // init hidden field
                        if ( $field['type'] == 'hidden' ) {
                            $fields = array( $field );
                        }
                    }
                    // extra field
                    $t_fields[REALIA_PROPERTY_PREFIX.'virtual_tour'] = array(
                        'name' => esc_html__( 'Virtual Tour', 'homesweet' ),
                        'id' => REALIA_PROPERTY_PREFIX . 'virtual_tour',
                        'type' => 'textarea_code',
                        'description' => esc_html__( 'Embed Iframe code', 'homesweet' ),
                    );
                    $t_fields[REALIA_PROPERTY_PREFIX.'price_prefix'] = array(
                        'id'                => REALIA_PROPERTY_PREFIX . 'price_prefix',
                        'name'              => esc_html__( 'Price Prefix', 'homesweet' ),
                        'type'              => 'text',
                        'description'       => esc_html__( 'Any text shown before price (for example "from").', 'homesweet' ),
                    );
                    $t_fields[REALIA_PROPERTY_PREFIX.'price_suffix'] = array(
                        'id'                => REALIA_PROPERTY_PREFIX . 'price_suffix',
                        'name'              => esc_html__( 'Price Suffix', 'homesweet' ),
                        'type'              => 'text',
                        'description'       => esc_html__( 'Any text shown after price (for example "per night").', 'homesweet' ),
                    );
                    $t_fields[REALIA_PROPERTY_PREFIX.'price_custom'] = array(
                        'id'                => REALIA_PROPERTY_PREFIX . 'price_custom',
                        'name'              => esc_html__( 'Price Custom', 'homesweet' ),
                        'type'              => 'text',
                        'description'       => esc_html__( 'Any text instead of price (for example "by agreement"). Prefix and Suffix will be ignored.', 'homesweet' ),
                    );
                    $t_fields = apply_filters( 'realia_submition_form_custom_fields', $t_fields );
                    // sort
                    $s_fields = homesweet_get_config( 'property_fields_front', array() );
                    if ( isset( $s_fields['enabled'] ) ) {
                        $s_fields = $s_fields['enabled'];
                        if ( isset($s_fields['placebo']) ) {
                            unset($s_fields['placebo']);
                        }
                        foreach ($s_fields as $key => $value) {
                            if ( isset($t_fields[REALIA_PROPERTY_PREFIX.$key]) ) {
                                $fields[] = $t_fields[REALIA_PROPERTY_PREFIX.$key];
                            }
                        }
                    }

                    $metaboxes[ REALIA_PROPERTY_PREFIX . 'front' ]['fields'] = $fields;
                }
            }
        }
        return $metaboxes;
    }

}

Homesweet_Realia_Submition_Form::init();
