<?php
$show_subproperties = homesweet_get_config('show_property_sub', true);
if (!$show_subproperties) {
	return;
}
$post = get_post();
$author_id = $post->post_author;
$subproperties = Realia_Post_Type_Property::get_properties( $author_id, "publish", get_the_ID() );
?>
<?php if ( is_array( $subproperties ) && ! empty( $subproperties ) ) : ?>
	<div class="property-subproperties widget">
		<h3 class="widget-title"><span><?php echo esc_html__( 'Sub', 'homesweet' ); ?></span> <?php echo esc_html__( 'Properties', 'homesweet' ); ?></h3>
		<div class="row">
			<?php foreach ( $subproperties as $subproperty ): ?>
				<div class="col-sm-4 col-xs-12">
					<?php echo Realia_Template_Loader::load( 'properties/box', array( 'property' => $subproperty ) ); ?>
				</div>
			<?php endforeach; ?>
		</div><!-- /.row -->
	</div><!-- /.subproperties -->
<?php endif?>