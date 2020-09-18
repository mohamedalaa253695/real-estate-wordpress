<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$input_titles = 'placeholders';
$field_id_prefix = $args['widget_id'] = homesweet_random_key();

$fields = (array) vc_param_group_parse_atts( $fields );
if ( !empty($fields) ) {
	?>
	<div class="widget widget-filter-form <?php echo esc_attr($el_class); ?> <?php echo esc_attr($style); ?>">
		<form class="filter-property-form <?php echo (isset($instance['layout_type']) ? $instance['layout_type'] : ''); ?>" method="get" action="<?php echo get_post_type_archive_link( 'property' ); ?>">
			<div class="row">
				<?php
				$amenity = false;
				foreach ($fields as $field) {
					if ( !empty($field['field']) ) {
						$instance['price_min'] = !empty($field['price_min']) ? $field['price_min'] : 0;
						$instance['price_max'] = !empty($field['price_max']) ? $field['price_max'] : 1000000;
						if( in_array($field['field'], array('amenity')) ) {
							$amenity = true;
							?>
							<div class="col-sm-<?php echo esc_attr($field['bcol']); ?>">
								<h3 class="filter-amenities-title"><i class="fa fa-plus-circle"></i> <?php echo esc_html__( 'Other Features', 'homesweet' ); ?></h3>
							</div>
							
							<?php
						} else {
						?>
							<div class="col-sm-<?php echo esc_attr($field['bcol']); ?>">
								<?php $template = str_replace( '_', '-', $field['field'] ); ?>
								<?php include Realia_Template_Loader::locate( 'widgets/filter-fields/' . $template ); ?>
							</div>
						<?php
						}
					}
				}
				?>
				<?php if ( ! empty( $button_text ) ) : ?>
					<div class="col-sm-<?php echo esc_attr($button_col); ?>">
						<?php if ( ! empty( $show_advance ) ) : ?>
							<div class="pull-left">
								<a href="#toggle_adv" class="toggle-adv">
									<i class="icon-ap_settings"></i> <span><?php esc_html_e('Advance', 'homesweet'); ?></span>
								</a>
							</div>
						<?php endif; ?>
						<div class="visiable-line pull-right">
							<button class="button btn btn-purple"><?php echo esc_attr( $button_text ); ?></button>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $amenity ) { ?>
					<div class="col-sm-12">
						<?php include Realia_Template_Loader::locate( 'widgets/filter-fields/amenity' ); ?>
					</div>
				<?php } ?>
			</div>
			<div class="advance-fields clearfix">
				<div class="row">
					<?php
					$advance_fields = (array) vc_param_group_parse_atts( $advance_fields );
					if ( !empty($advance_fields) ) {
						$amenity = false;
						foreach ($advance_fields as $field) {
							if ( !empty($field['field']) ) {
								$instance['price_min'] = !empty($field['price_min']) ? $field['price_min'] : 0;
								$instance['price_max'] = !empty($field['price_max']) ? $field['price_max'] : 1000000;
								if( in_array($field['field'], array('amenity')) ) {
									$amenity = true;
									?>
									<div class="col-sm-<?php echo esc_attr($field['bcol']); ?>">
										<h3 class="filter-amenities-title"><i class="fa fa-plus-circle"></i> <?php echo esc_html__( 'Other Features', 'homesweet' ); ?></h3>
									</div>
									
									<?php
								} else {
								?>
									<div class="col-sm-<?php echo esc_attr($field['bcol']); ?>">
										<?php $template = str_replace( '_', '-', $field['field'] ); ?>
										<?php include Realia_Template_Loader::locate( 'widgets/filter-fields/' . $template ); ?>
									</div>
								<?php
								}
							}
						}
						if ( $amenity ) { ?>
							<div class="col-sm-12">
								<?php include Realia_Template_Loader::locate( 'widgets/filter-fields/amenity' ); ?>
							</div>
						<?php }
					}
					?>
				</div>
			</div>
			<?php
			$current_sort_by =  !empty($_GET['filter-sort-by']) ? $_GET['filter-sort-by']  : (isset($_COOKIE['filter-sort-by']) ? $_COOKIE['filter-sort-by'] : '');
			$current_sort_order = !empty($_GET['filter-sort-order']) ? $_GET['filter-sort-order'] : (isset($_COOKIE['filter-sort-order']) ? $_COOKIE['filter-sort-order'] : '');
			if ( $current_sort_by ) {
				?>
				<input id="filter-sort-by" type="hidden" name="filter-sort-by" value="<?php echo trim($current_sort_by); ?>">
				<?php
			}
			if ( $current_sort_order ) {
				?>
				<input id="filter-sort-order" type="hidden" name="filter-sort-order" value="<?php echo trim($current_sort_order); ?>">
				<?php
			}
			?>
		</form>
	</div>
	<?php
}