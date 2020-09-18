<?php 

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

?>
<div class="widget widget-properties-compare <?php echo esc_attr($el_class); ?>">
	<?php
	if (isset($_COOKIE['homesweet_compare'])) {
		$compare_ids = explode(',', $_COOKIE['homesweet_compare']);
		$args = array(
			'number' => -1,
			'ids' => $compare_ids,
		);
		$loop = homesweet_get_properties( $args );
		if ( $loop->have_posts() ) {
		?>
			<table class="compare-tables">
				<thead>
					<tr>
						<th></th>
						<?php while ( $loop->have_posts() ) : $property = $loop->the_post(); ?>
							<th>
								<div class="thumb">
									<?php if ( has_post_thumbnail( $property ) ) : ?>
										<?php echo get_the_post_thumbnail( $property, 'property-thumbnail' ); ?>
						            <?php endif; ?>
						            <a href="favorite-property-<?php echo esc_attr( get_the_ID() ); ?>" class="apus-remove-compare" data-id="<?php echo esc_attr( get_the_ID() ); ?>">
										<i class=" icon-ap_close" aria-hidden="true"></i>
									</a>
								</div>
								<h3 class="entry-title"><a href="<?php the_permalink( $property ); ?>"><?php echo get_the_title( $property ) ?></a></h3>
								<?php $price = Realia_Price::get_property_price( $property->ID ); ?>
								<?php if ( ! empty( $price ) ) : ?>
						            <div class="property-box-price text-theme">
						                <?php echo wp_kses( $price, wp_kses_allowed_html( 'post' ) ); ?>
						            </div><!-- /.property-box-price -->
						        <?php endif; ?>
							</th>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</tr>
				</thead>
				<tbody>
					<?php
						$fields = homesweet_get_config( 'property_compare_sort_field', array() );

						if ( isset( $fields['enabled'] ) ) {
							$fields = $fields['enabled'];
							if ( isset($fields['placebo']) ) {
								unset($fields['placebo']);
							}
							$count = 0;
							foreach ($fields as $key => $title) {
								?>
								<tr class="<?php echo esc_attr($count%2 == 0 ? 'tr-0' : 'tr-1'); ?>">
									<td><?php echo trim($title); ?></td>
									<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
										<td>
											<?php
											if ( class_exists('Homesweet_Realia_Compare') ) {
									            echo trim(Homesweet_Realia_Compare::get_data($key));
									        }
											?>
										</td>
									<?php endwhile; ?>
									<?php wp_reset_postdata(); ?>
								</tr>
								<?php
								$count++;
							}
						}
					?>
				</tbody>
			</table>
			
		<?php }
	?>
	<?php } else { ?>
		<div><?php esc_html_e('Please choose property to compare.', 'homesweet'); ?></div>
	<?php } ?>	
</div>