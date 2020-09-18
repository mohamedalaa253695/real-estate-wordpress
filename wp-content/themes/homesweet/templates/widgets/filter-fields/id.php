
	<div class="form-group">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo esc_attr( $args['widget_id'] ); ?>_property_id"><?php echo esc_html__( 'Property ID', 'homesweet' ); ?></label>
		<?php endif; ?>

		<input type="text" name="filter-id" class="form-control"
				<?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Property ID', 'homesweet' ); ?>"<?php endif; ?>
		       value="<?php echo ! empty( $_GET['filter-id'] ) ? esc_attr( $_GET['filter-id'] ) : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_property_id">
	</div><!-- /.form-group -->
