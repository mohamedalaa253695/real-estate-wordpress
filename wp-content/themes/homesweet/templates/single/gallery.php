<?php
	global $post;
	$gallery = homesweet_realia_get_full_gallery_ids($post);
	$image_size = 'homesweet-gallery-v1';
	$thumb_col = 9;
	$layout = homesweet_get_config('property_single_layout_type', 'layout1');
	$data_loop = 'false';
	switch ($layout) {
		case 'layout1':
			$image_size = 'homesweet-gallery-v1';
			$data_loop = 'true';
			break;
		case 'layout2':
			$image_size = 'homesweet-gallery-v2';
			$thumb_col = 6;
			break;
		case 'layout3':
		case 'layout5':
			$image_size = 'homesweet-gallery-v3';
			$thumb_col = 8;
			break;
		case 'layout4':
			$image_size = 'homesweet-gallery-v4';
			$data_loop = 'true';
			break;
	}
?>
<?php if ( ! empty( $gallery ) ) : ?>
	<div class="property-gallery">
		<div class="property-gallery-preview property-box-image-inner">
			<?php $is_sticky = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'sticky', true ); ?>
            <?php if ( $is_sticky ) : ?>
            	<span class="meta-top">
                	<span class="property-badge property-badge-sticky"><?php echo esc_html__( 'TOP', 'homesweet' ); ?></span>
                </span>
            <?php endif; ?>

			<div class="owl-carousel property-gallery-preview-owl" data-smallmedium="1" data-extrasmall="1" data-items="1" data-carousel="owl"
				<?php if (count($gallery) > 1){ ?> data-loop="<?php echo esc_attr($data_loop); ?>" <?php } ?> data-pagination="false" data-nav="true" data-margin="0">
				<?php foreach ( $gallery as $id => $src ) : ?>
					<?php echo wp_get_attachment_image( $id , $image_size );?>
				<?php endforeach; ?>
			</div>
		</div>
		<?php if ( $layout != 'layout1' && $layout != 'layout4' ) { ?>
			<div class="owl-carousel property-gallery-index" data-smallmedium="<?php echo esc_attr($thumb_col); ?>" data-extrasmall="3" data-items="<?php echo esc_attr($thumb_col); ?>" data-carousel="owl" data-pagination="false" data-nav="true" data-margin="10">
				<?php $index = 0; ?>
				<?php foreach ( $gallery as $id => $src ) : ?>
					<div <?php echo ( 0 == $index ) ? 'class="active thumb-link"' : 'class="thumb-link"'; ?>>
						<a href="<?php echo esc_url( $src ); ?>">
							<?php echo wp_get_attachment_image( $id, 'homesweet-gallery-thumbnails' ); ?>
						</a>
						<?php $index++; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php } ?>
	</div><!-- /.property-gallery -->
<?php endif; ?>