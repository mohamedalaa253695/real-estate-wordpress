<?php $valuation = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'valuation_group', true ); ?>

<?php if ( ! empty( $valuation ) && is_array( $valuation ) && count( $valuation[0] ) > 0 ) : ?>
    <div id="property-section-valuation" class="property-section property-valuation">
        <h3><?php echo esc_html__('Valuation', 'homesweet'); ?></h3>
        <?php foreach ( $valuation as $group ) : ?>
            <div class="valuation-item clearfix">
                <div class="clearfix">
                    <div class="valuation-label pull-left"><?php echo empty( $group[REALIA_PROPERTY_PREFIX . 'valuation_key'] ) ? '' : esc_attr( $group[REALIA_PROPERTY_PREFIX . 'valuation_key'] ); ?></div>
                    <span class="percentage-valuation pull-right"><?php echo empty( $group[REALIA_PROPERTY_PREFIX . 'valuation_value'] ) ? '' : esc_attr( $group[REALIA_PROPERTY_PREFIX . 'valuation_value'] ); ?> %</span>
                </div>
                <div class="property-valuation-item progress" >
                    <div class="bar-valuation progress-bar progress-bar-info progress-bar-striped"
                         style="width: <?php echo esc_attr( $group[ REALIA_PROPERTY_PREFIX . 'valuation_value' ] ); ?>%"
                         data-percentage="<?php echo empty( $group[REALIA_PROPERTY_PREFIX . 'valuation_value'] ) ? '' : esc_attr( $group[REALIA_PROPERTY_PREFIX . 'valuation_value'] ); ?>">
                    </div>
                </div><!-- /.property-valuation-item -->
                
            </div>
        <?php endforeach; ?>
    </div><!-- /.property-valuation -->
<?php endif; ?>