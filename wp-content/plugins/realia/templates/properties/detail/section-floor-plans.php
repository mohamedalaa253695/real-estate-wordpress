<div class="property-content">
    <?php $plans = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'plans', true ); ?>

    <?php if ( ! empty( $plans ) ) : ?>
        <div class="property-floor-plans">
            <?php if ( ! empty( $section_title ) ): ?><h2><?php echo esc_attr( $section_title ); ?></h2><?php endif; ?>

            <?php foreach ( $plans as $id => $url ) : ?>
                <a href="<?php echo esc_url( $url ); ?>" rel="property-plans">
                    <?php echo wp_get_attachment_image( $id, 'thumbnail' ); ?>
                </a>
            <?php endforeach; ?>
        </div><!-- /.property-floor-plans -->
    <?php endif; ?>
</div><!-- /.property-content -->
