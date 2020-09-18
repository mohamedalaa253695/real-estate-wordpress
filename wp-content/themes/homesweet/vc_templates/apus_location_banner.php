<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if ( !empty($location) ) {
	$term = get_term_by( 'slug', $location, 'locations' );
	if ($term) {
		?>
		<div class="widget widget-location-banner <?php echo esc_attr($el_class); ?>">
			<a href="<?php echo esc_url(get_term_link($term)); ?>" class="widget-content">
				<?php $img = wp_get_attachment_image_src($image, 'full'); ?>
		        <?php homesweet_display_image($img); ?>
		        <div class="content-meta">
		        	<?php if ( !empty($title) ) { ?>
		        		<h3 class="title"><?php echo esc_html($title); ?></h3>
		        	<?php } ?>
		        	<div class="properties">
		        		<?php echo sprintf(_n('%s Property', '%s Properties', $term->count, 'homesweet'), $term->count); ?>
		        	</div>
		        </div>
	        </a>
		</div>
		<?php
	}
}