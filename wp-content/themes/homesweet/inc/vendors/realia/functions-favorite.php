<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
 
class Homesweet_Realia_Favorite {
    
    public static function init() {
        add_action( 'wp_ajax_homesweet_add_favorite', array(__CLASS__, 'add_favorite') );
        add_action( 'wp_ajax_nopriv_homesweet_add_favorite', array(__CLASS__, 'add_favorite') );
        add_action( 'wp_ajax_homesweet_remove_favorite', array(__CLASS__, 'remove_favorite') );
        add_action( 'wp_ajax_nopriv_homesweet_remove_favorite', array(__CLASS__, 'remove_favorite') );

        add_action( 'wp_footer', array(__CLASS__, 'favorite_login_require') );
    }

    public static function add_favorite() {
        if ( isset($_GET['post_id']) && $_GET['post_id'] ) {
            self::save_favorite($_GET['post_id']);
            $result['msg'] = esc_html__( 'View Your Favorite', 'homesweet' );
            $result['status'] = 'success';
        } else {
            $result['msg'] = esc_html__( 'Add Favorite Error.', 'homesweet' );
            $result['status'] = 'error';
        }
        echo json_encode($result);
        die();
    }

    public static function remove_favorite() {
        if ( isset($_GET['post_id']) && $_GET['post_id'] ) {
            $user_id = get_current_user_id();
            $data = get_user_meta($user_id, '_realia_favorite', true);
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    if ( $_GET['post_id'] == $value ) {
                        unset($data[$key]);
                    }
                }
            }
            update_user_meta( $user_id, '_realia_favorite', $data );
            
            $result['msg'] = esc_html__( 'Remove a listing to favorite successful', 'homesweet' );
            $result['status'] = 1;
        } else {
            $result['msg'] = esc_html__( 'Remove a listing to favorite error', 'homesweet' );
            $result['status'] = 0;
        }
        echo json_encode($result);
        die();
    }

    public static function get_favorite() {
        $user_id = get_current_user_id();
        $data = get_user_meta($user_id, '_realia_favorite', true);
        return $data;
    }

    public static function save_favorite($post_id) {
        $user_id = get_current_user_id();
        $data = get_user_meta($user_id, '_realia_favorite', true);
        if ( !in_array($post_id, $data) ) {
            $data[] = $post_id;
            update_user_meta( $user_id, '_realia_favorite', $data );
        }
    }

    public static function check_property_added($post_id) {
        $data = self::get_favorite();
        if ( !is_array($data) || !in_array($post_id, $data) ) {
            return false;
        }
        return true;
    }

    public static function btn_display( $post_id = null ) {
        if ( !homesweet_get_config('enable_property_favorite') ) {
            return '';
        }
        if ( empty($post_id) ) {
            $post_id = get_the_ID();
        }
        ?>
        <div class="property-favorite">
            <?php if ( !is_user_logged_in() ) { ?>
                <a href="#apus-favorite-not-login" class="apus-favorite-not-login" data-id="<?php echo esc_attr($post_id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo esc_html__( 'favorite', 'homesweet' ); ?>" >
                    <i class="icon-ap_favorite-outlinezz"></i><span class="hidden"><?php echo esc_html__('Add to favorites', 'homesweet') ?></span>
                </a>
            <?php } else {
                    $link = '';
                    if ( homesweet_get_config('property_favorite_page_slug') ) {
                        $args = array(
                            'name'        => homesweet_get_config('property_favorite_page_slug'),
                            'post_type'   => 'page',
                            'post_status' => 'publish',
                            'numberposts' => 1
                        );
                        $s_posts = get_posts($args);
                        if( $s_posts ) {
                            $link = get_permalink($s_posts[0]->ID);
                        }
                    }
                    $added = self::check_property_added($post_id);
                    if ($added) {
                        ?>
                        <a href="<?php echo esc_url($link); ?>" class="apus-favorite-added" data-toggle="tooltip" data-placement="top" title="<?php echo esc_html__( 'favorite', 'homesweet' ); ?>">
                            <i class=" icon-ap_favorite-outlinezz"></i>
                            <span class="hidden"><?php echo esc_html__('Favorites','homesweet') ?></span>
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href="<?php echo esc_url($link); ?>" class="apus-favorite-add" data-id="<?php echo esc_attr($post_id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo esc_html__( 'favorite', 'homesweet' ); ?>">
                            <i class=" icon-ap_favorite-outlinezz"></i>
                            <span class="hidden"><?php echo esc_html__('Add to favorites','homesweet') ?></span>
                        </a>
                        <?php
                    }
                }
            ?>
        </div>

        <?php
    }

    public static function favorite_login_require() {
        if ( !homesweet_get_config('enable_property_favorite') ) {
            return '';
        }
        if ( !is_user_logged_in() ) { ?>
            <div class="hidden apus-favorite-login-info">
                <?php esc_html_e( 'Please login to add this property.', 'homesweet' ); ?>
                <a href="<?php echo esc_url( get_permalink( get_theme_mod('realia_general_login_required_page', null) ) ); ?>">
                    <?php esc_html_e( 'Click here to login', 'homesweet' ); ?>
                </a>
            </div>
        <?php }
    }
}

Homesweet_Realia_Favorite::init();
