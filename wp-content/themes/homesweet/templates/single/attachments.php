<?php $attachments = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'attachments', true ); ?>

<?php if ( ! empty( $attachments ) && is_array($attachments) ) : ?>
    <div id="property-section-attachments" class="property-section property-attachments">
        <h3><?php echo esc_html__('File Attachments', 'homesweet'); ?></h3>
        <div class="property-section-content">
            <?php foreach ($attachments as $id => $attachment) {
                $apost = homesweet_get_attachment_metadata($id);
            ?>
                <div class="attachment-item">
                    <a href="<?php echo esc_url( $apost->guid ); ?>">
                        <i class="fa fa-file-image-o"></i> <?php echo esc_attr( $apost->post_title ); ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
<?php endif; ?>