<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<?php $property = isset( $property ) ? $property : get_post(); ?>
<?php $is_sticky = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'sticky', true ); ?>
<?php $status = Realia_Query::get_property_status_name(); ?>
<?php if ( (isset($compare) && $compare) || (isset($favorite) && $favorite) ) { ?>
    <div class="table-small-action">
        <div class="property-box property-box-list-small clearfix" data-markerid="marker-<?php echo esc_attr($property->ID); ?>">
            <div class="property-box-left pull-left">
                <div class="property-box-image <?php if ( has_post_thumbnail( $property ) ) { echo 'with-image'; } ?>">
                    <a href="<?php the_permalink($property); ?>" class="property-box-image-inner <?php if ( ! empty( $agent ) ) : ?>has-agent<?php endif; ?>">
                        <?php
                        /**
                         * realia_before_property_box_image
                         */
                        do_action( 'realia_before_property_box_image', $property->ID );
                        ?>

                        <?php if ( has_post_thumbnail( $property ) ) : ?>
                            <?php homesweet_realia_post_thumbnail($property, 'thumbnail'); ?>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
            <div class="property-box-content-right">
                <h3 class="entry-title"><a href="<?php the_permalink( $property ); ?>"><?php echo get_the_title( $property ) ?></a></h3>
                <?php homesweet_realia_display_price($property); ?>
                <?php homesweet_realia_display_address($property); ?>
            </div>
        </div>
        <div class="action">
            <?php if ( isset($compare) && $compare ) { ?>
                <a href="favorite-property-<?php echo esc_attr( get_the_ID() ); ?>" class="apus-remove-compare apus-deleted-item" data-id="<?php echo esc_attr( get_the_ID() ); ?>">
                    <i class=" icon-ap_close" aria-hidden="true"></i>
                </a>
            <?php } ?>
            <?php if ( isset($favorite) && $favorite ) { ?>
                <a href="#favorite-course-<?php echo esc_attr( get_the_ID() ); ?>" class="apus-favorite-remove apus-deleted-item" data-id="<?php echo esc_attr( get_the_ID() ); ?>">
                    <i class="icon-ap_close" aria-hidden="true"></i>
                </a>
            <?php } ?>
        </div>
    </div>
<?php }else{ ?>
    <div class="property-box property-box-list-small clearfix" data-markerid="marker-<?php echo esc_attr($property->ID); ?>">
        <div class="property-box-left pull-left">
            <div class="property-box-image <?php if ( has_post_thumbnail( $property ) ) { echo 'with-image'; } ?>">
                <a href="<?php the_permalink($property); ?>" class="property-box-image-inner <?php if ( ! empty( $agent ) ) : ?>has-agent<?php endif; ?>">
                    <?php
                    /**
                     * realia_before_property_box_image
                     */
                    do_action( 'realia_before_property_box_image', $property->ID );
                    ?>

                    <?php if ( has_post_thumbnail( $property ) ) : ?>
                        <?php homesweet_realia_post_thumbnail($property, 'thumbnail'); ?>
                    <?php endif; ?>
                </a>
            </div>
        </div>
        <div class="property-box-content-right">
            <h3 class="entry-title"><a href="<?php the_permalink( $property ); ?>"><?php echo get_the_title( $property ) ?></a></h3>
            <?php homesweet_realia_display_price($property); ?>
            <?php homesweet_realia_display_address($property); ?>
        </div>
    </div>
<?php } ?>