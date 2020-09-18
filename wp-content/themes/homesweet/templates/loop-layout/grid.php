<?php
$item_style = !isset($item_style) || empty($item_style) ? '' : '-'.$item_style;
$bcol = 12/$columns;
if ($columns == 5) {
	$bcol = 'cus-5';
}
$class = 'col-md-'.esc_attr($bcol).($columns > 1 ? ' col-sm-6 col-xs-12' : '');

?>
<div class="properties-grid">
	<div class="row">
		<?php $count = 0; while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<div class="<?php echo esc_attr($contract); ?> <?php echo esc_attr($class); ?><?php echo ($count%$columns == 0) ? ' col-md-clear':''; ?> <?php echo ($columns > 1 && $count%2 == 0) ? ' col-sm-clear' : ''; ?>">
				<?php echo Realia_Template_Loader::load( 'properties/box'.$item_style ); ?>
			</div>
		<?php $count++; endwhile; ?>
	</div>
</div>

<?php wp_reset_postdata(); ?>