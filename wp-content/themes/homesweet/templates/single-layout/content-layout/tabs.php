<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout_type = isset($layout_type) ? $layout_type : 'layout1';
$contents = homesweet_get_content_sort( $layout_type );
?>
<div class="tabs-content-layout">
	<ul class="nav nav-tabs nav-tab-content">
		<?php
		if ( !empty($contents) ) {
			$i = 0;
			foreach ($contents as $key => $value) {
				?>
				<li class="<?php echo esc_attr($i == 0 ? 'active' : ''); ?>">
					<a href="#tab-content-<?php echo esc_attr($key); ?>" data-toggle="tab">
		                <?php echo esc_attr($value); ?>
		            </a>
		        </li>
				<?php
				$i++;
			}
		}
		?>
		
	</ul>
	<div class="tab-content tab-content-descrip">
		<?php
		if ( !empty($contents) ) {
			$i = 0;
			foreach ($contents as $key => $value) {
				?>
				<div id="tab-content-<?php echo esc_attr($key); ?>" class="tab-pane <?php echo esc_attr($i == 0 ? 'active' : ''); ?>">
					<!-- Description -->
					<?php echo Realia_Template_Loader::load('single/'.$key); ?>
				</div>
				<?php
				$i++;
			}
		}
		?>
	</div>
</div>