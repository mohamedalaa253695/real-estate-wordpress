<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// property 
homesweet_realia_property_views(get_the_ID());

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('detail-property'); ?>>
	<div class="property-detail-actions">
		<?php do_action( 'property_actions', get_the_ID() ); ?>
	</div><!-- /.property-detail-actions -->

	<?php 
	$version = homesweet_get_config('property_single_layout_type', 'layout1');
	if (empty($version)) {
		$version = 'layout1';
	}
	?>
	<div class="property-layout-<?php echo esc_attr($version); ?>">
		<?php echo Realia_Template_Loader::load('single-layout/'.$version); ?>
	</div>
	
</article><!-- #post-## -->