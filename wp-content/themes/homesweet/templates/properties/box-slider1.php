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
<div class="property-box-slider property-box-slider1-wrapper <?php echo (has_post_thumbnail( $property ) ) ? 'has-img' : ''; ?>">
    <?php if ( has_post_thumbnail( $property ) ) : ?>
        <a href="<?php the_permalink( $property ); ?>" class="banner-link">
            <?php homesweet_realia_post_thumbnail($property, 'homesweet-special-large'); ?>
        </a>
    <?php endif; ?>
    <div class="content">
        <div class="container">
            <div class="property-box-slider-content">
                <div class="bottom-content">
                    <div class="property-box-title-wrap">
                        <div class="property-box-title">
                            <?php homesweet_realia_display_labels($property); ?>
                            <h3 class="entry-title"><a href="<?php the_permalink( $property ); ?>"><?php echo get_the_title( $property ) ?></a></h3>
                            <div class="content-bottom clearfix">
                                <?php $location = Realia_Query::get_property_location_name( null, ',' ); ?>
                                <?php if ( ! empty( $location ) ) : ?>
                                    <div class="property-row-location pull-left">
                                        <?php homesweet_realia_display_address($property); ?>
                                    </div>
                                <?php endif; ?>
                                <?php $price = Homesweet_Realia_Price::homesweet_get_property_price( $property->ID ); ?>
                                <?php if ( ! empty( $price ) ) : ?>
                                    <div class="property-box-price pull-right">
                                        <?php echo wp_kses( $price, wp_kses_allowed_html( 'post' ) ); ?>
                                    </div><!-- /.property-box-price -->
                                <?php endif; ?>
                            </div>
                        </div>
                    </div><!-- /.property-box-title-->
                </div>
            </div><!-- /.property-box-content -->
        </div>
    </div>
</div>