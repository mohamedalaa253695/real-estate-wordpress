<div class="form-group no-border col-md-6 no-padding space-15">
	<div class="checkbox no-margin">
		<input type="checkbox" name="filter-sticky" <?php echo ! empty( $_GET['filter-sticky'] ) ? 'checked' : ''; ?> id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_sticky">

		<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_sticky">
			<?php echo esc_html__( 'TOP', 'homesweet' ); ?>
		</label>
	</div><!-- /.checkbox -->
</div><!-- /.form-group -->