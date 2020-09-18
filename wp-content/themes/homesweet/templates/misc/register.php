<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bcol = '12';
if ( defined('HOMESWEET_FACEBOOK_CONNECT_ACTIVED') || defined('HOMESWEET_GOOGLE_CONNECT_ACTIVED') || defined('HOMESWEET_TWITTER_CONNECT_ACTIVED') ) {
	$bcol = '7';
}
?>

<?php if ( get_option( 'users_can_register' ) ) : ?>
<div class="row no-margin visibled-table">
	<div class="visibled-cell no-padding col-sm-<?php echo esc_attr($bcol); ?>">
		<form method="post" action="<?php the_permalink(); ?>" class="register-form">
			<div class="form-group">
				<input id="register-form-name-<?php echo esc_attr($_id); ?>" placeholder="<?php echo esc_html__( 'Username', 'homesweet' ); ?>" type="text" name="name" class="form-control" required="required">
			</div><!-- /.form-group -->

			<div class="form-group">
				<input id="register-form-email-<?php echo esc_attr($_id); ?>" placeholder="<?php echo esc_html__( 'E-mail', 'homesweet' ); ?>" type="email" name="email" class="form-control" required="required">
			</div><!-- /.form-group -->

			<div class="form-group">
				<input id="register-form-first-name-<?php echo esc_attr($_id); ?>" placeholder="<?php echo esc_html__( 'First name', 'homesweet' ); ?>" type="text" name="first_name" class="form-control">
			</div><!-- /.form-group -->

			<div class="form-group">
				<input id="register-form-last-name-<?php echo esc_attr($_id); ?>" placeholder="<?php echo esc_html__( 'Last name', 'homesweet' ); ?>" type="text" name="last_name" class="form-control">
			</div><!-- /.form-group -->

			<div class="form-group">
				<input id="register-form-phone-<?php echo esc_attr($_id); ?>" placeholder="<?php echo esc_html__( 'Phone', 'homesweet' ); ?>" type="text" name="phone" class="form-control">
			</div><!-- /.form-group -->

			<div class="form-group">
				<input id="register-form-password-<?php echo esc_attr($_id); ?>" placeholder="<?php echo esc_html__( 'Password', 'homesweet' ); ?>" type="password" name="password" class="form-control" required="required">
			</div><!-- /.form-group -->

			<div class="form-group">
				<input id="register-form-retype-<?php echo esc_attr($_id); ?>" placeholder="<?php echo esc_html__( 'Retype Password', 'homesweet' ); ?>" type="password" name="password_retype" class="form-control" required="required">
			</div><!-- /.form-group -->

			<?php $terms = get_theme_mod( 'realia_submission_terms' ); ?>

			<?php if ( ! empty( $terms ) ) : ?>
				<div class="checkbox terms-conditions-input">
					<input id="register-form-conditions-<?php echo esc_attr($_id); ?>" type="checkbox" name="agree_terms">

					<label for="register-form-conditions-<?php echo esc_attr($_id); ?>">
						<?php echo sprintf(__( 'I agree with <a href="%s">terms & conditions</a>', 'homesweet' ), get_permalink( $terms ) ); ?>
					</label>
				</div><!-- /.form-group -->
			<?php endif; ?>
			<div class="space-top-20">
				<button type="submit" class="button btn btn-block btn-blue btn-font-normal" name="register_form"><?php echo esc_html__( 'REGISTER', 'homesweet' ); ?></button>
			</div>
		</form>
	</div>
	<?php if ( defined('HOMESWEET_FACEBOOK_CONNECT_ACTIVED') || defined('HOMESWEET_GOOGLE_CONNECT_ACTIVED') || defined('HOMESWEET_TWITTER_CONNECT_ACTIVED') ) { ?>
	<div class="visibled-cell no-padding col-sm-5 left-social">
		<div class="social-connect">
			<div class="desc">
				<?php esc_html_e( 'You can login using  your facebook, twitter or google account', 'homesweet' ); ?>
			</div>
			<ul class="login-social">
			<?php if ( defined('HOMESWEET_FACEBOOK_CONNECT_ACTIVED') ) { ?>
				<li>
					<a class="btn btn-block btn-facebook" href="<?php echo wp_login_url(); ?>?loginFacebook=1" onclick="window.location = '<?php echo wp_login_url(); ?>?loginFacebook=1&redirect='+window.location.href; return false;">
						<i class="fa fa-facebook" aria-hidden="true"></i>
	 					<?php esc_html_e('Facebook Connect', 'homesweet'); ?>
					</a>
				</li>
			<?php } ?>
			<?php if ( defined('HOMESWEET_TWITTER_CONNECT_ACTIVED') ) { ?>
				<li>
					<a class="btn btn-block btn-twitter" href="<?php echo wp_login_url(); ?>?loginTwitter=1" onclick="window.location = '<?php echo wp_login_url(); ?>?loginTwitter=1&redirect='+window.location.href; return false;">
						<i class="fa fa-twitter" aria-hidden="true"></i>
						<?php esc_html_e('Twitter Connect', 'homesweet'); ?>
					</a>
				</li>
			<?php } ?>
			<?php if ( defined('HOMESWEET_GOOGLE_CONNECT_ACTIVED') ) { ?>
				<li>
					<a class="btn btn-block btn-google" href="<?php echo wp_login_url(); ?>?loginGoogle=1" onclick="window.location = '<?php echo wp_login_url(); ?>?loginGoogle=1&redirect='+window.location.href; return false;">
						<i class="fa fa-google" aria-hidden="true"></i>
						<?php esc_html_e('Google Connect', 'homesweet'); ?>
					</a>
				</li>
			<?php } ?>
			</ul>
		</div>
	</div>
	<?php } ?>
</div>
<?php else: ?>
	<div class="alert alert-warning">
		<?php echo esc_html__( 'Registrations are not allowed.', 'homesweet' ); ?>
	</div><!-- /.alert -->
<?php endif; ?>
