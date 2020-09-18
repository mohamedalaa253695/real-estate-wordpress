<?php $facilities = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'public_facilities_group', true ); ?>

<?php if ( ! empty( $facilities ) && is_array( $facilities ) && count( $facilities[0] ) > 0 ) : ?>
    <div id="property-section-facilities" class="property-section property-public-facilities">
        <h3><?php echo esc_html__('Facilities', 'homesweet'); ?></h3>
        <div class="clearfix row">
        <?php foreach ( $facilities as $facility ) : ?>
            <div class="property-public-facility-wrapper col-sm-6 col-xs-12">
                <div class="property-public-facility">
                    <div class="row">
                        <div class="property-public-facility-title col-sm-8 col-xs-12">
                            <span><?php echo empty( $facility[REALIA_PROPERTY_PREFIX . 'public_facilities_key'] ) ? '' : esc_attr( $facility[REALIA_PROPERTY_PREFIX . 'public_facilities_key'] ); ?></span>
                        </div><!-- /.property-public-facility-title -->

                        <div class="property-public-facility-info col-sm-4 col-xs-12">
    						<?php echo empty( $facility[REALIA_PROPERTY_PREFIX . 'public_facilities_value'] ) ? '' : esc_attr( $facility[REALIA_PROPERTY_PREFIX . 'public_facilities_value'] ); ?>
                        </div><!-- /.property-public-facility-info -->
                    </div>
                </div><!-- /.property-public-facility -->
            </div><!-- /.property-public-facility-wrapper -->
        <?php endforeach; ?>
        </div>
    </div><!-- /.property-public-facilities -->
<?php endif; ?>