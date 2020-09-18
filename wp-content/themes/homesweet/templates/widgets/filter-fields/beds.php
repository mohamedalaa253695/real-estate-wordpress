
<div class="form-group group-select">
	<?php if ( 'labels' == $input_titles ) : ?>
		<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_beds"><?php echo esc_html__( 'Beds', 'homesweet' ); ?></label>
	<?php endif; ?>

	<select name="filter-beds"
			id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_beds"
			class="form-control">
		<option value="">
			<?php if ( 'placeholders' == $input_titles ) : ?>
				<?php echo esc_html__( 'Beds: any', 'homesweet' ); ?>
			<?php else : ?>
				<?php echo esc_html__( 'Any', 'homesweet' ); ?>
			<?php endif; ?>
		</option>

		<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
			<option value="<?php echo esc_attr( $i ); ?>" <?php if ( ! empty( $_GET['filter-beds'] ) && $_GET['filter-beds'] == $i ) : ?>selected="selected"<?php endif; ?>>
				<?php echo esc_attr( $i ); ?>+
			</option>
		<?php endfor; ?>
	</select>
</div><!-- /.form-group -->