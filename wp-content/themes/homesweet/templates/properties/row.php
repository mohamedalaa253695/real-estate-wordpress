<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php $property = isset( $property ) ? $property : get_post(); ?>

<?php $is_sticky = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'sticky', true ); ?>
<?php $status = Realia_Query::get_property_status_name(); ?>
<div class="property-box property-box-wrapper property-box-list-row clearfix" data-markerid="marker-<?php echo esc_attr($property->ID); ?>">
    <div class="clearfix">
        <div class="property-box-left">
            <div class="property-box-image <?php if ( ! has_post_thumbnail( $property ) ) { echo 'without-image'; } ?>">
                <a href="<?php the_permalink($property); ?>" class="property-box-image-inner <?php if ( ! empty( $agent ) ) : ?>has-agent<?php endif; ?>">
                    <?php
                    /**
                     * realia_before_property_box_image
                     */
                    do_action( 'realia_before_property_box_image', $property->ID );
                    ?>

                    <?php if ( has_post_thumbnail( $property ) ) : ?>
                        <?php echo get_the_post_thumbnail( $property, 'property-thumbnail' ); ?>
                    <?php endif; ?>
                </a>
                <div class="property-box-top clearfix">
                    <?php
                    if ( class_exists('Homesweet_Realia_Compare') ) {
                        Homesweet_Realia_Compare::display_compare_btn( $property->ID );
                    }
                    ?>
                    <!-- share -->
                    <?php homesweet_realia_display_sharebox($property); ?>
                    <!-- favorite -->
                </div>
                <?php if ( class_exists('Homesweet_Realia_Favorite') ) { ?>
                    <?php Homesweet_Realia_Favorite::btn_display( $property->ID ); ?>
                <?php } ?>
            </div>
        </div>
        <div class="property-box-content">
            <div class="property-box-title-wrap">
                <div class="property-box-title">
                    <h3 class="entry-title"><a href="<?php the_permalink( $property ); ?>"><?php echo get_the_title( $property ) ?></a></h3>
                    <?php homesweet_realia_display_address($property); ?>
                </div>
            </div><!-- /.property-box-title -->
            <div class="property-box-label-time clearfix">
                <div class="pull-left">
                    <?php homesweet_realia_display_labels($property); ?>
                </div>
                <div class="pull-left time">
                    <?php printf(__( '%s ago', 'homesweet' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
                </div>
            </div>
            <div class="property-price-author clearfix">
                <div class="pull-left">
                    <?php homesweet_realia_display_price($property); ?>
                </div>
                <div class="property-author pull-right">
                    <?php homesweet_realia_display_property_agent( $property->ID ); ?>
                </div>
            </div>

            <?php homesweet_realia_display_metas($property); ?>
        </div>
    </div>
</div>