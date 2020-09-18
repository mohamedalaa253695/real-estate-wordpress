
	<div class="form-group">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_year_built"><?php echo esc_html__( 'Year Built', 'homesweet' ); ?></label>
		<?php endif; ?>

		<input type="number" name="filter-year-built"
				<?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Year built', 'homesweet' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-year-built'] ) ? esc_attr( $_GET['filter-year-built'] ) : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_year_built">
	</div><!-- /.form-group -->

