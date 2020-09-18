<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>
<section id="main-container" class="inner half-map-content">
    <div class="row no-margin">
        <div class="col-sm-12 col-lg-6 no-padding">
            <div id="properties-map" class="property-half-map" data-zoom="<?php echo esc_attr(homesweet_get_config('map_zoom', 15)); ?>"
                 <?php echo (homesweet_get_config('map_custom_style') ? 'data-style="'.esc_attr(homesweet_get_config('map_custom_style')).'"' : ''); ?>></div>
        </div>
        <div id="main-content" class="col-sm-12 col-lg-6 no-padding">
            <main id="main" class="site-main content apus-properties-main" role="main">

                <?php if ( is_active_sidebar( 'halfmap-sidebar' ) ) : ?>
                    <div class="widget-area">
                        <?php dynamic_sidebar( 'halfmap-sidebar' ); ?>
                    </div><!-- .widget-area -->
                <?php endif; ?>
                <div class="content-half-map">
                    <?php get_template_part( 'templates/archive-layout/parts/header-middle' ); ?>
                    
                    <div class="apus-properties-page-wrapper">
                        <?php get_template_part( 'templates/archive-layout/parts/properties' ); ?>
                    </div>

                    <?php if ( have_posts() ) : ?>
                        <div class="apus-pagination-wrapper">
                            <?php get_template_part( 'templates/archive-layout/parts/pagination' ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </main><!-- .site-main -->
        </div>
    </div>
</section><!-- .content-area -->