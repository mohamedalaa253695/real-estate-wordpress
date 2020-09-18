<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) {
    return;
}
$pagination_type = homesweet_get_config('property_pagination', 'default');
if ( $pagination_type == 'loadmore' || $pagination_type == 'infinite' ) {
?>
    <div class="ajax-pagination <?php echo trim($pagination_type == 'loadmore' ? 'loadmore-action' : 'infinite-action'); ?>">
        <div class="apus-pagination-next-link hidden"><?php next_posts_link( '&nbsp;' ); ?></div>
        <a href="#" class="apus-loadmore-btn btn btn-theme"><?php esc_html_e( 'Load More', 'homesweet' ); ?></a>
        <span class="apus-allproperties"><?php esc_html_e( 'All properties loaded.', 'homesweet' ); ?></span>
    </div>
<?php
} else {
?>
    <div class="apus-pagination">
        <?php the_posts_pagination( array(
            'prev_text'          => esc_html__( 'Previous', 'homesweet' ),
            'next_text'          => esc_html__( 'Next', 'homesweet' ),
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'homesweet' ) . ' </span>',
        ) ); ?>
    </div>
<?php }