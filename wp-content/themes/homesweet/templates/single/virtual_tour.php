<?php $virtual_tour = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'virtual_tour', true ); ?>
<?php if ( ! empty( $virtual_tour ) ) : ?>
	<div id="property-section-virtual_tour" class="property-section property-virtual_tour">
		<h3><?php echo esc_html__( 'Virtual Tour', 'homesweet' ); ?></h3>
		<div class="virtual_tour-embed-wrapper">
			<?php echo do_shortcode($virtual_tour); ?>
		</div>
	</div>
<?php endif; ?>