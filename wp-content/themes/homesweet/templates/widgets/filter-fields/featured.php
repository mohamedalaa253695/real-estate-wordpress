<div class="form-group no-border col-md-6 no-padding space-15">
	<div class="checkbox no-margin">
		<input type="checkbox" name="filter-featured" <?php echo ! empty( $_GET['filter-featured'] ) ? 'checked' : ''; ?> id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_featured">

		<label for="<?php echo esc_attr( $args['widget_id'] ); ?>_featured">
			<?php echo esc_html__( 'Featured', 'homesweet' ); ?>
		</label>
	</div><!-- /.checkbox -->
</div><!-- /.form-group -->
