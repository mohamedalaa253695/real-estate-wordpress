<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$sidebar_configs = homesweet_get_property_layout_configs();

?>

<!-- end -->
<section id="main-container" class="inner">
    <div class="property-full-map-wrapper">
        <div id="properties-map" class="property-full-map" data-zoom="<?php echo esc_attr(homesweet_get_config('map_zoom', 15)); ?>"
        <?php echo (homesweet_get_config('map_custom_style') ? 'data-style="'.esc_attr(homesweet_get_config('map_custom_style')).'"' : ''); ?>></div>

        <?php if ( homesweet_get_config('property_archive_default_header_filter', true) && is_active_sidebar( 'properties-default-top-sidebar' ) ): ?>
            <div class="properties-default-top-sidebar-wrapper">
                <div class="container">
                    <?php dynamic_sidebar( 'properties-default-top-sidebar' ); ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
    <div class="<?php echo apply_filters('homesweet_property_content_class', 'container');?>">
        
        <?php get_template_part( 'templates/archive-layout/parts/header-middle' ); ?>

        <div class="row clearfix">
            <?php
                $class = '';
                if ( isset($sidebar_configs['left']) ) {
                    $class = 'pull-right';
                }
            ?>
            
            <div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class'].' '.$class); ?>">
                <main id="main" class="site-main content apus-properties-main" role="main">
                    <div class="apus-properties-page-wrapper">
                        <?php get_template_part( 'templates/archive-layout/parts/properties' ); ?>
                    </div>
                    <?php if ( have_posts() ) : ?>
                        <div class="apus-pagination-wrapper">
                            <?php get_template_part( 'templates/archive-layout/parts/pagination' ); ?>
                        </div>
                    <?php endif; ?>
                </main><!-- .site-main -->
            </div>

            <?php if ( isset($sidebar_configs['left']) ) : ?>
                <div class="<?php echo esc_attr($sidebar_configs['left']['class']) ;?>">
                    <aside class="sidebar sidebar-left" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
                        <?php if ( is_active_sidebar( $sidebar_configs['left']['sidebar'] ) ): ?>
                            <?php dynamic_sidebar( $sidebar_configs['left']['sidebar'] ); ?>
                        <?php endif; ?>
                    </aside>
                </div>
            <?php endif; ?>

            <?php if ( isset($sidebar_configs['right']) ) : ?>
                <div class="<?php echo esc_attr($sidebar_configs['right']['class']) ;?>">
                    <aside class="sidebar sidebar-right" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
                        <?php if ( is_active_sidebar( $sidebar_configs['right']['sidebar'] ) ): ?>
                            <?php dynamic_sidebar( $sidebar_configs['right']['sidebar'] ); ?>
                        <?php endif; ?>
                    </aside>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section><!-- .content-area -->