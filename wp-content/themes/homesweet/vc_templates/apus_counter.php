<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$text_color = $text_color?'style="color:'. $text_color .';"' : "";
wp_enqueue_script( 'homesweet-counter-js', get_template_directory_uri().'/js/jquery.counterup.min.js', array( 'jquery' ) );
wp_enqueue_script( 'homesweet-waypoints-js', get_template_directory_uri().'/js/waypoints.min.js', array( 'jquery' ) );

?>
<?php $img = wp_get_attachment_image_src($image,'full'); ?>
<div class="counters <?php echo esc_attr($el_class.' '.$style); ?>">
	<?php if ( !empty($img) && isset($img[0]) ): ?>
        <div class="counter-icon">
            <img src="<?php echo esc_url_raw($img[0]); ?>" alt="">
        </div>
    <?php endif; ?>
    <div class="item-inner">
		<div class="counter-wrap text-second">
		   	<span class="counter counterUp"><?php echo (int)$number ?></span> <?php if(!empty($sub)) {?> <span class="plus"><?php echo trim($sub); ?> <?php } ?></span>
		</div> 
	    <h3 class="title" <?php echo trim($text_color); ?>><?php echo trim($title); ?></h3>
    </div>
</div>