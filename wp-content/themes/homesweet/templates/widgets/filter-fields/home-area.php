
<div class="home-area-wrapper">
	
	<div class="row">
		<div class="col-xs-6">
			<div class="form-group">
				<?php if ( 'labels' == $input_titles ) : ?>
					<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_home_area_from"><?php echo esc_html__( 'Home Area From (sqft)', 'homesweet' ); ?></label>
				<?php endif; ?>

				<input type="number" name="filter-home-area-from"
						<?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Home Area From (sqft)', 'homesweet' ); ?>"<?php endif; ?>
				       class="form-control" value="<?php echo ! empty( $_GET['filter-home-area-from'] ) ? esc_attr( $_GET['filter-home-area-from'] ) : ''; ?>"
				       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_home_area_from">
			</div><!-- /.form-group -->
		</div>
		<div class="col-xs-6">
			<div class="form-group">
				<?php if ( 'labels' == $input_titles ) : ?>
					<label for="<?php echo esc_attr( $args['widget_id'] ); ?>_home_area_to"><?php echo esc_html__( 'Home Area To (sqft)', 'homesweet' ); ?></label>
				<?php endif; ?>

				<input type="number" name="filter-home-area-to"
						<?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Home Area To (sqft)', 'homesweet' ); ?>"<?php endif; ?>
				       class="form-control" value="<?php echo ! empty( $_GET['filter-home-area-to'] ) ? esc_attr( $_GET['filter-home-area-to'] ) : ''; ?>"
				       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_home_area_to">
			</div><!-- /.form-group -->
		</div>
	</div>
</div>

