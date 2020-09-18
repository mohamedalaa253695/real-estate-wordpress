<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="properties-sort-wrapper">
	<?php echo Realia_Template_Loader::load('properties/sort'); ?>
</div>

<div class="apus-properties-page-wrapper">
	<?php echo Realia_Template_Loader::load('archive-layout/parts/properties' ); ?>
</div>

<div class="apus-pagination-wrapper">
    <?php get_template_part( 'templates/archive-layout/parts/pagination' ); ?>
</div>