<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $property = isset( $property ) ? $property : get_post(); ?>

<?php
    $is_sticky = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'sticky', true );
    $status = Realia_Query::get_property_status_name();

    $image_url = get_the_post_thumbnail_url($property->ID);
    $style = '';
    if ( $image_url ) {
        $style = 'style="background-image:url('.esc_url($image_url).');"';
    }
?>
<div class="property-box-slider property-box-slider-wrapper <?php echo (has_post_thumbnail( $property ) ) ? 'has-img' : ''; ?>">
    <?php if ( has_post_thumbnail( $property ) ) : ?>
        <a href="<?php the_permalink( $property ); ?>" class="banner-link">
            <?php homesweet_realia_post_thumbnail($property, 'homesweet-gallery-v1'); ?>
        </a>
    <?php endif; ?>
    <div class="content">
        <div class="container">
            <div class="property-box-slider-content">
                <div class="bottom-content">
                    <div class="property-box-title-wrap">
                        <div class="property-box-title">
                            <h3 class="entry-title"><a href="<?php the_permalink( $property ); ?>"><?php echo get_the_title( $property ) ?></a></h3>
                            <div class="content-bottom">
                                <?php $location = Realia_Query::get_property_location_name( null, ',' ); ?>
                                <?php if ( ! empty( $location ) ) : ?>
                                    <div class="property-row-location">
                                        <?php homesweet_realia_display_address($property); ?>
                                    </div>
                                <?php endif; ?>
                                <?php $price = Homesweet_Realia_Price::homesweet_get_property_price( $property->ID ); ?>
                                <?php if ( ! empty( $price ) ) : ?>
                                    <div class="property-box-price">
                                        <?php echo wp_kses( $price, wp_kses_allowed_html( 'post' ) ); ?>
                                    </div><!-- /.property-box-price -->
                                <?php endif; ?>
                                <?php homesweet_realia_display_labels($property); ?>
                            </div>
                        </div>
                    </div><!-- /.property-box-title-->
                </div>
            </div><!-- /.property-box-content -->
        </div>
    </div>
</div>