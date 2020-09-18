<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$images = $images ? explode(',', $images) : array();
$count = 0;
if ( !empty($images) ):
?>	
	<div class="widget widget-gallery <?php echo esc_attr($el_class);?>">
	    <?php if ($title!=''): ?>
	        <h3 class="widget-title">
	            <span><?php echo esc_attr( $title ); ?></span>
	        </h3>
	    <?php endif; ?>
	    <div class="widget-content">
			<div class="owl-carousel owl-carousel-bottom posts" data-smallmedium="<?php echo esc_attr($columns); ?>" data-extrasmall="2" data-items="<?php echo esc_attr($columns); ?>" data-carousel="owl" data-pagination="true" data-nav="false">
				<?php foreach ($images as $image): ?>
					<?php if ($count%$rows == 0) { ?>
	    				<div class="item">
    				<?php } ?>
						<?php $img = wp_get_attachment_image_src($image,'full'); ?>
						<?php if ( !empty($img) && isset($img[0]) ): ?>
							<div class="image">
								<a href="<?php echo esc_url_raw($img[0]); ?>" class="popup">
		                    		<img src="<?php echo esc_url_raw($img[0]); ?>" alt="">
		                    	</a>
	                    	</div>
		                <?php endif; ?>
	                <?php if ($count%$rows == ($rows - 1) || $count == (count($images) - 1) ) { ?>
			        	</div>
			        <?php } ?>
				<?php $count++; endforeach; ?>
			</div>
		</div>
	</div>
<?php endif; ?>