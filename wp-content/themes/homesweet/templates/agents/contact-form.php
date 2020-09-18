<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $agent_email = get_post_meta( get_the_ID(), REALIA_AGENT_PREFIX . 'email', true ); ?>

<?php if ( ! empty( $_POST ) && array_key_exists( 'contact-form', $_POST ) ) : ?>
    <?php
	$is_form_filled = ! empty( $_POST['email'] ) && ! empty( $_POST['subject'] ) && ! empty( $_POST['message'] );
	$is_recaptcha = Realia_Recaptcha::is_recaptcha_enabled();
	$is_recaptcha_valid = array_key_exists( 'g-recaptcha-response', $_POST ) ? Realia_Recaptcha::is_recaptcha_valid( $_POST['g-recaptcha-response'] ) : false;
	?>

    <?php if ( ! ( $is_recaptcha && ! $is_recaptcha_valid ) && $is_form_filled ) : ?>
        <?php
        $email = sanitize_text_field( $_POST['email'] );
        $subject = sanitize_text_field( $_POST['subject'] );
        $message = sanitize_text_field( $_POST['message'] );
        $headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $email, $email );
        $result = wp_mail( $agent_email, $subject, $message, $headers );
        ?>

        <?php if ( $result ) : ?>
            <div class="alert alert-success"><?php echo esc_html__( 'Your message has been successfully sent.', 'homesweet' ); ?></div>
        <?php else : ?>
            <div class="alert alert-warning"><?php echo esc_html__( 'An error occurred when sending an email.', 'homesweet' ); ?></div>
        <?php endif; ?>
    <?php else : ?>
        <div class="alert alert-warning"><?php echo esc_html__( 'Form has been not filled correctly.', 'homesweet' ); ?></div>
    <?php endif; ?>
<?php endif; ?>

<?php if ( ! empty( $agent_email ) ) : ?>
    <div class="agent-contact widget">
        <h2 class="widget-title"><span><?php echo esc_html__( 'Contact Form', 'homesweet' ); ?></span></h2>

        <div class="agent-contact-form">
            <form method="post" action="?">
                <div class="form-group">
                    <input type="text" class="form-control" name="subject" placeholder="<?php echo esc_html__( 'Subject', 'homesweet' ); ?>">
                </div><!-- /.form-group -->

                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="<?php echo esc_html__( 'E-mail', 'homesweet' ); ?>">
                </div><!-- /.form-group -->

                <div class="form-group space-20">
                    <textarea class="form-control" name="message" placeholder="<?php echo esc_html__( 'Message', 'homesweet' ); ?>"></textarea>
                </div><!-- /.form-group -->

                <?php if ( Realia_Recaptcha::is_recaptcha_enabled() ) : ?>
                    <div id="recaptcha-agent-contact" class="recaptcha" data-sitekey="<?php echo get_theme_mod( 'realia_recaptcha_site_key' ); ?>"></div>
                <?php endif; ?>

                <button class="button btn btn-block btn-purple" name="contact-form"><?php echo esc_html__( 'Send message', 'homesweet' ); ?></button>
            </form>
        </div><!-- /.agent-contact-form -->
    </div><!-- /.agent-contact-->
<?php endif; ?>
