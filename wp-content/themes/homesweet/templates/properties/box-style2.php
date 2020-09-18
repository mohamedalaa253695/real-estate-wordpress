<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php $property = isset( $property ) ? $property : get_post(); ?>

<?php
    $latitude = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'map_location_latitude', true );
    $longitude = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'map_location_longitude', true );

    $content = str_replace( array( "\r\n", "\n", "\t" ), '', Realia_Template_Loader::load( 'misc/google-map-infowindow' ) );
    $marker_content = str_replace( array( "\r\n", "\n", "\t" ), '', Realia_Template_Loader::load( 'misc/google-map-marker' ) );
    $image_size = isset($image_size) ? $image_size: 'homesweet-standard-size';
?>
<div class="property-box property-box-wrapper property-box-grid-style2" data-latitude="<?php echo esc_attr($latitude); ?>" data-longitude="<?php echo esc_attr($longitude); ?>" data-markerid="marker-<?php echo esc_attr($property->ID); ?>">
    <div class="property-map-content-wrapper hidden">
        <div class="property-map-content">
            <?php echo trim($content); ?>
        </div>
        <div class="property-map-marker">
            <?php echo trim($marker_content); ?>
        </div>
    </div>
    
    <div class="property-box-image <?php if ( ! has_post_thumbnail( $property ) ) { echo 'without-image'; } ?>">
        <a href="<?php the_permalink(); ?>" class="property-box-image-inner">
            <?php
            /**
             * realia_before_property_box_image
             */
            do_action( 'realia_before_property_box_image', $property->ID );
            ?>

            <?php homesweet_realia_post_thumbnail($property, $image_size); ?>

            <?php
            /**
             * realia_after_property_box_image
             */
            do_action( 'realia_after_property_box_image', $property->ID );
            ?>
        </a>
        
    </div><!-- /.property-image -->
    <div class="property-top">
        <?php
        if ( class_exists('Homesweet_Realia_Compare') ) {
            Homesweet_Realia_Compare::display_compare_btn( $property->ID );
        }
        ?>
        <!-- share -->
        <?php homesweet_realia_display_sharebox($property); ?>

        <?php if ( class_exists('Homesweet_Realia_Favorite') ) { ?>
            <?php Homesweet_Realia_Favorite::btn_display( $property->ID ); ?>
        <?php } ?>
    </div>
    <div class="property-box-content">
        <h3 class="entry-title"><a href="<?php the_permalink( $property ); ?>"><?php echo get_the_title( $property ) ?></a></h3>
        <div class="property-box-title-wrap">
            <div class="property-box-title">
                <?php homesweet_realia_display_address($property); ?>
            </div>
        </div><!-- /.property-box-title -->
        <?php homesweet_realia_display_labels($property); ?>
        <?php homesweet_realia_display_price($property); ?>
    </div><!-- /.property-box-content -->
</div>