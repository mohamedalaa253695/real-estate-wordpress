<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function homesweet_realia_display_contract($property) {
    $args = Realia_Post_Type_Property::contract_options();
    $contract = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'contract', true );
    if ( !empty($contract) ) {
        if ( isset($args[$contract]) ) {
            ?>
            <span class="property-badge-contract"><?php echo esc_html($args[$contract]); ?></span>
            <?php
        } else {
            ?>
            <span class="property-badge-contract"><?php echo trim($contract); ?></span>
            <?php
        }
    }
}

function homesweet_realia_display_address($property) {
    $address = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'address', true );
    if ( $address ) { ?>
        <div class="property-row-address">
            <i class="icon-ap_pin" aria-hidden="true"></i>
            <?php echo wp_kses( $address, wp_kses_allowed_html( 'post' ) ); ?>
        </div>
    <?php }
}

function homesweet_realia_display_location($property) {
    $location = Realia_Query::get_property_location_name( null, ',' );
    if ( ! empty( $location ) ) { ?>
        <div class="property-row-location">
            <?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?>
        </div>
    <?php }
}

function homesweet_realia_display_price($property) {
    $price = Homesweet_Realia_Price::homesweet_get_property_price( $property->ID );
    if ( ! empty( $price ) ) { ?>
        <div class="property-box-price text-theme">
            <?php echo wp_kses( $price, wp_kses_allowed_html( 'post' ) ); ?>
        </div>
    <?php }
}

function homesweet_realia_display_labels($property) {
    ?>
    <div class="property-row-labels">
        <?php
        homesweet_realia_display_contract($property);
        
        $is_featured = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'featured', true );
        $is_reduced = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'reduced', true );
        $is_sticky = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'sticky', true );
        ?>

        <?php if ( $is_featured ) : ?>
            <span class="property-badge feature"><?php echo esc_html__( 'Featured', 'homesweet' ); ?></span>
        <?php endif; ?>
        <?php if ( $is_reduced ) : ?>
            <span class="property-badge"><?php echo esc_html__( 'Reduced', 'homesweet' ); ?></span>
        <?php endif; ?>
        <?php if ( $is_sticky ) : ?>
            <span class="property-badge property-badge-sticky"><?php echo esc_html__( 'TOP', 'homesweet' ); ?></span>
        <?php endif; ?>
    </div>
    <?php
}

function homesweet_realia_display_sharebox($property) {
    ?>
    <div class="property-box-share pull-left">
        <a href="#share-box">
            <i class="icon-ap_share"></i>
        </a>
        <div class="property-box-share-content">
            <?php get_template_part( 'page-templates/parts/sharebox-property' ); ?>
        </div>
    </div>
    <?php
}

function homesweet_realia_display_metas($property) {
    ?>
    <div class="property-box-field">
        <div class="property-box-meta">
            <?php $home_area = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'home_area', true ); ?>
            <?php if ( ! empty( $home_area ) ) : ?>
                <div class="field-item">
                    <?php echo sprintf(__('Area <span>%s %s</span>', 'homesweet'), $home_area, get_theme_mod( 'realia_measurement_area_unit', null )); ?>
                </div>
            <?php endif; ?>

            <?php $beds = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'beds', true ); ?>
            <?php if ( ! empty( $beds ) ) : ?>
                <div class="field-item">
                    <?php echo sprintf(__('Beds <span>%s</span>', 'homesweet'), $beds); ?>
                </div>
            <?php endif; ?>

            <?php $baths = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'baths', true ); ?>
            <?php if ( ! empty( $baths ) ) : ?>
                <div class="field-item">
                    <?php echo sprintf(__('Baths <span>%s</span>', 'homesweet'), $baths); ?>
                </div>
            <?php endif; ?>

            <?php $garages = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'garages', true ); ?>
            <?php if ( ! empty( $garages ) ) : ?>
                <div class="field-item">
                    <?php echo sprintf(__('Garages <span>%s</span>', 'homesweet'), $garages); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}