<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="main-content-header-top">
    <div class="container">
        <?php if ( homesweet_get_config('property_archive_default_header_filter', true) && is_active_sidebar( 'properties-default-top-sidebar' ) ): ?>
            <div class="properties-default-top-sidebar-wrapper">
                <?php dynamic_sidebar( 'properties-default-top-sidebar' ); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="property-layout-full-icon">
	<header class="entry-header no-margin">
		<?php echo Realia_Template_Loader::load('single/content-header'); ?>
	</header>
	<div class="container">
		<header class="entry-header">
			<?php echo Realia_Template_Loader::load('single/tabs-gallery-map-virtual_tour'); ?>
		</header>
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
</div>