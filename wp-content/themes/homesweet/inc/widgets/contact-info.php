<?php

class Homesweet_Widget_Contact_Info extends Apus_Widget {
    public function __construct() {
        parent::__construct(
            'apus_contact_info',
            esc_html__('Apus Contact Info Widget', 'homesweet'),
            array( 'description' => esc_html__( 'Show Contact Info', 'homesweet' ), )
        );
        $this->widgetName = 'contact_info';
        add_action('admin_enqueue_scripts', array($this, 'scripts'));
    }
    
    public function scripts() {
        wp_enqueue_script( 'apus-upload-image', APUS_FRAMEWORK_URL . 'assets/upload.js', array( 'jquery', 'wp-pointer' ), APUS_FRAMEWORK_VERSION, true );
    }

    public function getTemplate() {
        $this->template = 'contact_info.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        $defaults = array(
            'address_image' => '',
            'address_content' => '',
            'phone_image' => '',
            'phone_content' => '',
        );
        $instance = wp_parse_args( (array) $instance, $defaults );
        // Widget admin form
        ?>
        <div class="phone-wrapper">
            <h3><?php echo esc_attr('Phone Contact Info'); ?></h3>
            <label for="<?php echo esc_attr($this->get_field_id( 'phone_image' )); ?>"><?php esc_html_e( 'Image Icon:', 'homesweet' ); ?></label>
            <div class="screenshot">
                <?php if ( $instance['phone_image'] ) { ?>
                    <img src="<?php echo esc_url($instance['phone_image']); ?>" alt=""/>
                <?php } ?>
            </div>
            <input class="widefat upload_image" id="<?php echo esc_attr($this->get_field_id( 'phone_image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'phone_image' )); ?>" type="hidden" value="<?php echo esc_attr($instance['phone_image']); ?>" />
            <div class="upload_image_action">
                <input type="button" class="button add-image" value="Add">
                <input type="button" class="button remove-image" value="Remove">
            </div>
            <!-- social -->
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'phone_content' )); ?>"><strong><?php esc_html_e('Phone Content:', 'homesweet');?></strong></label>
                <textarea id="<?php echo esc_attr($this->get_field_id( 'phone_content' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'phone_content' )); ?>" class="widefat"><?php echo esc_attr( $instance['phone_content'] ) ; ?></textarea>
            </p>
        </div>

        <div class="address-wrapper">
            <h3><?php echo esc_attr('Address Contact Info'); ?></h3>
            <label for="<?php echo esc_attr($this->get_field_id( 'address_image' )); ?>"><?php esc_html_e( 'Image Icon:', 'homesweet' ); ?></label>
            <div class="screenshot">
                <?php if ( $instance['address_image'] ) { ?>
                    <img src="<?php echo esc_url($instance['address_image']); ?>" alt=""/>
                <?php } ?>
            </div>
            <input class="widefat upload_image" id="<?php echo esc_attr($this->get_field_id( 'address_image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'address_image' )); ?>" type="hidden" value="<?php echo esc_attr($instance['address_image']); ?>" />
            <div class="upload_image_action">
                <input type="button" class="button add-image" value="Add">
                <input type="button" class="button remove-image" value="Remove">
            </div>
            <!-- social -->
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'address_content' )); ?>"><strong><?php esc_html_e('Address Content:', 'homesweet');?></strong></label>
                <textarea id="<?php echo esc_attr($this->get_field_id( 'address_content' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'address_content' )); ?>" class="widefat"><?php echo esc_attr( $instance['address_content'] ) ; ?></textarea>
            </p>
        </div>

<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['phone_image'] = ( ! empty( $new_instance['phone_image'] ) ) ? $new_instance['phone_image'] : '';
        $instance['phone_content'] = ( ! empty( $new_instance['phone_content'] ) ) ? $new_instance['phone_content'] : '';

        $instance['address_image'] = ( ! empty( $new_instance['address_image'] ) ) ? $new_instance['address_image'] : '';
        $instance['address_content'] = ( ! empty( $new_instance['address_content'] ) ) ? $new_instance['address_content'] : '';

        return $instance;
    }
}

register_widget( 'Homesweet_Widget_Contact_Info' );