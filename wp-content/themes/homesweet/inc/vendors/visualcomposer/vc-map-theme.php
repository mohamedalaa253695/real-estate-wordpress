<?php
if ( function_exists('vc_map') && class_exists('WPBakeryShortCode') ) {
	if ( !function_exists('homesweet_load_load_theme_element')) {
		function homesweet_load_load_theme_element() {
			$columns = array(1,2,3,4,6);
			// Heading Text Block
			vc_map( array(
				'name'        => esc_html__( 'Apus Widget Heading','homesweet'),
				'base'        => 'apus_title_heading',
				"class"       => "",
				"category" => esc_html__('Apus Elements', 'homesweet'),
				'description' => esc_html__( 'Create title for one Widget', 'homesweet' ),
				"params"      => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Widget title', 'homesweet' ),
						'param_name' => 'title',
						'description' => esc_html__( 'Enter heading title.', 'homesweet' ),
						"admin_label" => true,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Sub title', 'homesweet' ),
						'param_name' => 'sub_title',
						'description' => esc_html__( 'Enter Sub heading title.', 'homesweet' ),
						"admin_label" => true,
					),
					array(
						"type" => "textarea",
						'heading' => esc_html__( 'Description', 'homesweet' ),
						"param_name" => "descript",
						"value" => '',
						'description' => esc_html__( 'Enter description for title.', 'homesweet' )
				    ),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'homesweet'),
						"param_name" => "style",
						'value' 	=> array(
							esc_html__('Default Underline', 'homesweet') => 'default', 
							esc_html__('Default Center', 'homesweet') => 'no-line', 
							esc_html__('White', 'homesweet') => 'white', 
							esc_html__('White Center', 'homesweet') => 'white-center', 
							esc_html__('Small Underline', 'homesweet') => 'small', 
						),
						'std' => ''
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'homesweet' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homesweet' )
					)
				),
			));

			// calltoaction
			vc_map( array(
				'name'        => esc_html__( 'Apus Widget Call To Action','homesweet'),
				'base'        => 'apus_call_action',
				"class"       => "",
				"category" => esc_html__('Apus Elements', 'homesweet'),
				'description' => esc_html__( 'Create title for one Widget', 'homesweet' ),
				"params"      => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Widget title', 'homesweet' ),
						'param_name' => 'title',
						'value'       => esc_html__( 'Title', 'homesweet' ),
						'description' => esc_html__( 'Enter heading title.', 'homesweet' ),
						"admin_label" => true
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Sub title', 'homesweet' ),
						'param_name' => 'subtitle',
						'description' => esc_html__( 'Enter Sub title.', 'homesweet' ),
						"admin_label" => true
					),
					array(
						"type" => "textarea_html",
						'heading' => esc_html__( 'Description', 'homesweet' ),
						"param_name" => "content",
						"value" => '',
						'description' => esc_html__( 'Enter description for title.', 'homesweet' )
				    ),

				    array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Text Button 1', 'homesweet' ),
						'param_name' => 'textbutton1',
						'description' => esc_html__( 'Text Button', 'homesweet' ),
						"admin_label" => true
					),

					array(
						'type' => 'textfield',
						'heading' => esc_html__( ' Link Button 1', 'homesweet' ),
						'param_name' => 'linkbutton1',
						'description' => esc_html__( 'Link Button 1', 'homesweet' ),
						"admin_label" => true
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Button Style", 'homesweet'),
						"param_name" => "buttons1",
						'value' 	=> array(
							esc_html__('Default ', 'homesweet') => 'btn-default ', 
							esc_html__('Primary ', 'homesweet') => 'btn-primary ', 
							esc_html__('Success ', 'homesweet') => 'btn-success radius-0 ', 
							esc_html__('Info ', 'homesweet') => 'btn-info ', 
							esc_html__('Warning ', 'homesweet') => 'btn-warning ', 
							esc_html__('Theme Color ', 'homesweet') => 'btn-theme',
							esc_html__('Theme Gradient Color ', 'homesweet') => 'btn-theme btn-gradient',
							esc_html__('Second Color ', 'homesweet') => 'btn-theme-second',
							esc_html__('Danger ', 'homesweet') => 'btn-danger ', 
							esc_html__('Pink ', 'homesweet') => 'btn-pink ', 
							esc_html__('White Gradient ', 'homesweet') => 'btn-white btn-gradient', 
							esc_html__('Primary Outline', 'homesweet') => 'btn-primary btn-outline', 
							esc_html__('White Outline ', 'homesweet') => 'btn-white btn-outline ',
							esc_html__('Theme Outline ', 'homesweet') => 'btn-theme btn-outline ',
						),
						'std' => ''
					),

					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Text Button 2', 'homesweet' ),
						'param_name' => 'textbutton2',
						'description' => esc_html__( 'Text Button', 'homesweet' ),
						"admin_label" => true
					),

					array(
						'type' => 'textfield',
						'heading' => esc_html__( ' Link Button 2', 'homesweet' ),
						'param_name' => 'linkbutton2',
						'description' => esc_html__( 'Link Button 2', 'homesweet' ),
						"admin_label" => true
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Button Style", 'homesweet'),
						"param_name" => "buttons2",
						'value' 	=> array(
							esc_html__('Default ', 'homesweet') => 'btn-default ', 
							esc_html__('Primary ', 'homesweet') => 'btn-primary ', 
							esc_html__('Success ', 'homesweet') => 'btn-success radius-0 ', 
							esc_html__('Info ', 'homesweet') => 'btn-info ', 
							esc_html__('Warning ', 'homesweet') => 'btn-warning ', 
							esc_html__('Theme Color ', 'homesweet') => 'btn-theme',
							esc_html__('Second Color ', 'homesweet') => 'btn-theme-second',
							esc_html__('Danger ', 'homesweet') => 'btn-danger ', 
							esc_html__('Pink ', 'homesweet') => 'btn-pink ', 
							esc_html__('White Gradient ', 'homesweet') => 'btn-white btn-gradient',
							esc_html__('Primary Outline', 'homesweet') => 'btn-primary btn-outline', 
							esc_html__('White Outline ', 'homesweet') => 'btn-white btn-outline ',
							esc_html__('Theme Outline ', 'homesweet') => 'btn-theme btn-outline ',
						),
						'std' => ''
					),
					
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'homesweet'),
						"param_name" => "style",
						'value' 	=> array(
							esc_html__('Default', 'homesweet') => 'default',
							esc_html__('Center', 'homesweet') => 'default center',
						),
						'std' => ''
					),

					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'homesweet' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homesweet' )
					)
				),
			));
			
			// Apus Counter
			vc_map( array(
			    "name" => esc_html__("Apus Counter",'homesweet'),
			    "base" => "apus_counter",
			    "class" => "",
			    "description"=> esc_html__('Counting number with your term', 'homesweet'),
			    "category" => esc_html__('Apus Elements', 'homesweet'),
			    "params" => array(
			    	array(
						"type" => "attach_image",
						"description" => esc_html__("Image for box.", 'homesweet'),
						"param_name" => "image",
						"value" => '',
						'heading'	=> esc_html__('Image', 'homesweet' )
					),
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'homesweet'),
						"param_name" => "title",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Number", 'homesweet'),
						"param_name" => "number",
						"value" => ''
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Sub Number", 'homesweet'),
						"param_name" => "sub",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Color Title", 'homesweet'),
						"param_name" => "text_color",
						'value' 	=> '',
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'homesweet'),
						"param_name" => "style",
						'value' 	=> array(
							esc_html__('Default', 'homesweet') => '', 
							esc_html__('Left Icon', 'homesweet') => 'left_icon', 
						),
						'std' => ''
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'homesweet'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'homesweet')
					)
			   	)
			));
			// Banner CountDown
			vc_map( array(
				'name'        => esc_html__( 'Apus Banner CountDown','homesweet'),
				'base'        => 'apus_banner_countdown',
				"class"       => "",
				"category" => esc_html__('Apus Elements', 'homesweet'),
				'description' => esc_html__( 'Show CountDown with banner', 'homesweet' ),
				"params"      => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Widget title', 'homesweet' ),
						'param_name' => 'title',
						'value'       => esc_html__( 'Title', 'homesweet' ),
						'description' => esc_html__( 'Enter heading title.', 'homesweet' ),
						"admin_label" => true
					),

					array(
						"type" => "textarea",
						'heading' => esc_html__( 'Description', 'homesweet' ),
						"param_name" => "descript",
						"value" => '',
						'description' => esc_html__( 'Enter description for title.', 'homesweet' )
				    ),
					array(
					    'type' => 'textfield',
					    'heading' => esc_html__( 'Date Expired', 'homesweet' ),
					    'param_name' => 'input_datetime'
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'homesweet'),
						"param_name" => "style_widget",
						'value' 	=> array(
							esc_html__('White Center Absolute', 'homesweet') => 'white_absolute', 
							esc_html__('Dark Center Absolute', 'homesweet') => 'dark_absolute', 
							esc_html__('Red Center Absolute', 'homesweet') => 'red_absolute', 
						),
						'std' => ''
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'homesweet' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homesweet' )
					),
				),
			));
			// Apus Brands
			vc_map( array(
			    "name" => esc_html__("Apus Brands",'homesweet'),
			    "base" => "apus_brands",
			    "class" => "",
			    "description"=> esc_html__('Display brands on front end', 'homesweet'),
			    "category" => esc_html__('Apus Elements', 'homesweet'),
			    "params" => array(
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'homesweet'),
						"param_name" => "title",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Number", 'homesweet'),
						"param_name" => "number",
						"value" => ''
					),
				 	array(
						"type" => "dropdown",
						"heading" => esc_html__("Layout Type", 'homesweet'),
						"param_name" => "layout_type",
						'value' 	=> array(
							esc_html__('Carousel', 'homesweet') => 'carousel', 
							esc_html__('Grid', 'homesweet') => 'grid'
						),
						'std' => ''
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Style Type", 'homesweet'),
						"param_name" => "style",
						'value' 	=> array(
							esc_html__('Default', 'homesweet') => '', 
						),
						'std' => ''
					),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Columns','homesweet'),
		                "param_name" => 'columns',
		                "value" => array(1,2,3,4,5,6),
		            ),

					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'homesweet'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'homesweet')
					)
			   	)
			));
			
			vc_map( array(
			    "name" => esc_html__("Apus Socials link",'homesweet'),
			    "base" => "apus_socials_link",
			    "description"=> esc_html__('Show socials link', 'homesweet'),
			    "category" => esc_html__('Apus Elements', 'homesweet'),
			    "params" => array(
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'homesweet'),
						"param_name" => "title",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__("Description", 'homesweet'),
						"param_name" => "description",
						"value" => '',
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Facebook Page URL", 'homesweet'),
						"param_name" => "facebook_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Twitter Page URL", 'homesweet'),
						"param_name" => "twitter_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Youtube Page URL", 'homesweet'),
						"param_name" => "youtube_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Pinterest Page URL", 'homesweet'),
						"param_name" => "pinterest_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Google Plus Page URL", 'homesweet'),
						"param_name" => "google-plus_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Instagram Page URL", 'homesweet'),
						"param_name" => "instagram_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Align", 'homesweet'),
						"param_name" => "align",
						'value' 	=> array(
							esc_html__('Left', 'homesweet') => '', 
							esc_html__('Right', 'homesweet') => 'right',
							esc_html__('Center', 'homesweet') => 'center',
						),
						'std' => ''
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'homesweet'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'homesweet')
					)
			   	)
			));
			// newsletter
			vc_map( array(
			    "name" => esc_html__("Apus Newsletter",'homesweet'),
			    "base" => "apus_newsletter",
			    "class" => "",
			    "description"=> esc_html__('Show newsletter form', 'homesweet'),
			    "category" => esc_html__('Apus Elements', 'homesweet'),
			    "params" => array(
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'homesweet'),
						"param_name" => "title",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__("Description", 'homesweet'),
						"param_name" => "description",
						"value" => '',
					),
					array(
		                'type' => 'dropdown',
		                'heading' => esc_html__( 'Style', 'homesweet' ),
		                'param_name' => 'style',
		                'value' => array(
		                    esc_html__( 'Style 1', 'homesweet' ) 	=> 'style1',
		                    esc_html__( 'Style 2', 'homesweet' ) 	=> 'style2',
		                    esc_html__( 'Style 2 White', 'homesweet' ) 	=> 'style2 white',
		                )
		            ),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'homesweet'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'homesweet')
					)
			   	)
			));
			// google map
			$map_styles = array( esc_html__('Choose a map style', 'homesweet') => '' );
			if ( is_admin() && class_exists('Homesweet_Google_Maps_Styles') ) {
				$styles = Homesweet_Google_Maps_Styles::styles();
				foreach ($styles as $style) {
					$map_styles[$style['title']] = $style['slug'];
				}
			}
			vc_map( array(
			    "name" => esc_html__("Apus Google Map",'homesweet'),
			    "base" => "apus_googlemap",
			    "description" => esc_html__('Diplay Google Map', 'homesweet'),
			    "category" => esc_html__('Apus Elements', 'homesweet'),
			    "params" => array(
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'homesweet'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => '',
					),
					array(
		                "type" => "textarea",
		                "class" => "",
		                "heading" => esc_html__('Description','homesweet'),
		                "param_name" => "des",
		            ),
		            array(
		                'type' => 'googlemap',
		                'heading' => esc_html__( 'Location', 'homesweet' ),
		                'param_name' => 'location',
		                'value' => ''
		            ),
		            array(
		                'type' => 'hidden',
		                'heading' => esc_html__( 'Latitude Longitude', 'homesweet' ),
		                'param_name' => 'lat_lng',
		                'value' => '21.0173222,105.78405279999993'
		            ),
		            array(
						"type" => "textfield",
						"heading" => esc_html__("Map height", 'homesweet'),
						"param_name" => "height",
						"value" => '',
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Map Zoom", 'homesweet'),
						"param_name" => "zoom",
						"value" => '13',
					),
		            array(
		                'type' => 'dropdown',
		                'heading' => esc_html__( 'Map Type', 'homesweet' ),
		                'param_name' => 'type',
		                'value' => array(
		                    esc_html__( 'roadmap', 'homesweet' ) 		=> 'ROADMAP',
		                    esc_html__( 'hybrid', 'homesweet' ) 	=> 'HYBRID',
		                    esc_html__( 'satellite', 'homesweet' ) 	=> 'SATELLITE',
		                    esc_html__( 'terrain', 'homesweet' ) 	=> 'TERRAIN',
		                )
		            ),
		            array(
						"type" => "attach_image",
						"heading" => esc_html__("Custom Marker Icon", 'homesweet'),
						"param_name" => "marker_icon"
					),
					array(
		                'type' => 'dropdown',
		                'heading' => esc_html__( 'Custom Map Style', 'homesweet' ),
		                'param_name' => 'map_style',
		                'value' => $map_styles
		            ),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'homesweet'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'homesweet')
					)
			   	)
			));
			// Testimonial
			vc_map( array(
	            "name" => esc_html__("Apus Testimonials",'homesweet'),
	            "base" => "apus_testimonials",
	            'description'=> esc_html__('Display Testimonials In FrontEnd', 'homesweet'),
	            "class" => "",
	            "category" => esc_html__('Apus Elements', 'homesweet'),
	            "params" => array(
	              	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'homesweet'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => '',
					),
	              	array(
		              	"type" => "textfield",
		              	"heading" => esc_html__("Number Show", 'homesweet'),
		              	"param_name" => "number",
		              	"value" => '4',
		            ),
		            array(
		              	"type" => "textfield",
		              	"heading" => esc_html__("Columns", 'homesweet'),
		              	"param_name" => "columns",
		              	"value" => '1',
		            ),
		            array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Layout','homesweet'),
		                "param_name" => 'style',
		                'value' 	=> array(
							esc_html__('Background White ', 'homesweet') => 'bg-white', 
							esc_html__('Dark ', 'homesweet') => 'dark',
						),
						'std' => ''
		            ),
		            array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'homesweet'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'homesweet')
					)
	            )
	        ));
	        // Our Team
			vc_map( array(
	            "name" => esc_html__("Apus Our Team",'homesweet'),
	            "base" => "apus_ourteam",
	            'description'=> esc_html__('Display Our Team In FrontEnd', 'homesweet'),
	            "class" => "",
	            "category" => esc_html__('Apus Elements', 'homesweet'),
	            "params" => array(
	              	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'homesweet'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => '',
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Sub Title", 'homesweet'),
						"param_name" => "subtitle",
						"admin_label" => true,
						"value" => '',
					),
	              	array(
						'type' => 'param_group',
						'heading' => esc_html__('Members Settings', 'homesweet' ),
						'param_name' => 'members',
						'description' => '',
						'value' => '',
						'params' => array(
							array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Name','homesweet'),
				                "param_name" => "name",
				            ),
				            array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Short Description','homesweet'),
				                "param_name" => "des",
				            ),
							array(
								"type" => "attach_image",
								"heading" => esc_html__("Image", 'homesweet'),
								"param_name" => "image"
							),

				            array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Facebook','homesweet'),
				                "param_name" => "facebook",
				            ),

				            array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Twitter Link','homesweet'),
				                "param_name" => "twitter",
				            ),

				            array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Google plus Link','homesweet'),
				                "param_name" => "google",
				            ),

				            array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Linkin Link','homesweet'),
				                "param_name" => "linkin",
				            ),

						),
					),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Columns','homesweet'),
		                "param_name" => 'columns',
		                "value" => array(1,2,3,4,5,6),
		            ),
		            array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'homesweet'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'homesweet')
					)
	            )
	        ));

	        // Gallery Images
			vc_map( array(
	            "name" => esc_html__("Apus Gallery",'homesweet'),
	            "base" => "apus_gallery",
	            'description'=> esc_html__('Display Gallery In FrontEnd', 'homesweet'),
	            "class" => "",
	            "category" => esc_html__('Apus Elements', 'homesweet'),
	            "params" => array(
	              	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'homesweet'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => '',
					),
	              	array(
						"type" => "attach_images",
						"heading" => esc_html__("Images", 'homesweet'),
						"param_name" => "images"
					),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Columns','homesweet'),
		                "param_name" => 'columns',
		                "value" => $columns
		            ),
		            array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Row','homesweet'),
		                "param_name" => 'rows',
		                "value" => array(1,2),
		            ),
		            array(
						"type" => "textarea",
						'heading' => esc_html__( 'Description', 'homesweet' ),
						"param_name" => "description",
						"value" => '',
						'description' => esc_html__( 'This field is used for Style 2.', 'homesweet' )
				    ),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Layout','homesweet'),
		                "param_name" => 'style',
		                'value' 	=> array(
							esc_html__('Default ', 'homesweet') => 'default', 
						),
						'std' => ''
		            ),
		            array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'homesweet'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'homesweet')
					)
	            )
	        ));
	        // Gallery Images
			vc_map( array(
	            "name" => esc_html__("Apus Video",'homesweet'),
	            "base" => "apus_video",
	            'description'=> esc_html__('Display Video In FrontEnd', 'homesweet'),
	            "class" => "",
	            "category" => esc_html__('Apus Elements', 'homesweet'),
	            "params" => array(
	              	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'homesweet'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => '',
					),
					array(
						"type" => "textarea_html",
						'heading' => esc_html__( 'Description', 'homesweet' ),
						"param_name" => "content",
						"value" => '',
						'description' => esc_html__( 'Enter description for title.', 'homesweet' )
				    ),
	              	array(
						"type" => "attach_image",
						"heading" => esc_html__("Icon Play Image", 'homesweet'),
						"param_name" => "image"
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__("Background Image", 'homesweet'),
						"param_name" => "image_bg"
					),
					array(
		                "type" => "textfield",
		                "heading" => esc_html__('Youtube Video Link','homesweet'),
		                "param_name" => 'video_link'
		            ),
		            array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'homesweet'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'homesweet')
					)
	            )
	        ));
	        // Features Box
			vc_map( array(
	            "name" => esc_html__("Apus Features Box",'homesweet'),
	            "base" => "apus_features_box",
	            'description'=> esc_html__('Display Features In FrontEnd', 'homesweet'),
	            "class" => "",
	            "category" => esc_html__('Apus Elements', 'homesweet'),
	            "params" => array(
	            	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'homesweet'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => '',
					),
					array(
						'type' => 'param_group',
						'heading' => esc_html__('Members Settings', 'homesweet' ),
						'param_name' => 'items',
						'description' => '',
						'value' => '',
						'params' => array(
							array(
								"type" => "attach_image",
								"description" => esc_html__("Image for box.", 'homesweet'),
								"param_name" => "image",
								"value" => '',
								'heading'	=> esc_html__('Image', 'homesweet' )
							),
							array(
								"type" => "attach_image",
								"description" => esc_html__("Image Hover for Style Box hover.", 'homesweet'),
								"param_name" => "image_hover",
								"value" => '',
								'heading'	=> esc_html__('Image Hover', 'homesweet' )
							),
							array(
				                "type" => "textfield",
				                "class" => "",
				                "heading" => esc_html__('Title','homesweet'),
				                "param_name" => "title",
				            ),
				            array(
				                "type" => "textarea",
				                "class" => "",
				                "heading" => esc_html__('Description','homesweet'),
				                "param_name" => "description",
				            ),
							array(
								"type" => "textfield",
								"heading" => esc_html__("Material Design Icon and Awesome Icon", 'homesweet'),
								"param_name" => "icon",
								"value" => '',
								'description' => esc_html__( 'This support display icon from Material Design and Awesome Icon, Please click', 'homesweet' )
												. '<a href="' . ( is_ssl()  ? 'https' : 'http') . '://zavoloklom.github.io/material-design-iconic-font/icons.html" target="_blank">'
												. esc_html__( 'here to see the list', 'homesweet' ) . '</a>'
							),
						),
					),
	             	array(
		              	"type" => "textfield",
		              	"heading" => esc_html__("Number Columns", 'homesweet'),
		              	"param_name" => "number",
		              	'value' => '1',
		            ),
		           	array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Style','homesweet'),
		                "param_name" => 'style',
		                'value' 	=> array(
							esc_html__('Default Box', 'homesweet') => 'default', 
						),
						'std' => ''
		            ),
		            array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'homesweet'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'homesweet')
					)
	            )
	        ));

			// information
			vc_map( array(
	            "name" => esc_html__("Apus Information Contact",'homesweet'),
	            "base" => "apus_information_box",
	            'description'=> esc_html__('Display Features In FrontEnd', 'homesweet'),
	            "class" => "",
	            "category" => esc_html__('Apus Elements', 'homesweet'),
	            "params" => array(
					array(
		                "type" => "textfield",
		                "class" => "",
		                "heading" => esc_html__('Title','homesweet'),
		                "param_name" => "title",
		            ),
		            array(
		                "type" => "textarea_html",
		                "class" => "",
		                "heading" => esc_html__('Description','homesweet'),
		                "param_name" => "content",
		            ),
		            array(
						"type" => "textfield",
						"heading" => esc_html__("Facebook Page URL", 'homesweet'),
						"param_name" => "facebook_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Twitter Page URL", 'homesweet'),
						"param_name" => "twitter_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Youtube Page URL", 'homesweet'),
						"param_name" => "youtube_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Pinterest Page URL", 'homesweet'),
						"param_name" => "pinterest_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Google Plus Page URL", 'homesweet'),
						"param_name" => "google-plus_url",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Instagram Page URL", 'homesweet'),
						"param_name" => "instagram_url",
						"value" => '',
						"admin_label"	=> true
					),
		            array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'homesweet'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'homesweet')
					)
	            )
	        ));
			// service
			vc_map( array(
	            "name" => esc_html__("Apus Box Service",'homesweet'),
	            "base" => "apus_service",
	            'description'=> esc_html__('Display Features In FrontEnd', 'homesweet'),
	            "class" => "",
	            "category" => esc_html__('Apus Elements', 'homesweet'),
	            "params" => array(
					array(
		                "type" => "textfield",
		                "class" => "",
		                "heading" => esc_html__('Title','homesweet'),
		                "param_name" => "title",
		            ),
		            array(
		                "type" => "textarea_html",
		                "class" => "",
		                "heading" => esc_html__('Description','homesweet'),
		                "param_name" => "content",
		            ),
		            array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Feature','homesweet'),
		                "param_name" => 'style',
		                'value' 	=> array(
							esc_html__('No', 'homesweet') => '', 
							esc_html__('Yes', 'homesweet') => 'feature', 
						),
						'std' => ''
		            ),
		            array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'homesweet'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'homesweet')
					)
	            )
	        ));


			$custom_menus = array();
			if ( is_admin() ) {
				$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
				if ( is_array( $menus ) && ! empty( $menus ) ) {
					foreach ( $menus as $single_menu ) {
						if ( is_object( $single_menu ) && isset( $single_menu->name, $single_menu->slug ) ) {
							$custom_menus[ $single_menu->name ] = $single_menu->slug;
						}
					}
				}
			}
			// Menu
			vc_map( array(
			    "name" => esc_html__("Apus Custom Menu",'homesweet'),
			    "base" => "apus_custom_menu",
			    "class" => "",
			    "description"=> esc_html__('Show Custom Menu', 'homesweet'),
			    "category" => esc_html__('Apus Elements', 'homesweet'),
			    "params" => array(
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'homesweet'),
						"param_name" => "title",
						"value" => '',
						"admin_label"	=> true
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Menu', 'homesweet' ),
						'param_name' => 'nav_menu',
						'value' => $custom_menus,
						'description' => empty( $custom_menus ) ? esc_html__( 'Custom menus not found. Please visit Appearance > Menus page to create new menu.', 'homesweet' ) : esc_html__( 'Select menu to display.', 'homesweet' ),
						'admin_label' => true,
						'save_always' => true,
					),
					array(
		                "type" => "dropdown",
		                "heading" => esc_html__('Style','homesweet'),
		                "param_name" => 'style',
		                'value' 	=> array(
							esc_html__('List', 'homesweet') => '', 
							esc_html__('Inline', 'homesweet') => 'inline', 
						),
						'std' => ''
		            ),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'homesweet'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'homesweet')
					)
			   	)
			));

		}
	}
	add_action( 'vc_after_set_mode', 'homesweet_load_load_theme_element', 99 );

	class WPBakeryShortCode_apus_title_heading extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_call_action extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_brands extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_socials_link extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_newsletter extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_googlemap extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_testimonials extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_banner_countdown extends WPBakeryShortCode {}

	class WPBakeryShortCode_apus_counter extends WPBakeryShortCode {
		public function __construct( $settings ) {
			parent::__construct( $settings );
			$this->load_scripts();
		}

		public function load_scripts() {
			wp_register_script('homesweet-counterup-js', get_template_directory_uri().'/js/jquery.counterup.min.js', array('jquery'), false, true);
		}
	}
	class WPBakeryShortCode_apus_ourteam extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_gallery extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_video extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_features_box extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_information_box extends WPBakeryShortCode {}
	//class WPBakeryShortCode_apus_service extends WPBakeryShortCode {}
	class WPBakeryShortCode_apus_custom_menu extends WPBakeryShortCode {}
}