<!-- SUBPROPERTIES -->
<?php $post = get_post(); ?>
<?php $author_id = $post->post_author; ?>
<?php $subproperties = Realia_Post_Type_Property::get_properties( $author_id, "publish", get_the_ID() ); ?>

<?php if ( is_array( $subproperties ) && ! empty( $subproperties ) ) : ?>
    <div class="subproperties">
        <?php if ( ! empty( $section_title ) ): ?><h2><?php echo esc_attr( $section_title ); ?></h2><?php endif; ?>

        <div class="row">
            <?php foreach ( $subproperties as $subproperty ): ?>
                <div class="col-md-4 col-sm-6">
                    <div class="property-box-wrapper">
                        <?php echo Realia_Template_Loader::load( 'properties/box', array( 'property' => $subproperty ) ); ?>
                    </div>
                </div><!-- /.col-sm-4 -->
            <?php endforeach; ?>
        </div><!-- /.row -->
    </div><!-- /.subproperties -->
<?php endif?>