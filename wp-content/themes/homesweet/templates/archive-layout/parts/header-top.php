<div class="main-content-header-top <?php echo ( homesweet_get_config('property_archive_default_header_breadcrumb', false) ) ? 'has-bread' : ''; ?>">
    <div class="container">
        <?php if ( homesweet_get_config('property_archive_default_header_filter', true) && is_active_sidebar( 'properties-default-top-sidebar' ) ): ?>
            <div class="properties-default-top-sidebar-wrapper">
                <?php dynamic_sidebar( 'properties-default-top-sidebar' ); ?>
            </div>
        <?php endif; ?>
        <?php if ( homesweet_get_config('property_archive_default_header_breadcrumb', false) ): ?>
            <?php homesweet_property_render_breadcrumbs(); ?>
        <?php endif; ?>
    </div>
</div>