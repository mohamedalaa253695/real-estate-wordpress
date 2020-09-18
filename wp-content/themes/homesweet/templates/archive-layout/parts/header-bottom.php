<div class="main-content-header-bottom clearfix">

    <div class="actions-link pull-left">
        <?php
            $current_contract = isset($_GET['filter-contract']) ? $_GET['filter-contract'] : '';
            $current_url = homesweet_property_page_link();
            $url = remove_query_arg( 'filter-contract', $current_url );
            $url_rent = add_query_arg( 'filter-contract', 'RENT', remove_query_arg( 'filter-contract', $current_url ) );
            $url_sale = add_query_arg( 'filter-contract', 'SALE', remove_query_arg( 'filter-contract', $current_url ) );
        ?>
        <a <?php echo trim($current_contract == '' ? 'class="active"' : ''); ?> href="<?php echo esc_url($url); ?>" title="<?php echo esc_html__('All', 'homesweet'); ?>"><?php echo esc_html__('All', 'homesweet'); ?></a>
        <a <?php echo trim($current_contract == 'RENT' ? 'class="active"' : ''); ?> href="<?php echo esc_url($url_rent); ?>" title="<?php echo esc_html__('For Rent', 'homesweet'); ?>"><?php echo esc_html__('For Rent', 'homesweet'); ?></a>
        <a <?php echo trim($current_contract == 'SALE' ? 'class="active"' : ''); ?> href="<?php echo esc_url($url_sale); ?>" title="<?php echo esc_html__('For Sale', 'homesweet'); ?>"><?php echo esc_html__('For Sale', 'homesweet'); ?></a>
    </div>
    <?php
    $layout = homesweet_get_config('property_archive_layout_version', 'default');
    if (empty($layout)) {
        $layout = 'default';
    }
    if ( homesweet_get_config('property_archive_default_header_breadcrumb', false) && $layout == 'default' ): ?>

    <?php
        $display_mod = homesweet_realia_get_display_mode();
    ?>
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
    <?php endif; ?>
    <div class="properties-sort-wrapper pull-right">
        <?php echo Realia_Template_Loader::load('properties/sort'); ?>
    </div>
</div>