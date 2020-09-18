<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
$sidebar_configs = homesweet_get_agency_layout_configs();
?>
<?php if ( homesweet_get_config('property_archive_default_header_filter', true) && is_active_sidebar( 'properties-default-top-sidebar' ) ): ?>
<div class="main-content-header-top">
    <div class="container">
        <div class="properties-default-top-sidebar-wrapper">
            <?php dynamic_sidebar( 'properties-default-top-sidebar' ); ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php homesweet_render_breadcrumbs(); ?>
<section id="main-container" class="main-content <?php echo apply_filters('homesweet_agency_content_class', 'container');?> inner">
    <div class="row">
        <?php if ( isset($sidebar_configs['left']) ) : ?>
            <div class="<?php echo esc_attr($sidebar_configs['left']['class']) ;?>">
                <aside class="sidebar sidebar-left" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
                    <?php if ( is_active_sidebar( $sidebar_configs['left']['sidebar'] ) ): ?>
                        <?php dynamic_sidebar( $sidebar_configs['left']['sidebar'] ); ?>
                    <?php endif; ?>
                </aside>
            </div>
        <?php endif; ?>
        <div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
            <main id="main" class="site-main content" role="main">
                <?php if ( have_posts() ) : $count = 1; ?>
                    <div class="row">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <div class="col-md-3 col-sm-6 col-xs-12 <?php echo ($count%4 == 1)?'col-md-clear':'' ?>">
                                <?php echo Realia_Template_Loader::load( 'agencies/row' ); ?>
                            </div>
                        <?php $count++; endwhile; ?>
                    </div>
                    <?php the_posts_pagination( array(
                        'prev_text'          => esc_html__('Prev','homesweet'),
                        'next_text'          => esc_html__('Next','homesweet'),
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'homesweet' ) . ' </span>',
                    ) ); ?>
                <?php else : ?>
                    <?php get_template_part( 'content', 'none' ); ?>
                <?php endif; ?>
                <?php dynamic_sidebar( 'sidebar-content-bottom' ); ?>
            </main><!-- .site-main -->
        </div>

        <?php if ( isset($sidebar_configs['right']) ) : ?>
            <div class="<?php echo esc_attr($sidebar_configs['right']['class']) ;?>">
                <aside class="sidebar sidebar-right" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
                    <?php if ( is_active_sidebar( $sidebar_configs['right']['sidebar'] ) ): ?>
                        <?php dynamic_sidebar( $sidebar_configs['right']['sidebar'] ); ?>
                    <?php endif; ?>
                </aside>
            </div>
        <?php endif; ?>

    </div><!-- /.row -->
</section>
<?php get_footer(); ?>
