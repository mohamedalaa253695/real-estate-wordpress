<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<header class="entry-header">
	<div class="top-inner">
		<?php echo Realia_Template_Loader::load('single/tabs-gallery-map-virtual_tour'); ?>
		<?php echo Realia_Template_Loader::load('single/content-header'); ?>
	</div>
	<?php echo Realia_Template_Loader::load('single/nav'); ?>
</header>
<div class="container">
	
	<div class="entry-content sticky-v-wrapper">
		<div class="apus-col-8">
			<div class="property-content">
				<?php
				$contents = homesweet_get_content_sort();

				if ( !empty($contents) ) {
					foreach ($contents as $key => $value) {
						echo Realia_Template_Loader::load( 'single/'.$key );
					}
				}
				?>
				
			</div>
		</div>
		<div class="apus-col-4 sidebar-detail sidebar <?php echo (homesweet_get_config('enable_sticky_sidebar', 1) ? 'sticky-this' : ''); ?>">
			<!-- sidebar -->
			<?php if ( is_active_sidebar( 'single-property-sidebar' ) ) : ?>
				<?php dynamic_sidebar( 'single-property-sidebar' ); ?>
			<?php endif; ?>
		</div>
	</div>

	<!-- SUBPROPERTIES -->
	<?php echo Realia_Template_Loader::load('single/subproperties'); ?>
	
    <!-- SIMILAR PROPERTIES -->
    <?php echo Realia_Template_Loader::load('single/similar'); ?>
</div>