<?php
extract( $args );
extract( $instance );

?>

<div class="contact-info-widget">
<?php
if ( $phone_image != '' || $phone_content != '' ) {
    ?>
    <div class="media phone-info pull-left">
        <?php if ( $phone_image ) { ?>
            <div class="media-left media-middle">
                <div class="icon">
                    <img src="<?php echo esc_attr( $phone_image ); ?>" alt="">
                </div>
            </div>
        <?php } ?>
        <div class="media-body">
            <?php if ($phone_content) { ?>
                <div class="content"><?php echo trim($phone_content); ?></div>
            <?php } ?>
        </div>
    </div>
    <?php
}
?>

<?php
if ( $address_image != '' || $address_content != '' ) {
    ?>
    <div class="media address-info pull-left">
        <?php if ( $address_image ) { ?>
            <div class="media-left media-middle">
                <div class="icon">
                    <img src="<?php echo esc_attr( $address_image ); ?>" alt="">
                </div>
            </div>
        <?php } ?>
        <div class="media-body">
            <?php if ($address_content) { ?>
                <div class="content"><?php echo trim($address_content); ?></div>
            <?php } ?>
        </div>
    </div>
    <?php
}
?>
</div>