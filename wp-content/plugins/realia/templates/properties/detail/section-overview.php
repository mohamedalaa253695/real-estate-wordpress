<div class="property-content">
    <?php if ( ! empty( $section_title ) ): ?><h2><?php echo esc_attr( $section_title ); ?></h2><?php endif; ?>

    <div class="property-overview">
        <dl>
            <?php $price = Realia_Price::get_property_price(); ?>
            <?php if ( ! empty( $price ) ) : ?>
                <dt><?php echo __( 'Price', 'realia' )?></dt><dd><?php echo wp_kses( $price, wp_kses_allowed_html( 'post' ) ); ?></dd>
            <?php endif; ?>

            <?php $id = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'id', true ); ?>
            <?php if ( ! empty( $id ) ) : ?>
                <dt><?php echo __( 'Reference', 'realia' ); ?></dt><dd><?php echo esc_attr( $id ); ?></dd>
            <?php endif; ?>

            <?php $contact_name = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'contact_name', true ); ?>
            <?php if ( ! empty( $contact_name ) ) : ?>
                <dt><?php echo __( 'Contact name', 'realia' ); ?></dt><dd><?php echo esc_attr( $contact_name ); ?></dd>
            <?php endif; ?>

            <?php $contact_phone = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'contact_phone', true ); ?>
            <?php if ( ! empty( $contact_phone ) ) : ?>
                <dt><?php echo __( 'Contact phone', 'realia' ); ?></dt><dd><?php echo esc_attr( $contact_phone ); ?></dd>
            <?php endif; ?>

            <?php $year_built = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'year_built', true ); ?>
            <?php if ( ! empty( $year_built ) ) : ?>
                <dt><?php echo __( 'Year built', 'realia' ); ?></dt><dd><?php echo esc_attr( $year_built ); ?></dd>
            <?php endif; ?>

            <?php $type = Realia_Query::get_property_type_name(); ?>
            <?php if ( ! empty( $type ) ) : ?>
                <dt><?php echo __( 'Type', 'realia' ); ?></dt><dd><?php echo esc_attr( $type ); ?></dd>
            <?php endif; ?>

            <?php $sold = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'sold', true ); ?>
            <dt><?php echo __( 'Sold', 'realia' ); ?></dt>
            <dd>
                <?php if ( ! empty( $sold ) ) : ?>
                    <?php echo __( 'Yes', 'realia' ); ?>
                <?php else : ?>
                    <?php echo __( 'No', 'realia' ); ?>
                <?php endif; ?>
            </dd>

            <?php $contract = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'contract', true ); ?>

            <?php if ( ! empty( $contract ) ) : ?>
                <dt><?php echo __( 'Contract', 'realia' ); ?></dt>
                <dd>
                    <?php echo esc_attr( Realia_Post_Type_Property::get_contract_option( $contract ) ); ?>
                </dd>
            <?php endif; ?>

            <?php $status = Realia_Query::get_property_status_name(); ?>
            <?php if ( ! empty( $status ) ) : ?>
                <dt><?php echo __( 'Status', 'realia' ); ?></dt><dd><?php echo esc_attr( $status ); ?></dd>
            <?php endif; ?>

            <?php $location = Realia_Query::get_property_location_name(); ?>
            <?php if ( ! empty( $location ) ) : ?>
                <dt><?php echo __( 'Location', 'realia' ); ?></dt><dd><?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?></dd>
            <?php endif; ?>

            <?php $home_area = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'home_area', true ); ?>
            <?php if ( ! empty( $home_area ) ) : ?>
                <?php $home_area = Realia_Utilities::format_number( $home_area ); ?>
                <dt><?php echo __( 'Home area', 'realia' ); ?></dt><dd><?php echo esc_attr( $home_area ); ?>
                    <?php echo get_theme_mod( 'realia_measurement_area_unit', 'sqft' ); ?></dd>
            <?php endif; ?>

            <?php $lot_dimensions = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'lot_dimensions', true ); ?>
            <?php if ( ! empty( $lot_dimensions ) ) : ?>
                <dt><?php echo __( 'Lot dimensions', 'realia' ); ?></dt><dd><?php echo esc_attr( $lot_dimensions ); ?>
                    <?php echo get_theme_mod( 'realia_measurement_distance_unit', 'ft' ); ?></dd>
            <?php endif; ?>

            <?php $lot_area = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'lot_area', true ); ?>
            <?php if ( ! empty( $lot_area ) ) : ?>
                <?php $lot_area = Realia_Utilities::format_number( $lot_area ); ?>
                <dt><?php echo __( 'Lot area', 'realia' ); ?></dt><dd><?php echo esc_attr( $lot_area ); ?>
                    <?php echo get_theme_mod( 'realia_measurement_area_unit', 'sqft' ); ?></dd>
            <?php endif; ?>

            <?php $material = Realia_Query::get_property_material_name(); ?>
            <?php if ( ! empty( $material ) ) : ?>
                <dt><?php echo __( 'Material', 'realia' ); ?></dt><dd><?php echo wp_kses( $material, wp_kses_allowed_html( 'post' ) ); ?></dd>
            <?php endif; ?>

            <?php $rooms = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'rooms', true ); ?>
            <?php if ( ! empty( $rooms ) ) : ?>
                <dt><?php echo __( 'Rooms', 'realia' ); ?></dt><dd><?php echo esc_attr( $rooms ); ?></dd>
            <?php endif; ?>

            <?php $beds = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'beds', true ); ?>
            <?php if ( ! empty( $beds ) ) : ?>
                <dt><?php echo __( 'Beds', 'realia' ); ?></dt><dd><?php echo esc_attr( $beds ); ?></dd>
            <?php endif; ?>

            <?php $baths = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'baths', true ); ?>
            <?php if ( ! empty( $baths ) ) : ?>
                <dt><?php echo __( 'Baths', 'realia' ); ?></dt><dd><?php echo esc_attr( $baths ); ?></dd>
            <?php endif; ?>

            <?php $garages = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'garages', true ); ?>
            <?php if ( ! empty( $garages ) ) : ?>
                <dt><?php echo __( 'Garages', 'realia' ); ?></dt><dd><?php echo esc_attr( $garages ); ?></dd>
            <?php endif; ?>
        </dl>
    </div><!-- /.property-overview -->
</div><!-- /.property-content -->