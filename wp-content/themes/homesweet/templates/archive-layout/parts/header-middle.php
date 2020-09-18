<?php
$layout = homesweet_get_config('property_archive_layout_version', 'default');
if (empty($layout)) {
    $layout = 'default';
}
if ( !homesweet_get_config('property_archive_default_header_breadcrumb', false) || $layout != 'default' ): ?>
    <div class="main-content-header-middle clearfix">
        <div class="pull-left">
            <?php homesweet_property_render_breadcrumbs(); ?>
        </div>
        <div class="pull-right">
            <?php
                $display_mod = homesweet_realia_get_display_mode();
            ?>
            <div class="mod-property pull-right">
                
                <div class="property-display-mod">
                    <ul class="list-inline list-change">
                        <li class="<?php echo ($display_mod == 'grid' ? 'active' : ''); ?>">
                            <a href="#tab-properties-grid" data-toggle="tab" data-type="grid">
                                <i class="fa fa-th" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="<?php echo ($display_mod == 'list' ? 'active' : ''); ?>">
                            <a href="#tab-properties-list" data-toggle="tab" data-type="list">
                                <i class="fa fa-list-ul" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>