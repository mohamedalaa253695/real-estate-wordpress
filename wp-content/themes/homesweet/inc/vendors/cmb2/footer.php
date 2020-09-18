<?php

if ( !function_exists( 'homesweet_footer_metaboxes' ) ) {
	function homesweet_footer_metaboxes(array $metaboxes) {
		$prefix = 'apus_footer_';
	    $fields = array(
			array(
				'name' => esc_html__( 'Footer Style', 'homesweet' ),
				'id'   => $prefix.'style_class',
				'type' => 'select',
				'options' => array(
					'lighting' => esc_html__('Lighting', 'homesweet'),
					'dark' => esc_html__('Dark', 'homesweet'),
					'boxed' => esc_html__('Boxed Light', 'homesweet')
				)
			),
    	);
		
	    $metaboxes[$prefix . 'display_setting'] = array(
			'id'                        => $prefix . 'display_setting',
			'title'                     => esc_html__( 'Display Settings', 'homesweet' ),
			'object_types'              => array( 'apus_footer' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => $fields
		);

	    return $metaboxes;
	}
}
add_filter( 'cmb2_meta_boxes', 'homesweet_footer_metaboxes' );
