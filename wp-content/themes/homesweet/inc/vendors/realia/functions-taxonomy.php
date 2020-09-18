<?php

function homesweet_realia_enable_tax_fields($return) {
	return true;
}
add_filter( 'apus_framework_enable_tax_fields', 'homesweet_realia_enable_tax_fields' );

function homesweet_realia_types_metaboxes() {
	if ( function_exists('new_cmb2_box') && class_exists('Taxonomy_MetaData_CMB2') ) {
	    $metabox_id = 'homesweet_types_options';

	    $cmb = new_cmb2_box( array(
	        'id'           => $metabox_id,
	        'object_types' => array( 'key' => 'options-page', 'value' => array( 'unknown', ), ),
	    ) );

	    $cmb->add_field( array(
		    'name'    => esc_html__( 'Icon', 'homesweet' ),
		    'id'      => 'icon',
		    'type'    => 'file',
		    'options' => array(
		        'url' => false,
		    ),
		    'text'    => array(
		        'add_upload_file_text' => esc_html__( 'Add Icon', 'homesweet' )
		    )
		) );

	    $cats = new Taxonomy_MetaData_CMB2( 'property_types', $metabox_id );
	}
}
add_action( 'cmb2_init', 'homesweet_realia_types_metaboxes' );