<?php $floor = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'plans', true ); ?>
<?php if ( ! empty( $floor ) ) : ?>
	<div id="property-section-floor" class="property-floor-index property-section">
		<h3><?php echo esc_html__('Floor Plans', 'homesweet'); ?></h3>
		<div class="owl-carousel nav-style2" data-smallmedium="1" data-extrasmall="1" data-items="1" data-carousel="owl" data-pagination="false" data-nav="true">
			<?php foreach ( $floor as $id => $src ) : ?>
				<a rel="<?php echo esc_url( $src ); ?>" href="<?php echo esc_url( $src ); ?>" class="image-popup">
					<?php echo wp_get_attachment_image( $id, 'property-thumbnail' ); ?>
				</a>
			<?php endforeach; ?>
		</div>
	</div><!-- /.property-gallery-list -->
<?php endif; ?>