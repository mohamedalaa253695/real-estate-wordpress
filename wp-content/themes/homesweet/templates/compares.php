<?php
if ( !empty($compare_ids) ) {
	$args = array(
		'number' => -1,
		'ids' => $compare_ids,
	);
	$loop = homesweet_get_properties( $args );
	if ( $loop->have_posts() ) {

		while ( $loop->have_posts() ) : $loop->the_post();
			echo Realia_Template_Loader::load( 'properties/small', array('compare' => true));
		endwhile;
		wp_reset_postdata();

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
		<div class="compare-actions">
			<a href="<?php echo esc_url($link); ?>" class="btn btn-theme-second btn-font-normal"><?php echo esc_html__('Compare', 'homesweet'); ?></a>
			<a href="#clear" class="apus-remove-compare-all btn btn-theme btn-font-normal"><?php echo esc_html__('Clear', 'homesweet'); ?></a>
		</div>
		<?php
	}
}
?>