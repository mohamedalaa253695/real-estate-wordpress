<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $property = isset( $property ) ? $property : get_post(); ?>

<?php $is_sticky = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'sticky', true ); ?>

<div class="property-box">
    <div class="property-box-image <?php if ( ! has_post_thumbnail( $property ) ) { echo 'without-image'; } ?>">
        <a href="<?php the_permalink( $property ); ?>" class="property-box-image-inner <?php if ( ! empty( $agent ) ) : ?>has-agent<?php endif; ?>">
			<?php
	        /**
	         * realia_before_property_box_image
	         */
	        do_action( 'realia_before_property_box_image', $property->ID );
	        ?>

            <?php if ( has_post_thumbnail( $property ) ) : ?>
				<?php echo get_the_post_thumbnail( $property, 'property-box-thumbnail' ); ?>
            <?php endif; ?>

			<?php
	        /**
	         * realia_after_property_box_image
	         */
	        do_action( 'realia_after_property_box_image', $property->ID );
	        ?>

            <?php $is_featured = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'featured', true ); ?>
            <?php $is_reduced = get_post_meta( $property->ID, REALIA_PROPERTY_PREFIX . 'reduced', true ); ?>

            <?php if ( $is_featured && $is_reduced ) : ?>
                <span class="property-badge"><?php echo __( 'Featured', 'realia' ); ?> / <?php echo __( 'Reduced', 'realia' ); ?></span>
            <?php elseif ( $is_featured ) : ?>
                <span class="property-badge"><?php echo __( 'Featured', 'realia' ); ?></span>
            <?php elseif ( $is_reduced ) : ?>
                <span class="property-badge"><?php echo __( 'Reduced', 'realia' ); ?></span>
            <?php endif; ?>

            <?php if ( $is_sticky ) : ?>
                <span class="property-badge property-badge-sticky"><?php echo __( 'TOP', 'realia' ); ?></span>
            <?php endif; ?>
        </a>
    </div><!-- /.property-image -->

    <div class="property-box-content">
        <div class="property-box-title">
	        <?php
	        /**
	         * realia_before_property_box_title
	         */
	        do_action( 'realia_before_property_box_title', $property->ID );
	        ?>

            <h3><a href="<?php the_permalink( $property ); ?>"><?php echo get_the_title( $property ) ?></a></h3>

	        <?php
	        /**
	         * realia_after_property_box_title
	         */
	        do_action( 'realia_after_property_box_title', $property->ID );
	        ?>
        </div><!-- /.property-box-title -->

	    <div class="property-box-body">
		    <?php
		    /**
		     * realia_before_property_box_body
		     */
		    do_action( 'realia_before_property_box_body', $property->ID );
		    ?>

	        <?php $type = Realia_Query::get_property_type_name( $property->ID ); ?>
	        <?php if ( ! empty( $type ) ) : ?>
	            <div class="property-box-type">
	                <?php echo wp_kses( $type, wp_kses_allowed_html( 'post' ) ); ?>
	            </div><!-- /.property-box-type -->
	        <?php endif; ?>

	        <?php $price = Realia_Price::get_property_price( $property->ID ); ?>
	        <?php if ( ! empty( $price ) ) : ?>
	            <div class="property-box-price">
	                <?php echo wp_kses( $price, wp_kses_allowed_html( 'post' ) ); ?>
	            </div><!-- /.property-box-price -->
	        <?php endif; ?>

		    <div class="property-box-read-more">
			    <a href="<?php the_permalink( $property ); ?>"><?php echo __( 'Read More', 'realia' ); ?></a>
		    </div><!-- /.property-box-price -->

		    <?php
		    /**
		     * realia_after_property_box_body
		     */
		    do_action( 'realia_after_property_box_body', $property->ID );
		    ?>
	    </div><!-- /.property-box-body -->
    </div><!-- /.property-box-content -->
</div>
