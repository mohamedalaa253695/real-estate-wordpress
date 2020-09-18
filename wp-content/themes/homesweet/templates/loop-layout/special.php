<div class="properties-special">
	<div class="clearfix">
		<?php $i = 0; while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<?php if ( $i%4 == 0 ) { ?>
				<div class="row">
			<?php } ?>
				<?php if ($i%4 == 0) { ?>
					<div class="col-md-6 box-style1-first">
						<?php echo Realia_Template_Loader::load( 'properties/box-style2', array( 'image_size' => 'homesweet-special-large') ); ?>
					</div>
				<?php } elseif ($i%4 == 1) { ?>
					<div class="col-md-6 box-style1-second">
						<?php echo Realia_Template_Loader::load( 'properties/box-style2', array( 'image_size' => 'homesweet-special-medium') ); ?>
					</div>
				 <?php } else { ?>
					<div class="col-md-3 col-sm-6 <?php echo esc_attr($i <= 2 ? 'row-'.$i : ''); ?>">
						<?php echo Realia_Template_Loader::load( 'properties/box-style2', array( 'image_size' => 'homesweet-special-small') ); ?>
					</div>
				<?php } ?>
					
			<?php if ( $i%4 == 3 || $i == ($loop->post_count - 1) ) { ?>
				</div>
			<?php } ?>
		<?php $i++; endwhile; ?>
	</div>
</div>
<?php wp_reset_postdata(); ?>