<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$marker_icon = homesweet_get_config('map_marker_icon');
?>

<div class="marker marker-<?php the_ID(); ?>" data-id="marker-<?php the_ID(); ?>">
	<div class="marker-inner">
		<img src="<?php echo esc_url(isset($marker_icon['url']) ? esc_attr($marker_icon['url']) : ''); ?>" alt="">
	</div>
</div>
