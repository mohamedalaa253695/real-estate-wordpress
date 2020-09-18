<?php if ( empty( $property ) ): ?>
    <div class="alert alert-warning">
        <?php echo esc_html__( 'You have to specify property!', 'homesweet' ) ?>
    </div>
<?php else: ?>
    <h3 class="delete-title"><?php echo sprintf(__( "Are you sure you want to delete %s?", 'homesweet' ), get_the_title( $property ) ); ?></h3>

    <?php $submission_list_page = get_theme_mod( 'realia_submission_list_page', false ); ?>
    <?php $action = empty( $submission_list_page ) ? get_home_url() : get_permalink( $submission_list_page ); ?>

    <form method="post" action="<?php echo trim($action); ?>">
        <input type="hidden" name="property_id" value="<?php echo trim($property->ID); ?>">

        <div class="button-wrapper">
            <button type="submit" class="btn btn-danger" name="remove_property_form"><?php echo esc_html__( 'Delete', 'homesweet' ); ?></button>
        </div><!-- /.button-wrapper -->
    </form>
<?php endif; ?>