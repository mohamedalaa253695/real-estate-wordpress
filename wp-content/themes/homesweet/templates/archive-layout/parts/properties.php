<?php
    global $wp_query;
    if ( have_posts() ) : ?>

    <?php echo Realia_Template_Loader::load( 'archive-layout/parts/header-bottom' ); ?>

    <?php
    /**
     * realia_before_property_archive
     */
    do_action( 'realia_before_property_archive' );

    $display_mod = homesweet_realia_get_display_mode();
    
    $columns = homesweet_get_config( 'property_columns', 3 );
    $bcol = 12/$columns;
    if ($columns == 5) {
        $bcol = 'cus-5';
    }
    $class = 'col-md-'.esc_attr($bcol).($columns > 1 ? ' col-sm-6' : '');

    ?>
    <div class="tab-content">
        <div id="tab-properties-grid" class="tab-pane <?php echo ($display_mod == 'grid' ? 'active' : ''); ?>">
            <div class="property-box-archive type-box">
                <div class="row">
                    <?php $count=0; while ( have_posts() ) : the_post(); ?>
                        <div class="<?php echo esc_attr($class); ?> col-property-box <?php echo ($count%$columns == 0) ? ' col-md-clear':''; ?> <?php echo ($columns > 1 && $count%2 == 0) ? ' col-sm-clear' : ''; ?>">
                            <?php echo Realia_Template_Loader::load( 'properties/box' ); ?>
                        </div>
                    <?php $count++; endwhile; ?>
                </div>
            </div>
        </div>
        <div id="tab-properties-list" class="tab-pane <?php echo ($display_mod == 'list' ? 'active' : ''); ?>">
            <div class="property-box-archive type-row">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php echo Realia_Template_Loader::load( 'properties/row' ); ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    
    <?php
    /**
     * realia_after_property_archive
     */
    do_action( 'realia_after_property_archive' );
    ?>

<?php else : ?>
    <?php get_template_part( 'content', 'none' ); ?>
<?php endif; ?>