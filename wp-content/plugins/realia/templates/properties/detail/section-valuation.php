<div class="property-content">
    <!-- VALUATION -->
    <?php $valuation = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'valuation_group', true ); ?>

    <?php if ( ! empty( $valuation ) && is_array( $valuation ) && count( $valuation[0] ) > 0 ) : ?>
        <div class="property-valuation">
            <?php if ( ! empty( $section_title ) ): ?><h2><?php echo esc_attr( $section_title ); ?></h2><?php endif; ?>

            <?php foreach ( $valuation as $group ) : ?>
                <dl class="property-valuation-item">
                    <dt><?php echo empty( $group[REALIA_PROPERTY_PREFIX . 'valuation_key'] ) ? '' : esc_attr( $group[REALIA_PROPERTY_PREFIX . 'valuation_key'] ); ?></dt>
                    <dd>
                        <div class="bar-valuation"
                             style="width: <?php echo esc_attr( $group[ REALIA_PROPERTY_PREFIX . 'valuation_value' ] ); ?>%"
                             data-percentage="<?php echo empty( $group[REALIA_PROPERTY_PREFIX . 'valuation_value'] ) ? '' : esc_attr( $group[REALIA_PROPERTY_PREFIX . 'valuation_value'] ); ?>">
                        </div>
                    </dd>
                    <span class="percentage-valuation"><?php echo empty( $group[REALIA_PROPERTY_PREFIX . 'valuation_value'] ) ? '' : esc_attr( $group[REALIA_PROPERTY_PREFIX . 'valuation_value'] ); ?> %</span>
                </dl><!-- /.property-valuation-item -->
            <?php endforeach; ?>
        </div><!-- /.property-valuation -->
    <?php endif; ?>
</div><!-- /.property-content -->