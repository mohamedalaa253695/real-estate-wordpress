<div class="form-group no-border col-md-6 no-padding space-15">
	<div class="checkbox no-margin">
		<input type="checkbox" name="filter-sold" <?php echo ! empty( $_GET['filter-sold'] ) ? 'checked' : ''; ?> id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_sold">

		<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_sold">
			<?php echo esc_html__( 'Sold', 'homesweet' ); ?>
		</label>
	</div><!-- /.checkbox -->
</div><!-- /.form-group -->

