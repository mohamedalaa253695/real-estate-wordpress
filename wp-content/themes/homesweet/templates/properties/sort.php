<div class="properties-sort">
	<?php
		$current_link = homesweet_get_current_url();
		$sortbys = array(
			'price' => esc_html__( 'Price', 'homesweet' ),
			'title' => esc_html__( 'Title', 'homesweet' ),
			'published' => esc_html__( 'Published', 'homesweet' ),
		);
		$orderways = array(
			'asc' => esc_html__( 'ASC', 'homesweet' ),
			'desc' => esc_html__( 'DESC', 'homesweet' ),
		);
		$current_sort_by =  !empty($_GET['filter-sort-by']) ? $_GET['filter-sort-by']  : (isset($_COOKIE['filter-sort-by']) ? $_COOKIE['filter-sort-by'] : '');
		$current_sort_order = !empty($_GET['filter-sort-order']) ? $_GET['filter-sort-order'] : (isset($_COOKIE['filter-sort-order']) ? $_COOKIE['filter-sort-order'] : '');
		
		$current_sort_title = $sort_by_html = $current_order_title = $sort_order_html = '';
		foreach ($sortbys as $key => $title) {
			$link = add_query_arg( 'filter-sort-by', $key, $current_link );
			if ( $current_sort_by == $key ) {
				$current_sort_title = $title;
			}
			$sort_by_html .= '<li><a href="'.esc_url($link).'" data-key="filter-sort-by" data-value="'.esc_attr($key).'">'.esc_attr($title).'</a></li>';
		}
		foreach ($orderways as $key => $title) {
			$link = add_query_arg( 'filter-sort-order', $key, $current_link );
			if ( $current_sort_order == $key ) {
				$current_order_title = $title;
			}
			$sort_order_html .= '<li><a href="'.esc_url($link).'" data-key="filter-sort-order" data-value="'.esc_attr($key).'">'.esc_attr($title).'</a></li>';
		}
	?>
	<div class="properties-sort-wrapper-inner">
	 	<div class="dropdown">
		  	<a href="#filter-sort-by" class="dropdown-toggle" data-toggle="dropdown">
		  		<?php esc_html_e('Sort By:', 'homesweet'); ?> <span><?php echo trim($current_sort_title); ?></span>
		  		<i class="fa fa-angle-down"></i>
	  		</a>
		  	<ul class="dropdown-menu properties-filter-sort-by">
				<?php echo trim($sort_by_html); ?>
			</ul>
		</div>
		
		<div class="dropdown">
		  	<a href="#filter-sort-order" class="dropdown-toggle" data-toggle="dropdown">
		  		<?php esc_html_e('Sort Order:', 'homesweet'); ?> <span><?php echo trim($current_order_title); ?></span>
		  		<i class="fa fa-angle-down"></i>
	  		</a>
		  	<ul class="dropdown-menu properties-filter-sort-order">
				<?php echo trim($sort_order_html); ?>
			</ul>
		</div>
	</div>
	
</div>
