<?php 

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
?>
<div class="widget widget-property-favorite <?php echo esc_attr($el_class); ?>">
	<?php
	if ( is_user_logged_in() ) {
		if ( class_exists('Homesweet_Realia_Favorite') ) {
			$ids = Homesweet_Realia_Favorite::get_favorite();

			if ( !empty($ids) ) {
				$args = array(
					'number' => -1,
					'ids' => $ids,
				);
				$loop = homesweet_get_properties( $args );
				if ( $loop->have_posts() ) {
				?>	
					<div class="row">
						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
							<div class="favorite-item col-xs-12">
								<?php echo Realia_Template_Loader::load( 'properties/small', array('favorite' => true) ); ?>
							</div>
						<?php endwhile; ?>
					</div>
					<?php wp_reset_postdata(); ?>
				<?php }
			} else {
				?>
				<div><?php esc_html_e('Do not have any item in your favorite.', 'homesweet'); ?></div>
				<?php
			}
		}
	} else {
		?>
		<a href="<?php echo esc_url( get_permalink( get_theme_mod('realia_general_login_required_page', null) ) ); ?>">
	        <?php esc_html_e( 'Please login to view this page', 'homesweet' ); ?>
	    </a>
		<?php
	}
	?>
</div>