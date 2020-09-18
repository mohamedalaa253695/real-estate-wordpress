<?php if ( empty( $instance['hide_property_title'] ) ) : ?>
    <div class="form-group">
        <?php if ( 'labels' == $input_titles ) : ?>
            <label for="<?php echo esc_attr( $args['widget_id'] ); ?>_property_title"><?php echo __( 'Property title', 'realia' ); ?></label>
        <?php endif; ?>

        <input type="text" name="filter-property-title" class="form-control"
               <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo __( 'Property title', 'realia' ); ?>"<?php endif; ?>
               value="<?php echo ! empty( $_GET['filter-property-title'] ) ? esc_attr( $_GET['filter-property-title'] ) : ''; ?>"
               id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_property_title">
    </div><!-- /.form-group -->
<?php endif; ?>
