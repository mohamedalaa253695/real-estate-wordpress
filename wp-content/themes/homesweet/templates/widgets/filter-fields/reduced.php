<div class="form-group no-border col-md-6 no-padding space-15">
	<div class="checkbox no-margin">
		<input type="checkbox" name="filter-reduced" <?php echo ! empty( $_GET['filter-reduced'] ) ? 'checked' : ''; ?> id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_reduced">

		<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_reduced">
			<?php echo esc_html__( 'Reduced', 'homesweet' ); ?>
		</label>
	</div>
</div><!-- /.form-group -->