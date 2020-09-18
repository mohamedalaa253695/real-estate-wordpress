<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$layout_type = isset($layout_type) ? $layout_type : 'layout1';
$contents = homesweet_get_content_sort( $layout_type );

if ( !empty($contents) ) {
	foreach ($contents as $key => $value) {
		echo Realia_Template_Loader::load( 'single/'.$key );
	}
}

?>
