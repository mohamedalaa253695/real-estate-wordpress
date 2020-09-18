<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$height = !empty($height) ? $height : '400px';
?>
<div class="widget-properties-map <?php echo esc_attr($el_class); ?>">
	<div id="widget-properties-map-wrapper" data-contract="<?php echo esc_attr($contract);?>" data-orderby="<?php echo esc_attr($orderby);?>"
		data-number="<?php echo esc_attr($number);?>" data-types="<?php echo esc_attr($types);?>" data-statuses="<?php echo esc_attr($statuses);?>"
		data-locations="<?php echo esc_attr($locations);?>" <?php echo (homesweet_get_config('map_custom_style') ? 'data-style="'.esc_attr(homesweet_get_config('map_custom_style')).'"' : ''); ?> style="height: <?php echo esc_attr($height)?>; width: 100%;">
	</div>
</div>
