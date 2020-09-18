<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$_id = homesweet_random_key();
$bcol = '12';
if ( defined('HOMESWEET_FACEBOOK_CONNECT_ACTIVED') || defined('HOMESWEET_GOOGLE_CONNECT_ACTIVED') || defined('HOMESWEET_TWITTER_CONNECT_ACTIVED') ) {
	$bcol = '7';
}
?>
<div class="row no-margin visibled-table">
	<div class="visibled-cell no-padding col-sm-<?php echo esc_attr($bcol); ?>">
		<form method="post" action="<?php the_permalink(); ?>" class="login-form">
			<div class="form-group">
				<input id="login-form-username-<?php echo esc_attr($_id); ?>" placeholder="<?php echo esc_html__( 'Username', 'homesweet' ); ?>" type="text" name="login" class="form-control" required="required">
			</div><!-- /.form-group -->

			<div class="form-group">
				<input id="login-form-password-<?php echo esc_attr($_id); ?>" placeholder="<?php echo esc_html__( 'Password', 'homesweet' ); ?>" type="password" name="password" class="form-control" required="required">
			</div><!-- /.form-group -->
			<button type="submit" name="login_form" class="button btn btn-block btn-font-normal btn-theme"><?php echo esc_html__( 'LOGIN', 'homesweet' ); ?></button>
		</form>
	</div>
	<?php if ( defined('HOMESWEET_FACEBOOK_CONNECT_ACTIVED') || defined('HOMESWEET_GOOGLE_CONNECT_ACTIVED') || defined('HOMESWEET_TWITTER_CONNECT_ACTIVED') ) { ?>
	<div class="visibled-cell no-padding col-sm-5 left-social">
		<div class="social-connect">
			<div class="desc">
				<?php esc_html_e( 'You can login using  your facebook, twitter or google account', 'homesweet' ); ?>
			</div>
			<ul class='login-social'>
			<?php if ( defined('HOMESWEET_FACEBOOK_CONNECT_ACTIVED') ) { ?>
				<li>
					<a class="btn btn-facebook btn-block" href="<?php echo wp_login_url(); ?>?loginFacebook=1" onclick="window.location = '<?php echo wp_login_url(); ?>?loginFacebook=1&redirect='+window.location.href; return false;">
						<i class="fa fa-facebook" aria-hidden="true"></i>
	 					<?php esc_html_e('Facebook Connect', 'homesweet'); ?>
					</a>
				</li>
			<?php } ?>
			<?php if ( defined('HOMESWEET_TWITTER_CONNECT_ACTIVED') ) { ?>
				<li>
					<a class="btn btn-twitter btn-block" href="<?php echo wp_login_url(); ?>?loginTwitter=1" onclick="window.location = '<?php echo wp_login_url(); ?>?loginTwitter=1&redirect='+window.location.href; return false;">
						<i class="fa fa-twitter" aria-hidden="true"></i>
						<?php esc_html_e('Twitter Connect', 'homesweet'); ?>
					</a>
				</li>
			<?php } ?>
			<?php if ( defined('HOMESWEET_GOOGLE_CONNECT_ACTIVED') ) { ?>
				<li>
					<a class="btn btn-google btn-block" href="<?php echo wp_login_url(); ?>?loginGoogle=1" onclick="window.location = '<?php echo wp_login_url(); ?>?loginGoogle=1&redirect='+window.location.href; return false;">
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