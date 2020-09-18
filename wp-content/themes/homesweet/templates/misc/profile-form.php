<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( method_exists( 'Realia_Utilities', 'protect' ) ) { Realia_Utilities::protect(); } ?>

<?php $user = wp_get_current_user(); ?>
<?php
	wp_enqueue_media();
	wp_enqueue_script( 'homesweet-upload', get_template_directory_uri() . '/js/upload.js', array( 'jquery' ), '20150330', true );
	$data = get_userdata( $user->ID );
	$avatar = get_the_author_meta( 'apus_avatar', $user->ID );
	$avatar_url = wp_get_attachment_image_src($avatar, 'full');
?>

<form method="post" action="<?php the_permalink(); ?>" class="change-profile-form">
	<div class="form-group">
		<label for="change-profile-form-phone"><?php echo esc_html__( 'Avatar', 'homesweet' ); ?></label>
		<div class="screenshot avatar-screenshot">
            <?php if ( !empty($avatar_url[0]) ) { ?>
                <img src="<?php echo esc_url($avatar_url[0]); ?>" alt="" style="max-width:100%;"/>
            <?php } ?>
        </div>
        <input class="widefat upload_image" name="user_avatar" type="hidden" value="<?php echo esc_attr($avatar); ?>" />
        <div class="upload_image_action">
            <input type="button" class="button btn btn-theme-second btn-font-normal add-image" value="<?php echo esc_html__( 'Add Avatar', 'homesweet' ); ?>">
            <input type="button" class="button btn btn-theme btn-font-normal remove-image" value="<?php echo esc_html__( 'Remove Avatar', 'homesweet' ); ?>">
        </div>
	</div><!-- /.form-group -->
	
	<div class="form-group">
		<label for="change-profile-form-nickname"><?php echo esc_html__( 'Nickname', 'homesweet' ); ?></label>
		<input id="change-profile-form-nickname" type="text" name="nickname" class="form-control" value="<?php echo ! empty( $data->nickname ) ? esc_attr( $data->nickname ) : ''; ?>" required="required">
	</div><!-- /.form-group -->

	<div class="form-group">
		<label for="change-profile-form-email"><?php echo esc_html__( 'E-mail', 'homesweet' ); ?></label>
		<input id="change-profile-form-email" type="email" name="email" class="form-control" value="<?php echo ! empty( $data->user_email ) ? esc_attr( $data->user_email ) : ''; ?>"  required="required">
	</div><!-- /.form-group -->

	<div class="form-group">
		<label for="change-profile-form-first-name"><?php echo esc_html__( 'First name', 'homesweet' ); ?></label>
		<input id="change-profile-form-first-name" type="text" name="first_name" class="form-control" value="<?php echo ! empty( $data->first_name ) ? esc_attr( $data->first_name ) : ''; ?>">
	</div><!-- /.form-group -->

	<div class="form-group">
		<label for="change-profile-form-last-name"><?php echo esc_html__( 'Last name', 'homesweet' ); ?></label>
		<input id="change-profile-form-last-name" type="text" name="last_name" class="form-control" value="<?php echo ! empty( $data->last_name ) ? esc_attr( $data->last_name ) : ''; ?>">
	</div><!-- /.form-group -->

	<div class="form-group">
		<label for="change-profile-form-phone"><?php echo esc_html__( 'Phone', 'homesweet' ); ?></label>
		<input id="change-profile-form-phone" type="text" name="phone" class="form-control" value="<?php echo ! empty( $data->phone ) ? esc_attr( $data->phone ) : ''; ?>">
	</div><!-- /.form-group -->

	<button type="submit" name="change_profile_form" class="button btn btn-purple btn-font-normal"><?php echo esc_html__( 'Change Profile', 'homesweet' ); ?></button>
</form>
