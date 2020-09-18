<?php

class Homesweet_Widget_Properties extends Apus_Widget {
    public function __construct() {
        parent::__construct(
            'apus_properties',
            esc_html__('Apus Properties Widget', 'homesweet'),
            array( 'description' => esc_html__( 'Show Properties', 'homesweet' ), )
        );
        $this->widgetName = 'properties';
    }
    
    public function getTemplate() {
        $this->template = 'properties.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
            'number' => '3',
            'orderby' => 'latest',
        );
        $instance = wp_parse_args( (array) $instance, $defaults );
        // Widget admin form
        $orderbys = array(
            esc_html__( 'Latest', 'homesweet' ) => 'latest',
            esc_html__( 'Featured', 'homesweet' ) => 'featured',
            esc_html__( 'Sticky', 'homesweet' ) => 'sticky',
            esc_html__( 'Reduced', 'homesweet' ) => 'reduced',
        );
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><strong><?php esc_html_e('Title:', 'homesweet');?></strong></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><strong><?php esc_html_e('Number:', 'homesweet');?></strong></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_attr($instance['number']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>"><strong><?php esc_html_e('Get Properties By:', 'homesweet');?></strong></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'orderby' )); ?>">
                <?php foreach ($orderbys as $key => $value) { ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php echo ( $instance['orderby'] == $value ? 'selected="selected"' : ''); ?>><?php echo esc_html($key); ?></option>
                <?php } ?>
            </select>
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? $new_instance['title'] : '';
        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? $new_instance['number'] : '';
        $instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? $new_instance['orderby'] : '';

        return $instance;
    }
}

register_widget( 'Homesweet_Widget_Properties' );