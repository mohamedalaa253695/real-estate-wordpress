<div class="property-content">
    <?php $video = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'video', true ); ?>
    <?php if ( ! empty( $video ) ) : ?>
        <div class="property-video">
            <?php if ( ! empty( $section_title ) ): ?><h2><?php echo esc_attr( $section_title ); ?></h2><?php endif; ?>

            <div class="video-embed-wrapper">
                <?php echo apply_filters( 'the_content', '[embed width="1280" height="720"]' . esc_attr( $video ) . '[/embed]' ); ?>
            </div>
        </div><!-- /.property-video -->
    <?php endif; ?>
</div><!-- /.property-content -->
