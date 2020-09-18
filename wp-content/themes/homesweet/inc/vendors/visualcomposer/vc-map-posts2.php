<?php

if ( function_exists('vc_map') && class_exists('WPBakeryShortCode') ) {

    function homesweet_get_post_categories() {
        $return = array( esc_html__(' --- Choose a Category --- ', 'homesweet') => '' );

        $args = array(
            'type' => 'post',
            'child_of' => 0,
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => false,
            'hierarchical' => 1,
            'taxonomy' => 'category'
        );

        $categories = get_categories( $args );
        homesweet_get_post_category_childs( $categories, 0, 0, $return );

        return $return;
    }

    function homesweet_get_post_category_childs( $categories, $id_parent, $level, &$dropdown ) {
        foreach ( $categories as $key => $category ) {
            if ( $category->category_parent == $id_parent ) {
                $dropdown = array_merge( $dropdown, array( str_repeat( "- ", $level ) . $category->name => $category->slug ) );
                unset($categories[$key]);
                homesweet_get_post_category_childs( $categories, $category->term_id, $level + 1, $dropdown );
            }
        }
	}

	function homesweet_load_post2_element() {
		$layouts = array(
			esc_html__('Grid', 'homesweet') => 'grid',
			esc_html__('Grid 2', 'homesweet') => 'grid-v2',
			esc_html__('List', 'homesweet') => 'list',
			esc_html__('Carousel', 'homesweet') => 'carousel',
		);
		$columns = array(1,2,3,4,6);
		$categories = array();
		if ( is_admin() ) {
			$categories = homesweet_get_post_categories();
		}
		vc_map( array(
			'name' => esc_html__( 'Apus Grid Posts', 'homesweet' ),
			'base' => 'apus_gridposts',
			'icon' => 'icon-wpb-news-12',
			"category" => esc_html__('Apus Post', 'homesweet'),
			'description' => esc_html__( 'Create Post having blog styles', 'homesweet' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'homesweet' ),
					'param_name' => 'title',
					'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'homesweet' ),
					"admin_label" => true
				),
				array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Category','homesweet'),
	                "param_name" => 'category',
	                "value" => $categories
	            ),
	            array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Order By','homesweet'),
	                "param_name" => 'orderby',
	                "value" => array(
	                	esc_html__('Date', 'homesweet') => 'date',
	                	esc_html__('ID', 'homesweet') => 'ID',
	                	esc_html__('Author', 'homesweet') => 'author',
	                	esc_html__('Title', 'homesweet') => 'title',
	                	esc_html__('Modified', 'homesweet') => 'modified',
	                	esc_html__('Parent', 'homesweet') => 'parent',
	                	esc_html__('Comment count', 'homesweet') => 'comment_count',
	                	esc_html__('Menu order', 'homesweet') => 'menu_order',
	                	esc_html__('Random', 'homesweet') => 'rand',
	                )
	            ),
	            array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Sort order','homesweet'),
	                "param_name" => 'order',
	                "value" => array(
	                	esc_html__('Descending', 'homesweet') => 'DESC',
	                	esc_html__('Ascending', 'homesweet') => 'ASC',
	                )
	            ),
	            array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Limit', 'homesweet' ),
					'param_name' => 'posts_per_page',
					'description' => esc_html__( 'Enter limit posts.', 'homesweet' ),
					'std' => 4,
					"admin_label" => true
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show Pagination?', 'homesweet' ),
					'param_name' => 'show_pagination',
					'description' => esc_html__( 'Enables to show paginations to next new page.', 'homesweet' ),
					'value' => array( esc_html__( 'Yes, to show pagination', 'homesweet' ) => 'yes' )
				),
				array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Grid Columns','homesweet'),
	                "param_name" => 'grid_columns',
	                "value" => $columns
	            ),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Layout Type", 'homesweet'),
					"param_name" => "layout_type",
					"value" => $layouts
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Thumbnail size', 'homesweet' ),
					'param_name' => 'thumbsize',
					'description' => esc_html__( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'homesweet' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'homesweet' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homesweet' )
				)
			)
		) );
	}

	add_action( 'vc_after_set_mode', 'homesweet_load_post2_element', 99 );

	class WPBakeryShortCode_apus_gridposts extends WPBakeryShortCode {}
}