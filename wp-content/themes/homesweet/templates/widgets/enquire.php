<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

<?php if ( ! empty( $instance['title'] ) ) : ?>
    <?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
    <?php echo esc_attr( $instance['title'] ); ?>
    <?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
<?php endif; ?>

<form method="post" class="contact-agent" action="<?php the_permalink(); ?>">
    <input type="hidden" name="post_id" value="<?php the_ID(); ?>">

    <?php if ( ! empty( $instance['receive_admin'] ) ) : ?>
        <input type="hidden" name="receive_admin" value="1">
    <?php endif; ?>

    <?php if ( ! empty( $instance['receive_author'] ) ) : ?>
        <input type="hidden" name="receive_author" value="1">
    <?php endif; ?>

    <?php if ( ! empty( $instance['receive_agent'] ) ) : ?>
        <input type="hidden" name="receive_agent" value="1">
    <?php endif; ?>

    <div class="form-group">
        <input class="form-control" name="name" type="text" placeholder="<?php echo esc_html__( 'Name', 'homesweet' ); ?>" value="<?php echo empty( $_POST['name'] ) ? '' : esc_attr( $_POST['name'] ); ?>" required="required">
    </div><!-- /.form-group -->

    <div class="form-group">
        <input class="form-control" name="email" type="email" placeholder="<?php echo esc_html__( 'E-mail', 'homesweet' ); ?>" value="<?php echo empty( $_POST['email'] ) ? '' : esc_attr( $_POST['email'] ); ?>" required="required">
    </div><!-- /.form-group -->

    <div class="form-group">
        <input class="form-control" name="phone" type="text" placeholder="<?php echo esc_html__( 'Phone', 'homesweet' ); ?>" value="<?php echo empty( $_POST['phone'] ) ? '' : esc_attr( $_POST['phone'] ); ?>" required="required">
    </div><!-- /.form-group -->

    <div class="form-group">
        <textarea class="form-control" name="message" required="required" placeholder="<?php echo esc_html__( 'Hello, I am interested in 
[ Villa on hollywood boulevard ]', 'homesweet' ); ?>" rows="4"><?php echo empty( $_POST['message'] ) ? '' : esc_attr( $_POST['message'] ); ?></textarea>
    </div><!-- /.form-group -->

    <?php if ( empty( $instance['disable_recaptcha'] ) ) : ?>
        <?php if ( Realia_Recaptcha::is_recaptcha_enabled() ) : ?>
            <div id="recaptcha-<?php echo esc_attr( $this->id ); ?>" class="g-recaptcha" data-sitekey="<?php echo get_theme_mod( 'realia_recaptcha_site_key' ); ?>"></div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="button-wrapper">
        <button type="submit" class="button btn btn-block btn-purple" name="enquire_form"><?php echo esc_html__( 'Send Message', 'homesweet' ); ?></button>
    </div><!-- /.button-wrapper -->
</form>

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>
