<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
?>
<div class="widget-text-heading <?php echo esc_attr($el_class).' '.esc_attr($style); ?>">
    <?php if ( trim($title)!='' || trim($sub_title)!='' ) { ?>
        <h3 class="title">
            <span><?php echo trim( $title ); ?></span> 
            <?php if ( trim($sub_title)!='' ) { ?>
                <?php echo trim( $sub_title ); ?>
            <?php } ?>
        </h3>
    <?php } ?>
    <?php if ( trim($descript)!='' ) { ?>
        <div class="description">
            <?php echo trim( $descript ); ?>
        </div>
    <?php } ?>
</div>