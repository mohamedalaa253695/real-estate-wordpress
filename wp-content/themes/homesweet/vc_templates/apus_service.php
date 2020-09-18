<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
?>
<div class="widget-service <?php echo esc_attr($el_class.' '.$style); ?>">
	<?php if($title!=''): ?>
        <h3 class="title" >
           <span><?php echo esc_attr( $title ); ?></span>
        </h3>
    <?php endif; ?>
    <?php if(wpb_js_remove_wpautop( $content, true )){ ?>
        <div class="description">
            <?php echo wpb_js_remove_wpautop( $content, true ); ?>
        </div>
    <?php } ?>
</div>