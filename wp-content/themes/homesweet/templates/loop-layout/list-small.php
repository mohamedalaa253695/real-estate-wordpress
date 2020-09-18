<div class="properties-list-small">
    <?php  while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <div class="item">
            <?php echo Realia_Template_Loader::load( 'properties/box-list-small' ); ?>
        </div>
    <?php endwhile; ?>
</div>
<?php wp_reset_postdata(); ?>