<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $_REQUEST['load_type'] ) && homesweet_is_ajax_request() ) {
	
	if ( 'properties' !== $_REQUEST['load_type'] ) {
        get_template_part( 'archive-property-ajax-full' );
	} else {
        get_template_part( 'archive-property-ajax-properties' );
	}

} else {
	get_header();
		
	$layout = homesweet_get_config('property_archive_layout_version', 'default');
	if (empty($layout)) {
		$layout = 'default';
	}
	?>
	<div class="properties-archive-main-container">
		<?php echo Realia_Template_Loader::load('archive-layout/'.$layout); ?>
	</div>
	<?php
	get_footer();
}
?>
