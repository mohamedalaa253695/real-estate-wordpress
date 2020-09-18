<?php
	$columns = homesweet_get_config('blog_columns', 1);
	$bcol = floor( 12 / $columns );
?>
<div class="layout-blog style-grid">
    <div class="row">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="col-xs-12 col-sm-<?php echo esc_attr($bcol); ?> col-xs-12 <?php echo ($count%$columns == 1)?' col-md-clear col-sm-clear':''; ?>">
				<?php get_template_part( 'post-formats/loop/grid-v2/_item' ); ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>