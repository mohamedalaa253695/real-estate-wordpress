<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$agrs = array(
	'post_type' => 'package',
	'posts_per_page' => 1,
	'post_status' => 'publish',
	'name' => $package,
);

$loop = new WP_Query($agrs);
if ( $loop->have_posts() ) {
?>
<div class="widget widget-package <?php echo esc_attr($el_class); ?> <?php echo esc_attr((!empty($is_featured)) ? 'is_featured' : ''); ?>">
    <div class="widget-content">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<?php echo Realia_Template_Loader::load( 'submission/package', array('label' => $label) ); ?>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
    </div>
</div>
<?php
}
?>