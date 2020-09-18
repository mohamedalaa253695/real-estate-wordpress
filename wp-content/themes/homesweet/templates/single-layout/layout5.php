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
		<div class="container">
			<?php echo Realia_Template_Loader::load('single/tabs-gallery-map-virtual_tour'); ?>
		</div>
	</header>
	<div class="container">
		<div class="entry-content">
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

		<!-- SUBPROPERTIES -->
		<?php echo Realia_Template_Loader::load('single/subproperties'); ?>
		
	    <!-- SIMILAR PROPERTIES -->
	    <?php echo Realia_Template_Loader::load('single/similar'); ?>
	</div>
</div>