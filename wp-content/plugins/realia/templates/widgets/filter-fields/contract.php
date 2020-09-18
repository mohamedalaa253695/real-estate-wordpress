<?php if ( empty( $instance['hide_contract'] ) ) : ?>
	<div class="form-group">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_status"><?php echo __( 'Contract', 'realia' ); ?></label>
		<?php endif; ?>

		<select class="form-control" name="filter-contract" id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_status">
			<option value=""><?php echo __( 'All contracts', 'realia' ); ?></option>
			<?php foreach( Realia_Post_Type_Property::contract_options() as $key => $value ): ?>
				<option value="<?php echo $key; ?>" <?php if ( ! empty( $_GET['filter-contract'] ) && $key == $_GET['filter-contract'] ) : ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
			<?php endforeach; ?>
		</select>
	</div><!-- /.form-group -->
<?php endif; ?>
