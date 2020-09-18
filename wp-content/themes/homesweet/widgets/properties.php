<?php 

extract( $args );
extract( $instance );

$title = apply_filters('widget_title', $instance['title']);
if ( $title ) {
    echo ($before_title)  . trim( $title ) . $after_title;
}


$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 3;

$args = array(
	'orderby' => $instance['orderby'],
	'number' => $number,
);
$loop = homesweet_get_properties( $args );
if ( $loop->have_posts() ) {
    ?>
    <div class="widget-content">
        <?php echo Realia_Template_Loader::load( 'loop-layout/list-small', array( 'loop' => $loop, 'columns' => 1, 'item_style' => 'style1' ) ); ?>
    </div>
    <?php
}