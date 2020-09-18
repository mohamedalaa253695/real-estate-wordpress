<div class="property-content">
    <!-- MAP LOCATION -->
    <?php $map_location = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'map_location', true ); ?>

    <?php if ( ! empty( $map_location ) && 2 == count( $map_location ) ) : ?>
        <!-- MAP -->
        <div class="property-map-position">
            <?php if ( ! empty( $section_title ) ): ?><h2><?php echo esc_attr( $section_title ); ?></h2><?php endif; ?>

            <div class="map" id="simple-map" style="height: 300px"
                 data-latitude="<?php echo esc_attr( $map_location['latitude'] ); ?>"
                 data-longitude="<?php echo esc_attr( $map_location['longitude'] ); ?>"
                 data-transparent-marker-image="<?php echo plugins_url( 'realia' ); ?>/assets/img/transparent-marker-image.png"
                 data-zoom="15"
                >
            </div><!-- /.map -->
        </div><!-- /.map-position -->
    <?php endif; ?>
</div><!-- /.property-content -->