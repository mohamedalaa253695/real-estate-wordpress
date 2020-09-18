<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php
    $package_id = get_the_ID();
    $label = !empty($label) ? $label : '';
    $price_formatted = Realia_Packages::get_package_formatted_price( $package_id );
    $duration = Realia_Packages::get_package_duration( $package_id, true );
?>
<div class="package-wrapper">
    <div class="package-heading">
        <h3 class="entry-title"><?php echo get_the_title() ?></h3>
        <?php if ($label) { ?>
            <span class="label"><?php echo esc_html($label); ?></span>
        <?php } ?>
    </div>
    <div class="price">
        <?php echo trim($price_formatted ? $price_formatted : esc_html__('Free', 'homesweet')); ?>
        <?php if ( !empty($duration) ) { ?>
            <span class="duration">
                <?php echo trim($duration); ?>
            </span>
        <?php } ?>
    </div>
    <div class="package-content">
        <?php the_content(); ?>
    </div>
    <?php $package_payment_id = get_theme_mod( 'realia_submission_payment_page', false ); ?>
    <?php if ( ! empty( $package_payment_id ) ) : ?>
        <div class="package-actions">
            <form method="post" action="<?php echo esc_attr( get_permalink( $package_payment_id ) ); ?>">
                <input type="hidden" name="payment_type" value="package">
                <input type="hidden" name="object_id" value="<?php the_ID(); ?>">

                <button type="submit" class="btn btn-submit btn-block" name="change-package"><?php echo esc_html__( 'BUY NOW', 'homesweet' ); ?></button>
            </form>
        </div>
    <?php endif; ?>
</div>
<?php wp_reset_postdata(); ?>