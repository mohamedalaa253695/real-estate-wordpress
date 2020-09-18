<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="apus-properties-page-wrapper">
	<?php echo Realia_Template_Loader::load('archive-layout/parts/properties' ); ?>
</div>

<div class="apus-pagination-next-link"><?php next_posts_link( '&nbsp;' ); ?></div>