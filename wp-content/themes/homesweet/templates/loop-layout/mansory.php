<?php
$item_style = !isset($item_style) || empty($item_style) ? '' : '-'.$item_style;
$bcol = 12/$columns;
if ($columns == 5) {
	$bcol = 'cus-5';
}
$class = 'col-md-'.esc_attr($bcol).($columns > 1 ? ' col-sm-6' : '');

if ( !isset($ajax_load) || !$ajax_load ) {
	wp_enqueue_script( 'homesweet-isotope', get_template_directory_uri().'/js/isotope.pkgd.min.js', array( 'jquery' ) );
	$key_rand = !empty($key_rand) ? $key_rand : homesweet_random_key();

?>
<div class="properties-grid">
	<div id="isotope-items-<?php echo esc_attr($key_rand); ?>" class="isotope-items row" data-isotope-duration="400">
<?php } ?>

		<?php $count = 0; while ( $loop->have_posts() ) : $loop->the_post();
			$contract = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'contract', true );
		?>
			<div class="isotope-item all <?php echo esc_attr($contract); ?> <?php echo esc_attr($class); ?>" data-category="<?php echo esc_attr($contract); ?>">
				<?php echo Realia_Template_Loader::load( 'properties/box'.$item_style ); ?>
			</div>
		<?php $count++; endwhile; ?>

<?php if ( !isset($ajax_load) || !$ajax_load ) { ?>
	</div>
</div>
<?php } ?>

<?php wp_reset_postdata(); ?>