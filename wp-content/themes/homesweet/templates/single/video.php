<?php $video = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'video', true ); ?>
<?php if ( ! empty( $video ) ) : ?>
	<div id="property-section-video" class="property-section property-video">
		<h3><?php echo esc_html__( 'Video', 'homesweet' ); ?></h3>
		<div class="video-embed-wrapper">
			<?php echo apply_filters( 'the_content', '[embed width="1280" height="720"]' . esc_attr( $video ) . '[/embed]' ); ?>
		</div>
	</div>
<?php endif; ?>