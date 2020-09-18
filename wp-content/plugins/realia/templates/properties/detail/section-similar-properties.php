<!-- SIMILAR PROPERTIES -->
<?php Realia_Query::loop_properties_similar(); ?>

<?php if ( have_posts() ) : ?>
    <div class="similar-properties">
        <?php if ( ! empty( $section_title ) ): ?><h2><?php echo esc_attr( $section_title ); ?></h2><?php endif; ?>

        <div class="type-box item-per-row-3">
            <div class="properties-row">
                <?php $index = 0; ?>
                <?php while ( have_posts() ) : the_post(); ?>
                <div class="property-container">
                    <?php echo Realia_Template_Loader::load( 'properties/box' ); ?>
                </div>

                <?php if ( 0 == ( ( $index + 1 ) % 3 ) && Realia_Query::loop_has_next() ) : ?>
            </div><div class="properties-row">
                <?php endif; ?>
                <?php $index++; ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div><!-- /.similar-properties -->
<?php endif?>

<?php wp_reset_query(); ?>