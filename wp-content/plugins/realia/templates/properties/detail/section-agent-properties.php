<!-- AGENT PROPERTIES -->
<?php $property_agents = Realia_Query::get_property_agents(); ?>

<?php if( count( $property_agents ) > 0 ): ?>
    <?php $agent_id = $property_agents[0]; ?>
    <?php $current_id = get_the_ID(); ?>

    <?php Realia_Query::loop_agent_properties( $agent_id ); ?>

    <?php if ( have_posts() ) : ?>
        <div class="similar-properties">
            <?php if ( ! empty( $section_title ) ): ?><h2><?php echo esc_attr( $section_title ); ?></h2><?php endif; ?>

            <div class="row">
                <?php $index = 0; ?>
                <?php while( have_posts() ) : the_post(); ?>

                <?php if( $current_id != get_the_ID() ): ?>
                <div class="col-md-4 col-sm-6">
                    <div class="property-box-wrapper">
                        <?php echo Realia_Template_Loader::load( 'properties/box' ); ?>
                    </div>
                </div><!-- /.col-sm-4 -->

                <?php if ( 0 == ( ( $index + 1 ) % 3 ) && Realia_Query::loop_has_next() ) : ?>
            </div><div class="properties-row">
                <?php endif; ?>

                <?php $index++; ?>
                <?php endif; ?>
                <?php endwhile; ?>
            </div><!-- /.row -->
        </div><!-- /.similar-properties -->
    <?php endif?>
<?php endif; ?>

<?php wp_reset_query(); ?>