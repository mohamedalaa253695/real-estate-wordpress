<?php if ( empty( $instance['hide_price'] ) ) : ?>
	<div class="form-group">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_price_from"><?php echo __( 'Price from', 'realia' ); ?></label>
		<?php endif; ?>

		<input type="number" min="0" pattern="\d*" name="filter-price-from"
				<?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo __( 'Price from', 'realia' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-price-from'] ) ? esc_attr( $_GET['filter-price-from'] ) : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_price_from">
	</div><!-- /.form-group -->

	<div class="form-group">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_price_to"><?php echo __( 'Price to', 'realia' ); ?></label>
		<?php endif; ?>

		<input type="number" min="0" pattern="\d*" name="filter-price-to"
				<?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo __( 'Price to', 'realia' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-price-to'] ) ? esc_attr( $_GET['filter-price-to'] ) : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_price_to">
	</div><!-- /.form-group -->
<?php endif; ?>
