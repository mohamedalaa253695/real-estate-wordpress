<?php

class Homesweet_Widget_Recently_Viewed extends Apus_Widget {
    public function __construct() {
        parent::__construct(
            'apus_recently_viewed',
            esc_html__('Apus Recently Viewed Widget', 'homesweet'),
            array( 'description' => esc_html__( 'Show Recently Viewed', 'homesweet' ), )
        );
        $this->widgetName = 'recently_viewed';
    }
    
    public function getTemplate() {
        $this->template = 'recently_viewed.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
            'number' => '3',
        );
        $instance = wp_parse_args( (array) $instance, $defaults );
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><strong><?php esc_html_e('Title:', 'homesweet');?></strong></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><strong><?php esc_html_e('Number:', 'homesweet');?></strong></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_attr($instance['number']); ?>" />
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? $new_instance['title'] : '';
        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? $new_instance['number'] : '';

        return $instance;
    }
}

register_widget( 'Homesweet_Widget_Recently_Viewed' );