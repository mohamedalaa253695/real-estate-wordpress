<?php $images = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'plans', true ); ?>

<?php if ( ! empty( $images ) ) : ?>
	<div class="property-floor-plans">
		<?php foreach ( $images as $id => $url ) : ?>
            <a href="<?php echo esc_url( $url ); ?>" rel="property-plans">
                <?php echo wp_get_attachment_image( $id, 'thumbnail' ); ?>
            </a>
        <?php endforeach; ?>
	</div><!-- /.property-floor-plans -->
<?php endif; ?>