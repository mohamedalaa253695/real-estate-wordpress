<div id="property-section-detail" class="property-section property-overview">
	<h3><?php echo esc_html__('Detail', 'homesweet'); ?></h3>
	<div class="overview-header">
		<ul class="columns-gap columns-gap5">
			<?php $home_area = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'home_area', true ); ?>
			<?php if ( ! empty( $home_area ) ) : ?>
				<?php $home_area = Realia_Utilities::format_number( $home_area ); ?>
				<li><span><?php echo esc_html__( 'Area:', 'homesweet' ); ?></span> <?php echo esc_attr( $home_area ); ?>
					<?php echo get_theme_mod( 'realia_measurement_area_unit', 'sqft' ); ?></li>
			<?php endif; ?>
			<?php $beds = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'beds', true ); ?>
			<?php if ( ! empty( $beds ) ) : ?>
				<li><span><?php echo esc_html__( 'Beds:', 'homesweet' ); ?></span> <?php echo esc_attr( $beds ); ?></li>
			<?php endif; ?>

	        <?php $baths = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'baths', true ); ?>
	        <?php if ( ! empty( $baths ) ) : ?>
	            <li><span><?php echo esc_html__( 'Baths:', 'homesweet' ); ?></span> <?php echo esc_attr( $baths ); ?></li>
	        <?php endif; ?>
	        <?php $garages = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'garages', true ); ?>
			<?php if ( ! empty( $garages ) ) : ?>
				<li><span><?php echo esc_html__( 'Garages:', 'homesweet' ); ?></span> <?php echo esc_attr( $garages ); ?></li>
			<?php endif; ?>
			<?php $year_built = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'year_built', true ); ?>
			<?php if ( ! empty( $year_built ) ) : ?>
				<li><span><?php echo esc_html__( 'Year built:', 'homesweet' ); ?></span> <?php echo esc_attr( $year_built ); ?></li>
			<?php endif; ?>
		</ul>
	</div>
	<ul class="columns-gap">
		<?php $id = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'id', true ); ?>
		<?php if ( ! empty( $id ) ) : ?>
			<li><span><?php echo esc_html__( 'Reference:', 'homesweet' ); ?></span> <?php echo esc_attr( $id ); ?></li>
		<?php endif; ?>

		<?php $contact_name = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'contact_name', true ); ?>
		<?php if ( ! empty( $contact_name ) ) : ?>
			<li><span><?php echo esc_html__( 'name:', 'homesweet' ); ?></span> <?php echo esc_attr( $contact_name ); ?></li>
		<?php endif; ?>

		<?php $contact_phone = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'contact_phone', true ); ?>
		<?php if ( ! empty( $contact_phone ) ) : ?>
			<li><span><?php echo esc_html__( 'phone:', 'homesweet' ); ?></span> <?php echo esc_attr( $contact_phone ); ?></li>
		<?php endif; ?>

		<?php $type = Realia_Query::get_property_type_name(); ?>
		<?php if ( ! empty( $type ) ) : ?>
			<li><span><?php echo esc_html__( 'Type:', 'homesweet' ); ?></span> <?php echo esc_attr( $type ); ?></li>
		<?php endif; ?>

		<?php $sold = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'sold', true ); ?>
		<li><span><?php echo esc_html__( 'Sold:', 'homesweet' ); ?></span>
			<?php if ( ! empty( $sold ) ) : ?>
				<?php echo esc_html__( 'Yes', 'homesweet' ); ?>
			<?php else : ?>
				<?php echo esc_html__( 'No', 'homesweet' ); ?>
			<?php endif; ?>
		</li>

		<?php $contract = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'contract', true ); ?>

		<?php if ( ! empty( $contract ) ) : ?>
			<li><span><?php echo esc_html__( 'Contract:', 'homesweet' ); ?></span>
				<?php echo esc_attr( Realia_Post_Type_Property::get_contract_option( $contract ) ); ?>
			</li>
		<?php endif; ?>

		<?php $status = Realia_Query::get_property_status_name(); ?>
		<?php if ( ! empty( $status ) ) : ?>
			<li><span><?php echo esc_html__( 'Status:', 'homesweet' ); ?></span> <?php echo esc_attr( $status ); ?></li>
		<?php endif; ?>

        <?php $location = Realia_Query::get_property_location_name(); ?>
		<?php if ( ! empty( $location ) ) : ?>
			<li><span><?php echo esc_html__( 'Location:', 'homesweet' ); ?></span> <?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?></li>
		<?php endif; ?>


		<?php $lot_dimensions = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'lot_dimensions', true ); ?>
		<?php if ( ! empty( $lot_dimensions ) ) : ?>
			<li><span><?php echo esc_html__( 'Lot dimensions:', 'homesweet' ); ?></span> <?php echo esc_attr( $lot_dimensions ); ?>
				<?php echo get_theme_mod( 'realia_measurement_distance_unit', 'ft' ); ?></li>
		<?php endif; ?>

		<?php $lot_area = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'lot_area', true ); ?>
		<?php if ( ! empty( $lot_area ) ) : ?>
			<?php $lot_area = Realia_Utilities::format_number( $lot_area ); ?>
			<li><span><?php echo esc_html__( 'Lot area:', 'homesweet' ); ?></span> <?php echo esc_attr( $lot_area ); ?>
				<?php echo get_theme_mod( 'realia_measurement_area_unit', 'sqft' ); ?></li>
		<?php endif; ?>

        <?php $material = Realia_Query::get_property_material_name(); ?>
        <?php if ( ! empty( $material ) ) : ?>
            <li><span><?php echo esc_html__( 'Material:', 'homesweet' ); ?></span> <?php echo wp_kses( $material, wp_kses_allowed_html( 'post' ) ); ?></li>
        <?php endif; ?>

        <?php $rooms = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'rooms', true ); ?>
        <?php if ( ! empty( $rooms ) ) : ?>
            <li><span><?php echo esc_html__( 'Rooms:', 'homesweet' ); ?></span> <?php echo esc_attr( $rooms ); ?></li>
        <?php endif; ?>

	</ul>
</div><!-- /.property-overview -->