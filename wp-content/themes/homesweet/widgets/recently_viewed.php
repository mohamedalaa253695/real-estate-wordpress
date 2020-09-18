<?php 

extract( $args );
extract( $instance );

$title = apply_filters('widget_title', $instance['title']);
if ( $title ) {
    echo ($before_title)  . trim( $title ) . $after_title;
}

$viewed_properties = ! empty( $_COOKIE['homesweet_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['homesweet_recently_viewed'] ) : array();
$viewed_properties = array_reverse( array_filter( array_map( 'absint', $viewed_properties ) ) );

if ( empty( $viewed_properties ) ) {
    return;
}

$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 3;

$query_args = array(
    'posts_per_page' => $number,
    'no_found_rows'  => 1,
    'post_status'    => 'publish',
    'post_type'      => 'property',
    'post__in'       => $viewed_properties,
    'orderby'        => 'post__in',
);

$loop = new WP_Query( $query_args );
if ( $loop->have_posts() ) {
    ?>
    <div class="properties-list properties-list-small">
        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <div class="item">
                <?php echo Realia_Template_Loader::load( 'properties/small' ); ?>
            </div>
        <?php endwhile; ?>
    </div>
    <?php wp_reset_postdata(); ?>
    <?php
}