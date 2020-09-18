<div class="property-content">
    <div class="property-description">
        <?php if ( ! empty( $section_title ) ): ?><h2><?php echo esc_attr( $section_title ); ?></h2><?php endif; ?>
        <?php the_content( sprintf( __( 'Continue reading %s', 'realia' ), the_title( '<span class="screen-reader-text">', '</span>', false ) ) ); ?>
    </div><!-- /.property-description -->
</div><!-- /.property-content -->