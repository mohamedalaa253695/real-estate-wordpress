<?php
$show_similar = homesweet_get_config('show_property_similar', true);
if (!$show_similar) {
    return;
}
Realia_Query::loop_properties_similar();

?>

<?php if ( have_posts() ) : ?>
    <div class="property-similar-properties widget">
        <h3 class="widget-title"><span><?php echo esc_html__( 'Similar', 'homesweet' ); ?></span> <?php echo esc_html__( 'properties', 'homesweet' ); ?></h3>
        	<div class="row">
	            <?php while ( have_posts() ) : the_post(); ?>
	            	<div class="col-xs-12 col-md-4 col-sm-6">
	                	<?php echo Realia_Template_Loader::load( 'properties/box' ); ?>
	                </div>
	            <?php endwhile; ?>
            </div>
    </div><!-- /.similar-properties -->
<?php endif?>

<?php wp_reset_query(); ?>