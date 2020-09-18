<?php $address = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'address', true ); ?>

<div id="property-section-address" class="property-section property-address">
    <h3>
        <?php echo esc_html__('Address', 'homesweet'); ?>
        <?php if ( ! empty( $address ) ) : ?>
            <a class="map-direction" href="//maps.google.com/maps?q=<?php echo urlencode( strip_tags( $address ) ); ?>&zoom=14&size=512x512&maptype=roadmap&sensor=false" target="_blank">
                <i class="icon-ap_pin" aria-hidden="true"></i><?php esc_html_e('Open On Google Map', 'homesweet'); ?>
            </a>
        <?php endif; ?>
    </h3>
    <ul class="columns-gap columns-gap2">
        
        <?php if ( ! empty( $address ) ) : ?>
            <li><span><?php echo esc_html__( 'Address:', 'homesweet' ); ?></span> <?php echo wp_kses( $address, wp_kses_allowed_html( 'post' ) ); ?></li>
        <?php endif; ?>

        <?php $location = Realia_Query::get_property_location_name( null, ',' ); ?>
        <?php if ( ! empty( $location ) ) : ?>
            <li><span><?php echo esc_html__( 'Location:', 'homesweet' ); ?></span> <?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?></li>
        <?php endif; ?>

        <?php $zip = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'zip', true ); ?>
        <?php if ( ! empty( $zip ) ) : ?>
            <li><span><?php echo esc_html__( 'Zip/Postal Code:', 'homesweet' ); ?></span> <?php echo trim( $zip ); ?></li>
        <?php endif; ?>
    </ul>
</div>