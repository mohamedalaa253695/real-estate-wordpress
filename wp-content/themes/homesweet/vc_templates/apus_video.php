<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$image_bg = wp_get_attachment_image_src($image_bg,'full');
?>
<div class="widget-video row">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="left-content <?php echo (!empty($image_bg) ? 'has-bg' :''); ?>">
            <?php if ( !empty($image_bg) && isset($image_bg[0]) ): ?>
                <div class="bg-img">
                    <?php homesweet_display_image($image_bg); ?>
                </div>
            <?php endif; ?>
            <div class="video-wrapper-inner">
            	<div class="video">
            		<?php $img = wp_get_attachment_image_src($image,'full'); ?>
            		<?php if ( !empty($img) && isset($img[0]) ): ?>
            			<a class="popup-video" href="<?php echo esc_url_raw($video_link); ?>">
                            <?php homesweet_display_image($img); ?>
                    	</a>
                    <?php endif; ?>
            	</div>
        	</div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <?php if ($title!=''): ?>
            <h3 class="widget-title">
                <span><?php echo trim($title); ?></span>
            </h3>
        <?php endif; ?>
        <?php if(wpb_js_remove_wpautop( $content, true )){ ?>
            <div class="description">
                <?php echo wpb_js_remove_wpautop( $content, true ); ?>
            </div>
        <?php } ?>
    </div>
</div>