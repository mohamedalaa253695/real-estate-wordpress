
<div class="lot-area-wrapper">
	<div class="row">
		<div class="col-xs-6">
			<div class="form-group">
				<?php if ( 'labels' == $input_titles ) : ?>
					<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_lot_area_from"><?php echo esc_html__( 'Lot Area From (sqft)', 'homesweet' ); ?></label>
				<?php endif; ?>

				<input type="text" name="filter-lot-area-from"
						<?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Lot Area From (sqft) ', 'homesweet' ); ?>"<?php endif; ?>
				       class="form-control" value="<?php echo ! empty( $_GET['filter-lot-area-from'] ) ? esc_attr( $_GET['filter-lot-area-from'] ) : ''; ?>"
				       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_lot_area_from">
			</div><!-- /.form-group -->
		</div>
		<div class="col-xs-6">
			<div class="form-group">
				<?php if ( 'labels' == $input_titles ) : ?>
					<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_lot_area_to"><?php echo esc_html__( 'Lot Area To (sqft)', 'homesweet' ); ?></label>
				<?php endif; ?>

				<input type="text" name="filter-lot-area-to"
						<?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Lot Area To (sqft) ', 'homesweet' ); ?>"<?php endif; ?>
				       class="form-control" value="<?php echo ! empty( $_GET['filter-lot-area-to'] ) ? esc_attr( $_GET['filter-lot-area-to'] ) : ''; ?>"
				       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_lot_area_to">
			</div><!-- /.form-group -->
		</div>
	</div>
</div>
