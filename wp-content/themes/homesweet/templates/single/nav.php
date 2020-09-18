<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contents = homesweet_get_content_sort();
?>
<div class="panel-affix-wrapper">
	<div class="tabs-content-layout panel-affix">
		<div class="container">
			<div class="nav-property-wrapper">
				<ul class="nav nav-tabs nav-property">
					<?php
					if ( !empty($contents) ) {
						foreach ($contents as $key => $value) {
							?>
							<li>
								<a href="#property-section-<?php echo esc_attr($key); ?>">
					                <?php echo esc_attr($value); ?>
					            </a>
					        </li>
							<?php
						}
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>