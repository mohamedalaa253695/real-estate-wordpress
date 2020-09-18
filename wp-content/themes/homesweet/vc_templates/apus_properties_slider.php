<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$types = array();
if ( isset($types) && !empty($types) ) {
    $types = explode(',', $types);
}

$statuses = array();
if ( isset($statuses) && !empty($statuses) ) {
    $statuses = explode(',', $statuses);
}

$locations = array();
if ( isset($locations) && !empty($locations) ) {
    $locations = explode(',', $locations);
}
$args = array(
	'contract' => $contract,
	'orderby' => $orderby,
	'number' => $number,
	'types' => $types,
	'statuses' => $statuses,
	'locations' => $locations,
);
$loop = homesweet_get_properties( $args );
if ( $loop->have_posts() ) {
?>
	<div class="widget-properties-slider <?php echo esc_attr($el_class.' '.$style); ?>">
	    <div class="widget-content">
		    <?php if ($style == 'layout1' || $style == 'layout3') { ?>
	    		<div class="owl-carousel" data-items="1" data-carousel="owl" data-smallmedium="1" data-extrasmall="1" data-margin="0" data-pagination="false" data-nav="true">
				    <?php while ( $loop->have_posts() ): $loop->the_post(); ?>
				        <?php echo Realia_Template_Loader::load( 'properties/box-slider' ); ?>
				    <?php endwhile; ?>
				</div> 
				<?php wp_reset_postdata(); ?>
			<?php } else { ?>
				<div class="owl-carousel" data-items="<?php echo esc_attr($columns); ?>" data-carousel="owl" data-smallmedium="2" data-extrasmall="1" data-margin="0" data-pagination="false" data-nav="true">
				    <?php while ( $loop->have_posts() ): $loop->the_post(); ?>
				        <?php echo Realia_Template_Loader::load( 'properties/box-slider1' ); ?>
				    <?php endwhile; ?>
				</div> 
				<?php wp_reset_postdata(); ?>
			<?php } ?>
	    </div>
	</div>
<?php
}