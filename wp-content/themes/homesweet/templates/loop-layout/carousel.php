<?php

$columns = isset($columns) ? $columns : 3;
$nav_style = !empty($nav_style) ? 'nav-'.$nav_style : '';
$item_style = !isset($item_style) || empty($item_style) ? '' : '-'.$item_style;
$position_nav = ($nav_style == 'nav-style2') ? 'owl-carousel-nav-top' : '';
?>
<div class="owl-carousel <?php echo esc_attr($nav_style); ?> item-style<?php echo esc_attr($item_style.' '.$position_nav); ?>"
	data-items="<?php echo esc_attr($columns); ?>" data-carousel="owl" data-smallmedium="<?php echo esc_attr($columns > 1 ? 2 : 1); ?>" data-extrasmall="1" 
	data-pagination="<?php echo esc_attr(!empty($show_pagination) && $show_pagination ? 'true' : 'false'); ?>" data-nav="true"
	<?php echo ($loop->post_count > $columns ? 'data-loop="true"' : ''); ?>>

    <?php while ( $loop->have_posts() ): $loop->the_post(); ?>
        <?php echo Realia_Template_Loader::load( 'properties/box'.$item_style ); ?>
    <?php endwhile; ?>
</div> 
<?php wp_reset_postdata(); ?>