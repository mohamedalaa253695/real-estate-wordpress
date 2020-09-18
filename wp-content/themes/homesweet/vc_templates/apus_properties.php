<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$ptypes = array();
if ( isset($types) && !empty($types) ) {
    $ptypes = explode(',', $types);
}

$pstatuses = array();
if ( isset($statuses) && !empty($statuses) ) {
    $pstatuses = explode(',', $statuses);
}

$plocations = array();
if ( isset($locations) && !empty($locations) ) {
    $plocations = explode(',', $locations);
}
$args = array(
	'contract' => $contract,
	'orderby' => $orderby,
	'number' => $number,
	'types' => $ptypes,
	'statuses' => $pstatuses,
	'locations' => $plocations,
);
$loop = homesweet_get_properties( $args );
$check = array('mansory');

if ( $loop->have_posts() ) {
	$key_rand = homesweet_random_key();
?>
	<div id="widget-properties<?php echo esc_attr($key_rand); ?>" class="widget widget-properties <?php echo esc_attr($el_class.' layout-'.$layout_type); ?>">
		<div class="clearfix">
		<?php if ( $title != '' ) { ?>
			<?php if ( $title != '' ) { ?>
		        <h3 class="widget-title" >
		           <span><?php echo esc_attr( $title ); ?></span>
		           <?php if ( trim($sub_title)!='' ) { ?>
		                <?php echo trim( $sub_title ); ?>
		            <?php } ?>
		        </h3>
		    <?php } ?>
	    <?php } ?>
	    <?php if (in_array($layout_type, $check) && $show_contract_filter ) { ?>
	    	<div class="contract-filter">
	    		<ul class="isotope-filter" data-related-grid="isotope-items-<?php echo esc_attr($key_rand); ?>">
	    			<li><a href="#" data-filter=".all"><?php esc_html_e('All', 'homesweet'); ?></a></li>
	    			<li><a href="#" data-filter=".SALE"><?php esc_html_e('For Rent', 'homesweet'); ?></a></li>
	    			<li><a href="#" data-filter=".RENT"><?php esc_html_e('For Sale', 'homesweet'); ?></a></li>
	    		</ul>
	    	</div>
	    <?php } ?>
	    </div>
	    <div class="widget-content">
    		<?php echo Realia_Template_Loader::load( 'loop-layout/'.$layout_type, array( 'loop' => $loop, 'columns' => $columns, 'item_style' => $item_style,'nav_style' => $nav_style, 'show_pagination' => $show_pagination, 'key_rand' => $key_rand ) ); ?>

    		<?php if ( in_array($layout_type, $check) && $show_viewmore_button ) {
    			$max_pages = $loop->max_num_pages;
			?>
				<div class="clearfix load-product text-center space-tb-30">
    				<a href="#widget-properties<?php echo esc_attr($key_rand); ?>" class="btn view-more-property <?php echo esc_attr($max_pages <= 1 ? 'hidden' : ''); ?>" data-columns="<?php echo esc_attr($columns);?>" data-item_style="<?php echo esc_attr($item_style);?>" data-layout_type="<?php echo esc_attr($layout_type);?>" data-contract="<?php echo esc_attr($contract);?>" data-orderby="<?php echo esc_attr($orderby);?>" data-number="<?php echo esc_attr($number);?>" data-types="<?php echo esc_attr($types);?>" data-statuses="<?php echo esc_attr($statuses);?>"  data-locations="<?php echo esc_attr($locations);?>" data-page="1" data-max-page="<?php echo esc_attr($max_pages); ?>">
    					<?php esc_html_e('View More Property', 'homesweet'); ?>
    				</a>

    				<p class="all-properties-loaded<?php echo esc_attr($max_pages > 1 ? ' hidden' : ''); ?>"><?php esc_html_e('All Properties Loaded', 'homesweet'); ?></p>
    			</div>
    		<?php } ?>
	    </div>
	</div>
<?php
}