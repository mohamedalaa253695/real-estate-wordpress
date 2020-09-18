<?php

class Homesweet_User_Profile extends Apus_Widget {
    public function __construct() {
        parent::__construct(
            'apus_user_profile',
            esc_html__('Apus User Profile Widget', 'homesweet'),
            array( 'description' => esc_html__( 'Show User Profile', 'homesweet' ), )
        );
        $this->widgetName = 'custom_menu';
    }

    public function getTemplate() {
        $this->template = 'user-profile.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        $defaults = array(
            'enable_short_info' => '',
            'nav_menu' => ''
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form

        $custom_menus = array();
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
        if ( is_array( $menus ) && ! empty( $menus ) ) {
            foreach ( $menus as $single_menu ) {
                if ( is_object( $single_menu ) && isset( $single_menu->name, $single_menu->slug ) ) {
                    $custom_menus[ $single_menu->name ] = $single_menu->slug;
                }
            }
        }
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Enable Short Profile Info:', 'homesweet' ); ?></label>
            <input type="checkbox" value="labels" <?php echo ( $instance['enable_short_info'] ? 'checked="checked"' : '' ); ?>
                        id="<?php echo esc_attr( $this->get_field_id( 'enable_short_info' ) ); ?>"
                        name="<?php echo esc_attr( $this->get_field_name( 'enable_short_info' ) ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('nav_menu')); ?>">
                <?php echo esc_html__('Menu:', 'homesweet' ); ?>
            </label>
            <br>
            <select id="<?php echo esc_attr($this->get_field_id('nav_menu')); ?>" name="<?php echo esc_attr($this->get_field_name('nav_menu')); ?>">
                <?php foreach ( $custom_menus as $key => $value ) { ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected($instance['nav_menu'],$value); ?> ><?php echo esc_html( $key ); ?></option>
                <?php } ?>
            </select>
        </p>
        
<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['enable_short_info'] = ( ! empty( $new_instance['enable_short_info'] ) ) ? strip_tags( $new_instance['enable_short_info'] ) : '';
        $instance['nav_menu'] = ( ! empty( $new_instance['nav_menu'] ) ) ? strip_tags( $new_instance['nav_menu'] ) : '';
        return $instance;

    }
}

register_widget( 'Homesweet_User_Profile' );