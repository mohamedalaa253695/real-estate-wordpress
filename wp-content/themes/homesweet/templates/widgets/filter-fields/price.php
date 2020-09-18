<div class="form-group no-border">
	<?php
		$min = ! empty( $_GET['filter-price-from'] ) ? esc_attr( $_GET['filter-price-from'] ) : (!empty($instance['price_min']) ? $instance['price_min'] : 0);
		$max = ! empty( $_GET['filter-price-to'] ) ? esc_attr( $_GET['filter-price-to'] ) : (!empty($instance['price_max']) ? $instance['price_max'] : 1000000);

		
	?>
	<div class="price-wrapper"><?php echo esc_html__('Price Range:', 'homesweet'); ?> 
		<span class="price">
			<span class="price_from"><?php echo esc_html__('From ','homesweet') ?><?php homesweet_realia_display_price_html($min); ?></span>
			<span class="price_to"><?php echo esc_html__('to ','homesweet') ?><?php homesweet_realia_display_price_html($max); ?></span>
		</span>
	</div>
  	<div class="price_range" data-max="<?php echo esc_attr(!empty($instance['price_max']) ? $instance['price_max'] : 1000000); ?>" data-min="<?php echo esc_attr(!empty($instance['price_min']) ? $instance['price_min'] : 0); ?>"></div>

  	<input type="hidden" name="filter-price-from" class="filter-price-from" value="<?php echo esc_attr($min); ?>">
  	<input type="hidden" name="filter-price-to" class="filter-price-to" value="<?php echo esc_attr($max); ?>">
</div>