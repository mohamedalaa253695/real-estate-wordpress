<?php
$map_location = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'map_location', true );
$virtual_tour = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'virtual_tour', true );
$active = homesweet_get_config('property_header_active_tab', 'map');
?>

<div class="tabs-gallery-map">
	<ul class=" nav-tabs nav-table">
		
        <?php if ( ! empty( $map_location ) && 2 == count( $map_location ) ) : ?>
        	<li class="<?php echo esc_attr($active == 'map' ? 'active' : ''); ?>">
				<a class="tab-google-map" href="#tab-gallery-map-map" data-toggle="tab">
	                <i class="icon-ap_pin"></i>
	                <span><?php esc_html_e('Map View', 'homesweet'); ?></span>
	            </a>
	        </li>
	        <li>
				<a class="tab-google-street-view-map <?php echo esc_attr($active == 'mapview' ? 'active' : ''); ?>" href="#tab-gallery-map-mapview" data-toggle="tab">
	            	<i class=" icon-ap_street-view"></i>
	            	<span><?php esc_html_e('Street View', 'homesweet'); ?></span>
	            </a>
	        </li>
    	<?php endif; ?>

    	<?php if ( ! empty( $virtual_tour ) ) : ?>
			<li class="<?php echo esc_attr($active == 'virtual_tour' ? 'active' : ''); ?>">
				<a href="#tab-gallery-map-virtual_tour" data-toggle="tab">
	                <i class="icon-map"></i>
	                <span><?php esc_html_e('360 Virtual Tour', 'homesweet'); ?></span>
	            </a>
	        </li>
		<?php endif; ?>
	</ul>
	<div class="tab-content tab-content-descrip">

		<?php if ( ! empty( $map_location ) && 2 == count( $map_location ) ) : ?>
			<div id="tab-gallery-map-map" class="tab-pane <?php echo esc_attr($active == 'map' ? 'active' : ''); ?>">
				<?php echo Realia_Template_Loader::load('single/map'); ?>
			</div>

			<div id="tab-gallery-map-mapview" class="tab-pane <?php echo esc_attr($active == 'mapview' ? 'active' : ''); ?>">
				<div id="single-tab-property-street-view-map" style="height: 400px"></div>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $virtual_tour ) ) : ?>
			<div id="tab-gallery-map-virtual_tour" class="tab-pane <?php echo esc_attr($active == 'virtual_tour' ? 'active' : ''); ?>">
				<?php echo Realia_Template_Loader::load('single/virtual_tour'); ?>
			</div>
		<?php endif; ?>
	</div>
</div>