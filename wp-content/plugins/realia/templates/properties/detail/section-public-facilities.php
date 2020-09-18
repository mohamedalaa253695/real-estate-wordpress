<div class="property-content">
    <!-- PUBLIC FACILITIES -->
    <?php $facilities = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'public_facilities_group', true ); ?>

    <?php if ( ! empty( $facilities ) && is_array( $facilities ) && count( $facilities[0] ) > 0 ) : ?>
        <div class="property-public-facilities">
            <?php if ( ! empty( $section_title ) ): ?><h2><?php echo esc_attr( $section_title ); ?></h2><?php endif; ?>

            <?php foreach ( $facilities as $facility ) : ?>
                <div class="property-public-facility-wrapper">
                    <div class="property-public-facility">
                        <div class="property-public-facility-title">
                            <span><?php echo empty( $facility[REALIA_PROPERTY_PREFIX . 'public_facilities_key'] ) ? '' : esc_attr( $facility[REALIA_PROPERTY_PREFIX . 'public_facilities_key'] ); ?></span>
                        </div><!-- /.property-public-facility-title -->

                        <div class="property-public-facility-info">
                            <?php echo empty( $facility[REALIA_PROPERTY_PREFIX . 'public_facilities_value'] ) ? '' : esc_attr( $facility[REALIA_PROPERTY_PREFIX . 'public_facilities_value'] ); ?>
                        </div><!-- /.property-public-facility-info -->
                    </div><!-- /.property-public-facility -->
                </div><!-- /.property-public-facility-wrapper -->
            <?php endforeach; ?>
        </div><!-- /.property-public-facilities -->
    <?php endif; ?>
</div><!-- /.property-content -->
