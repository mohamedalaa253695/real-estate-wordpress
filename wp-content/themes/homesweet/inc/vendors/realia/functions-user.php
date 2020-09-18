<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', 'homesweet_process_change_profile_form', 9999 );
function homesweet_process_change_profile_form() {
    if ( ! isset( $_POST['change_profile_form'] ) ) {
        return;
    }
    $user = wp_get_current_user();

    $user_avatar = isset($_POST['user_avatar']) ?  sanitize_user( $_POST['user_avatar'] ) : '';
    update_user_meta( $user->ID, 'apus_avatar', $user_avatar );
    
}

function homesweet_user_profile_fields( $user ) {
    wp_enqueue_media();
    wp_enqueue_script( 'homesweet-upload', get_template_directory_uri() . '/js/upload.js', array( 'jquery' ), '20150330', true );

    $avatar = get_the_author_meta( 'apus_avatar', $user->ID );
    $avatar_url = wp_get_attachment_image_src($avatar, 'full');

    ?>
    <h3><?php esc_html_e( 'User Profile', 'homesweet' ); ?></h3>

    <table class="form-table">
        <tbody>
            <tr>
                <th>
                    <label for="lecturer_job"><?php esc_html_e( 'Avatar', 'homesweet' ); ?></label>
                </th>
                <td>
                    <div class="screenshot avatar-screenshot">
                        <?php if ( !empty($avatar_url[0]) ) { ?>
                            <img src="<?php echo esc_url($avatar_url[0]); ?>" alt="" style="max-width:100%;"/>
                        <?php } ?>
                    </div>
                    <input class="widefat upload_image" name="user_avatar" type="hidden" value="<?php echo esc_attr($avatar); ?>" />
                    <div class="upload_image_action">
                        <input type="button" class="button btn btn-theme add-image" value="<?php echo esc_html__( 'Add Avatar', 'homesweet' ); ?>">
                        <input type="button" class="button btn btn-theme-second remove-image" value="<?php echo esc_html__( 'Remove Avatar', 'homesweet' ); ?>">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}
add_action( 'show_user_profile', 'homesweet_user_profile_fields' );
add_action( 'edit_user_profile', 'homesweet_user_profile_fields' );

function homesweet_save_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }

    $user_avatar = isset($_POST['user_avatar']) ?  sanitize_user( $_POST['user_avatar'] ) : '';
    update_user_meta( $user_id, 'apus_avatar', $user_avatar );
}

add_action( 'personal_options_update', 'homesweet_save_user_profile_fields' );
add_action( 'edit_user_profile_update', 'homesweet_save_user_profile_fields' );


add_filter('get_avatar', 'homesweet_get_avatar_filter', 10, 100);

function homesweet_get_avatar_filter($avatar, $id_or_email="", $size="", $default="", $alt="") {
    if (is_object($id_or_email)) {
        
        $avatar_id = get_the_author_meta( 'apus_avatar', $id_or_email->ID );
        if ( !empty($avatar_id) ) {
            $avatar_url = wp_get_attachment_image_src($avatar_id, 'full');
            if ( !empty($avatar_url[0]) ) {
                $avatar = '<img src="'.$avatar_url[0].'" width="'.$size.'" height="'.$size.'" alt="'.$alt.'" class="avatar avatar-'.$size.' wp-user-avatar wp-user-avatar-'.$size.' photo avatar-default" />';
            }
        }
    } else {
        $avatar_id = get_the_author_meta( 'apus_avatar', $id_or_email );
        if ( !empty($avatar_id) ) {
            $avatar_url = wp_get_attachment_image_src($avatar_id, 'full');
            if ( !empty($avatar_url[0]) ) {
                $avatar = '<img src="'.$avatar_url[0].'" width="'.$size.'" height="'.$size.'" alt="'.$alt.'" class="avatar avatar-'.$size.' wp-user-avatar wp-user-avatar-'.$size.' photo avatar-default" />';
            }
        }
    }
    return $avatar;
}