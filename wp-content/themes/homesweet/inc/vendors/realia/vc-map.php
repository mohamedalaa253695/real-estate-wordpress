<?php

if( in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && function_exists('vc_map') ) {
	if ( !function_exists('homesweet_load_realia_element')) {

		function homesweet_load_realia_element() {
			$layouts = array(
				esc_html__('Mansory', 'homesweet') => 'mansory',
				esc_html__('Carousel', 'homesweet') => 'carousel',
				esc_html__('Special', 'homesweet') => 'special',
				esc_html__('List Small', 'homesweet') => 'list-small',
			);
			$contracts = array(
	            esc_html__( 'All', 'homesweet' ) => '',
	            esc_html__( 'Rent', 'homesweet' ) => 'rent',
	            esc_html__( 'Sale', 'homesweet' ) => 'sale',
	        );
	        $orderbys = array(
	        	esc_html__( 'Latest', 'homesweet' ) => 'latest',
	            esc_html__( 'Featured', 'homesweet' ) => 'featured',
	            esc_html__( 'Sticky', 'homesweet' ) => 'sticky',
	            esc_html__( 'Reduced', 'homesweet' ) => 'reduced',
	        );
	        $search_fields = array();
	        $tabed_search_fields = array();
	        if ( is_admin() ) {
		        $fields = Realia_Filter::get_fields();
		        $search_fields = array_flip($fields);
		        if ( !empty($fields['contract']) ) {
		        	unset($fields['contract']);
		        }
		        $tabed_search_fields = array_flip($fields);
		    }
		    $fields = array(
	            array(
					"type" => "dropdown",
					"heading" => esc_html__("Search Field", 'homesweet'),
					"param_name" => "field",
					"value" => $search_fields
				),
				array(
	                "type" => "textfield",
	                "heading" => esc_html__('Price Min', 'homesweet'),
	                "param_name" => "price_min",
	                "value" => '0',
	                'dependency' => array(
						'element' => 'field',
						'value' => 'price',
					),
	            ),
	            array(
	                "type" => "textfield",
	                "heading" => esc_html__('Price Max', 'homesweet'),
	                "param_name" => "price_max",
	                "value" => '1000000',
	                'dependency' => array(
						'element' => 'field',
						'value' => 'price',
					),
	            ),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Columns Width", 'homesweet'),
					"param_name" => "bcol",
					"value" => array(
						esc_html__('1/12', 'homesweet') => '1',
						esc_html__('2/12', 'homesweet') => '2',
						esc_html__('3/12', 'homesweet') => '3',
						esc_html__('4/12', 'homesweet') => '4',
						esc_html__('5/12', 'homesweet') => '5',
						esc_html__('6/12', 'homesweet') => '6',
						esc_html__('7/12', 'homesweet') => '7',
						esc_html__('8/12', 'homesweet') => '8',
						esc_html__('9/12', 'homesweet') => '9',
						esc_html__('10/12', 'homesweet') => '10',
						esc_html__('11/12', 'homesweet') => '11',
						esc_html__('12/12', 'homesweet') => '12'
					)
				)
			);
	        vc_map( array(
				'name' => esc_html__( 'Apus Filter Form', 'homesweet' ),
				'base' => 'apus_filter_form',
				'icon' => 'icon-wpb-news-12',
				"category" => esc_html__('Apus Properties', 'homesweet'),
				'description' => esc_html__( 'Show Properties Filter Form in front-end', 'homesweet' ),
				'params' => array(
					array(
		                "type" => "textfield",
		                "heading" => esc_html__('Button Text', 'homesweet'),
		                "param_name" => "button_text",
		            ),
		            array(
						"type" => "dropdown",
						"heading" => esc_html__("Button Columns Width", 'homesweet'),
						"param_name" => "button_col",
						"value" => array(
							esc_html__('1/12', 'homesweet') => '1',
							esc_html__('2/12', 'homesweet') => '2',
							esc_html__('3/12', 'homesweet') => '3',
							esc_html__('4/12', 'homesweet') => '4',
							esc_html__('5/12', 'homesweet') => '5',
							esc_html__('6/12', 'homesweet') => '6',
							esc_html__('7/12', 'homesweet') => '7',
							esc_html__('8/12', 'homesweet') => '8',
							esc_html__('9/12', 'homesweet') => '9',
							esc_html__('10/12', 'homesweet') => '10',
							esc_html__('11/12', 'homesweet') => '11',
							esc_html__('12/12', 'homesweet') => '12'
						)
					),
					array(
						'type' => 'param_group',
						'heading' => esc_html__('Fields Settings', 'homesweet' ),
						'param_name' => 'fields',
						'params' => $fields
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Show Advance Fields', 'homesweet' ),
						'param_name' => 'show_advance',
						'value' => array( esc_html__( 'Yes', 'homesweet' ) => 'yes' ),
					),
					array(
						'type' => 'param_group',
						'heading' => esc_html__('Advance Fields Settings', 'homesweet' ),
						'param_name' => 'advance_fields',
						'params' => $fields,
						'dependency' => array(
							'element' => 'show_advance',
							'value' => 'yes',
						),
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'homesweet'),
						"param_name" => "style",
						"value" => array(
							esc_html__("Home 1", 'homesweet') => 'home1',
							esc_html__("Home 2", 'homesweet') => 'home2',
							esc_html__("Home 4", 'homesweet') => 'home4',
							esc_html__("Home 6", 'homesweet') => 'home6',
						)
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'homesweet' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homesweet' )
					)
				)
			) );

	        $fields = array(
	            array(
					"type" => "dropdown",
					"heading" => esc_html__("Search Field", 'homesweet'),
					"param_name" => "field",
					"value" => $tabed_search_fields
				),
				array(
	                "type" => "textfield",
	                "heading" => esc_html__('Price Min', 'homesweet'),
	                "param_name" => "price_min",
	                "value" => '0',
	                'dependency' => array(
						'element' => 'field',
						'value' => 'price',
					),
	            ),
	            array(
	                "type" => "textfield",
	                "heading" => esc_html__('Price Max', 'homesweet'),
	                "param_name" => "price_max",
	                "value" => '1000000',
	                'dependency' => array(
						'element' => 'field',
						'value' => 'price',
					),
	            ),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Columns Width", 'homesweet'),
					"param_name" => "bcol",
					"value" => array(
						esc_html__('1/12', 'homesweet') => '1',
						esc_html__('2/12', 'homesweet') => '2',
						esc_html__('3/12', 'homesweet') => '3',
						esc_html__('4/12', 'homesweet') => '4',
						esc_html__('5/12', 'homesweet') => '5',
						esc_html__('6/12', 'homesweet') => '6',
						esc_html__('7/12', 'homesweet') => '7',
						esc_html__('8/12', 'homesweet') => '8',
						esc_html__('9/12', 'homesweet') => '9',
						esc_html__('10/12', 'homesweet') => '10',
						esc_html__('11/12', 'homesweet') => '11',
						esc_html__('12/12', 'homesweet') => '12'
					)
				)
			);
	        vc_map( array(
				'name' => esc_html__( 'Apus Tabed Filter Form', 'homesweet' ),
				'base' => 'apus_tabed_filter_form',
				'icon' => 'icon-wpb-news-12',
				"category" => esc_html__('Apus Properties', 'homesweet'),
				'description' => esc_html__( 'Show Properties Filter Form in front-end', 'homesweet' ),
				'params' => array(
					array(
		                "type" => "textfield",
		                "heading" => esc_html__('Button Text', 'homesweet'),
		                "param_name" => "button_text",
		            ),
		            array(
						"type" => "dropdown",
						"heading" => esc_html__("Button Columns Width", 'homesweet'),
						"param_name" => "button_col",
						"value" => array(
							esc_html__('1/12', 'homesweet') => '1',
							esc_html__('2/12', 'homesweet') => '2',
							esc_html__('3/12', 'homesweet') => '3',
							esc_html__('4/12', 'homesweet') => '4',
							esc_html__('5/12', 'homesweet') => '5',
							esc_html__('6/12', 'homesweet') => '6',
							esc_html__('7/12', 'homesweet') => '7',
							esc_html__('8/12', 'homesweet') => '8',
							esc_html__('9/12', 'homesweet') => '9',
							esc_html__('10/12', 'homesweet') => '10',
							esc_html__('11/12', 'homesweet') => '11',
							esc_html__('12/12', 'homesweet') => '12'
						)
					),
					array(
						'type' => 'param_group',
						'heading' => esc_html__('Fields Settings', 'homesweet' ),
						'param_name' => 'fields',
						'params' => $fields
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Show Advance Fields', 'homesweet' ),
						'param_name' => 'show_advance',
						'value' => array( esc_html__( 'Yes', 'homesweet' ) => 'yes' ),
					),
					array(
						'type' => 'param_group',
						'heading' => esc_html__('Advance Fields Settings', 'homesweet' ),
						'param_name' => 'advance_fields',
						'params' => $fields,
						'dependency' => array(
							'element' => 'show_advance',
							'value' => 'yes',
						),
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'homesweet'),
						"param_name" => "style",
						"value" => array(
							esc_html__("Home 3", 'homesweet') => 'home3',
							esc_html__("Home 5", 'homesweet') => 'home5',
						)
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'homesweet' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homesweet' )
					)
				)
			) );

			vc_map( array(
				'name' => esc_html__( 'Apus Properties', 'homesweet' ),
				'base' => 'apus_properties',
				'icon' => 'icon-wpb-news-12',
				"category" => esc_html__('Apus Properties', 'homesweet'),
				'description' => esc_html__( 'Show Properties in front-end', 'homesweet' ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Title', 'homesweet' ),
						'param_name' => 'title'
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Sub Title', 'homesweet' ),
						'param_name' => 'sub_title'
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Number Properties', 'homesweet' ),
						'param_name' => 'number',
						"value" => 4
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Get Properties By", 'homesweet'),
						"param_name" => "orderby",
						"value" => $orderbys
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Property Contracts", 'homesweet'),
						"param_name" => "contract",
						"value" => $contracts
					),
					array(
					    'type' => 'autocomplete',
					    'heading' => esc_html__( 'Property Types', 'homesweet' ),
					    'param_name' => 'types',
					    "admin_label" => true,
					    'description' => esc_html__( 'Choose types if you want to show properties of them', 'homesweet' ),
					    'settings' => array(
					     	'multiple' => true,
					     	'unique_values' => true
					    ),
				   	),
				   	array(
					    'type' => 'autocomplete',
					    'heading' => esc_html__( 'Property Statuses', 'homesweet' ),
					    'param_name' => 'statuses',
					    "admin_label" => true,
					    'description' => esc_html__( 'Choose Statuses if you want to show properties of them', 'homesweet' ),
					    'settings' => array(
					     	'multiple' => true,
					     	'unique_values' => true
					    ),
				   	),
				   	array(
					    'type' => 'autocomplete',
					    'heading' => esc_html__( 'Property Locations', 'homesweet' ),
					    'param_name' => 'locations',
					    "admin_label" => true,
					    'description' => esc_html__( 'Choose Locations if you want to show properties of them', 'homesweet' ),
					    'settings' => array(
					     	'multiple' => true,
					     	'unique_values' => true
					    ),
				   	),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Layout Type", 'homesweet'),
						"param_name" => "layout_type",
						"value" => $layouts
					),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Columns','homesweet'),
		                "param_name" => 'columns',
		                "value" => array(1,2,3,4,5,6),
		                'dependency' => array(
							'element' => 'layout_type',
							'value' => array('mansory', 'carousel','grid'),
						),
		            ),
		            array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Item Style','homesweet'),
		                "param_name" => 'item_style',
		                "value" => array(
		                	esc_html__('Style 1', 'homesweet') => '',
		                	esc_html__('Style 2', 'homesweet') => 'style1',
	                	),
	                	'dependency' => array(
							'element' => 'layout_type',
							'value' => array('mansory', 'carousel'),
						),
		            ),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Navigator Style','homesweet'),
		                "param_name" => 'nav_style',
		                "value" => array(
		                	esc_html__('Default','homesweet') => '',
		                	esc_html__('Style 1','homesweet') => 'style1',
		                	esc_html__('Style 2 for Top ','homesweet') => 'style2',
	                	),
	                	'dependency' => array(
							'element' => 'layout_type',
							'value' => 'carousel',
						),
		            ),
		            array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Show Pagination', 'homesweet' ),
						'param_name' => 'show_pagination',
						'value' => array( esc_html__( 'Yes', 'homesweet' ) => 'yes' ),
						'dependency' => array(
							'element' => 'layout_type',
							'value' => 'carousel',
						),
					),
		            array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Show Contract Filter', 'homesweet' ),
						'param_name' => 'show_contract_filter',
						'value' => array( esc_html__( 'Yes', 'homesweet' ) => 'yes' ),
						'dependency' => array(
							'element' => 'layout_type',
							'value' => array('mansory'),
						),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Show View More Button', 'homesweet' ),
						'param_name' => 'show_viewmore_button',
						'value' => array( esc_html__( 'Yes', 'homesweet' ) => 'yes' ),
						'dependency' => array(
							'element' => 'layout_type',
							'value' => array('mansory'),
						),
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'homesweet' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homesweet' )
					)
				)
			) );

			vc_map( array(
				'name' => esc_html__( 'Apus Agents', 'homesweet' ),
				'base' => 'apus_agents',
				'icon' => 'icon-wpb-news-12',
				"category" => esc_html__('Apus Properties', 'homesweet'),
				'description' => esc_html__( 'Show Agents in front-end', 'homesweet' ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Number Agents', 'homesweet' ),
						'param_name' => 'number',
						"value" => 4
					),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Columns','homesweet'),
		                "param_name" => 'columns',
		                "value" => array(1,2,3,4,5,6),
		            ),
		            array(
						"type" => "dropdown",
						"heading" => esc_html__("Layout Type", 'homesweet'),
						"param_name" => "layout_type",
						"value" => array(
							esc_html__('Grid', 'homesweet') => 'grid',
							esc_html__('Carousel', 'homesweet') => 'carousel',
						)
					),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Navigator Style','homesweet'),
		                "param_name" => 'nav_style',
		                "value" => array(
		                	esc_html__('Default','homesweet') => '',
		                	esc_html__('Style 1 for Top ','homesweet') => 'style1',
	                	),
	                	'dependency' => array(
							'element' => 'layout_type',
							'value' => 'carousel',
						),
		            ),
		            array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'homesweet' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homesweet' )
					)
				)
			) );

			vc_map( array(
				'name' => esc_html__( 'Apus Properties Slider', 'homesweet' ),
				'base' => 'apus_properties_slider',
				'icon' => 'icon-wpb-news-12',
				"category" => esc_html__('Apus Properties', 'homesweet'),
				'description' => esc_html__( 'Show Properties Slider in front-end', 'homesweet' ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Number Properties', 'homesweet' ),
						'param_name' => 'number',
						"value" => 3
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Get Properties By", 'homesweet'),
						"param_name" => "orderby",
						"value" => $orderbys
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Property Contracts", 'homesweet'),
						"param_name" => "contract",
						"value" => $contracts
					),
					array(
					    'type' => 'autocomplete',
					    'heading' => esc_html__( 'Property Types', 'homesweet' ),
					    'param_name' => 'types',
					    "admin_label" => true,
					    'description' => esc_html__( 'Choose types if you want to show properties of them', 'homesweet' ),
					    'settings' => array(
					     	'multiple' => true,
					     	'unique_values' => true
					    ),
				   	),
				   	array(
					    'type' => 'autocomplete',
					    'heading' => esc_html__( 'Property Statuses', 'homesweet' ),
					    'param_name' => 'statuses',
					    "admin_label" => true,
					    'description' => esc_html__( 'Choose Statuses if you want to show properties of them', 'homesweet' ),
					    'settings' => array(
					     	'multiple' => true,
					     	'unique_values' => true
					    ),
				   	),
				   	array(
					    'type' => 'autocomplete',
					    'heading' => esc_html__( 'Property Locations', 'homesweet' ),
					    'param_name' => 'locations',
					    "admin_label" => true,
					    'description' => esc_html__( 'Choose Locations if you want to show properties of them', 'homesweet' ),
					    'settings' => array(
					     	'multiple' => true,
					     	'unique_values' => true
					    ),
				   	),
				   	array(
						"type" => "dropdown",
						"heading" => esc_html__("Layout Type", 'homesweet'),
						"param_name" => "style",
						"value" => array(
							esc_html__("Layout 1", 'homesweet') => 'layout1',
							esc_html__("Layout 2", 'homesweet') => 'layout2',
							esc_html__("Layout 3", 'homesweet') => 'layout3',
						)
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Columns", 'homesweet'),
						"param_name" => "columns",
						"value" => array(1,2,3,4,5,6)
					),
		            array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'homesweet' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homesweet' )
					)
				)
			) );
			
			vc_map( array(
				'name' => esc_html__( 'Apus Properties Map', 'homesweet' ),
				'base' => 'apus_properties_map',
				'icon' => 'icon-wpb-news-12',
				"category" => esc_html__('Apus Properties', 'homesweet'),
				'description' => esc_html__( 'Show Properties Map in front-end', 'homesweet' ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Number Properties', 'homesweet' ),
						'param_name' => 'number',
						"value" => 3
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Get Properties By", 'homesweet'),
						"param_name" => "orderby",
						"value" => $orderbys
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Property Contracts", 'homesweet'),
						"param_name" => "contract",
						"value" => $contracts
					),
					array(
					    'type' => 'autocomplete',
					    'heading' => esc_html__( 'Property Types', 'homesweet' ),
					    'param_name' => 'types',
					    "admin_label" => true,
					    'description' => esc_html__( 'Choose types if you want to show properties of them', 'homesweet' ),
					    'settings' => array(
					     	'multiple' => true,
					     	'unique_values' => true
					    ),
				   	),
				   	array(
					    'type' => 'autocomplete',
					    'heading' => esc_html__( 'Property Statuses', 'homesweet' ),
					    'param_name' => 'statuses',
					    "admin_label" => true,
					    'description' => esc_html__( 'Choose Statuses if you want to show properties of them', 'homesweet' ),
					    'settings' => array(
					     	'multiple' => true,
					     	'unique_values' => true
					    ),
				   	),
				   	array(
					    'type' => 'autocomplete',
					    'heading' => esc_html__( 'Property Locations', 'homesweet' ),
					    'param_name' => 'locations',
					    "admin_label" => true,
					    'description' => esc_html__( 'Choose Locations if you want to show properties of them', 'homesweet' ),
					    'settings' => array(
					     	'multiple' => true,
					     	'unique_values' => true
					    ),
				   	),
				   	array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Height Map Properties', 'homesweet' ),
						'param_name' => 'height',
					),
		            array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'homesweet' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homesweet' )
					)
				)
			) );

			vc_map( array(
				'name' => esc_html__( 'Apus Location Banner', 'homesweet' ),
				'base' => 'apus_location_banner',
				'icon' => 'icon-wpb-news-12',
				"category" => esc_html__('Apus Properties', 'homesweet'),
				'description' => esc_html__( 'Show Location Banner in front-end', 'homesweet' ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Title', 'homesweet' ),
						'param_name' => 'title'
					),
					array(
						"type" => "attach_image",
						"heading"	=> esc_html__('Image', 'homesweet' ),
						"param_name" => "image",
					),
				   	array(
					    'type' => 'autocomplete',
					    'heading' => esc_html__( 'Choose Property Location', 'homesweet' ),
					    'param_name' => 'location',
					    "admin_label" => true,
					    'description' => esc_html__( 'Choose Location', 'homesweet' ),
					    'settings' => array(
					     	'multiple' => false,
					     	'unique_values' => true
					    ),
				   	),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'homesweet' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homesweet' )
					)
				)
			) );

			vc_map( array(
				'name'        => esc_html__( 'Apus Property Favorites','homesweet'),
				'base'        => 'apus_property_favorites',
				"category" => esc_html__('Apus Properties', 'homesweet'),
				'description' => esc_html__( 'Display property favorites form in frontend', 'homesweet' ),
				"params"      => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'homesweet' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homesweet' )
					)
				),
			));

			vc_map( array(
				'name'        => esc_html__( 'Apus Search Page Saved','homesweet'),
				'base'        => 'apus_search_page_saved',
				"category" => esc_html__('Apus Properties', 'homesweet'),
				'description' => esc_html__( 'Display property favorites form in frontend', 'homesweet' ),
				"params"      => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'homesweet' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homesweet' )
					)
				),
			));

			vc_map( array(
				'name'        => esc_html__( 'Apus Properties Compare','homesweet'),
				'base'        => 'apus_properties_compare',
				"category" => esc_html__('Apus Properties', 'homesweet'),
				'description' => esc_html__( 'Display Properties Compare form in frontend', 'homesweet' ),
				"params"      => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'homesweet' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homesweet' )
					)
				),
			));
			$packages = array();
			if ( is_admin() ) {
				$agrs = array(
					'post_type' => 'package',
					'posts_per_page' => -1,
					'post_status' => 'publish'
				);
				$posts = get_posts($agrs);
				foreach ($posts as $post) {
					$packages[$post->post_name] = $post->post_title;
				}
			}

			vc_map( array(
				'name'        => esc_html__( 'Apus Package Pricing','homesweet'),
				'base'        => 'apus_package',
				"category" => esc_html__('Apus Properties', 'homesweet'),
				'description' => esc_html__( 'Display Properties Compare form in frontend', 'homesweet' ),
				"params"      => array(
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Choose a package", 'homesweet'),
						"param_name" => "package",
						"value" => $packages
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Is Featured ?', 'homesweet' ),
						'param_name' => 'is_featured',
						'value' => array( esc_html__( 'Yes', 'homesweet' ) => 'yes' ),
					),
					array(
		                "type" => "textfield",
		                "heading" => esc_html__('Label', 'homesweet'),
		                "param_name" => 'label',
	                	'dependency' => array(
							'element' => 'is_featured',
							'not_empty' => true,
						),
		            ),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'homesweet' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homesweet' )
					)
				),
			));
		}
	}
	add_action( 'vc_after_set_mode', 'homesweet_load_realia_element', 99 );

	class WPBakeryShortCode_apus_filter_form extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_tabed_filter_form extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_properties extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_agents extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_properties_slider extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_properties_map extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_location_banner extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_property_favorites extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_search_page_saved extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_properties_compare extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_package extends WPBakeryShortCode {}
}