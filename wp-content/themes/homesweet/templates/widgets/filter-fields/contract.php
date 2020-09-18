
<div class="form-group group-select">
	<?php if ( 'labels' == $input_titles ) : ?>
		<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_status"><?php echo esc_html__( 'Contract', 'homesweet' ); ?></label>
	<?php endif; ?>

	<select class="form-control" name="filter-contract" id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_status">
		<option value=""><?php echo esc_html__( 'All contracts', 'homesweet' ); ?></option>
		<option value="<?php echo REALIA_CONTRACT_SALE; ?>" <?php if ( ! empty( $_GET['filter-contract'] ) && REALIA_CONTRACT_SALE == $_GET['filter-contract'] ) : ?>selected="selected"<?php endif; ?>><?php echo esc_html__( 'Sale', 'homesweet' ); ?></option>
		<option value="<?php echo REALIA_CONTRACT_RENT; ?>" <?php if ( ! empty( $_GET['filter-contract'] ) && REALIA_CONTRACT_RENT == $_GET['filter-contract'] ) : ?>selected="selected"<?php endif; ?>><?php echo esc_html__( 'Rent', 'homesweet' ); ?></option>
	</select>
</div><!-- /.form-group -->
