<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$args = array(
	'post_type' => 'agent',
	'posts_per_page' => isset($number) && $number ? $number : 3
);
$loop = new WP_Query($args);
$bcol = 12 / $columns;
if ($loop->have_posts()): ?>
	<div class="widget widget-agents <?php echo esc_attr($layout_type); ?>">
		<?php if ($layout_type == 'carousel'): ?>
			<div class="owl-carousel <?php echo ($nav_style == 'style1')? 'nav-style2 owl-carousel-nav-top' : '' ?>" data-items="<?php echo esc_attr($columns); ?>" data-carousel="owl" data-smallmedium="2" data-extrasmall="1" data-pagination="false" data-nav="true">
				<?php while ( $loop->have_posts() ): $loop->the_post(); ?>
			        <?php echo Realia_Template_Loader::load( 'agents/box' ); ?>
			    <?php endwhile; ?>
			</div>
		<?php else: ?>
			<div class="row">
				<?php $count = 1; while ( $loop->have_posts() ): $loop->the_post(); ?>
					<div class="col-md-<?php echo esc_attr($bcol); ?> col-sm-6 col-xs-12 <?php echo ($count%$columns) ==1?' col-md-clear':''; ?> <?php echo ($count%2) == 1?' col-sm-clear':''; ?>">
			        	<?php echo Realia_Template_Loader::load( 'agents/box' ); ?>
			        </div>
			    <?php $count++; endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>