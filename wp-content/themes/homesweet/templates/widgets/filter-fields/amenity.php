<?php $amenities = get_terms( 'amenities', array( 'hide_empty' => false ) ); ?>
<?php if ( is_array( $amenities ) ) : ?>
	<div class="filter-amenities-wrapper">
		<?php if ( empty($amenity) || !$amenity ) { ?>
			<h3 class="filter-amenities-title"><i class="fa fa-plus-circle"></i> <?php echo esc_html__( 'Additional Amenities', 'homesweet' ); ?></h3>
		<?php } ?>
		
		<ul class="filter-amenities-list">
			<?php foreach ( $amenities as $amenity ) : ?>
				<li>
					<input type="checkbox" name="filter-amenities[]" value="<?php echo esc_attr( $amenity->term_id ); ?>" <?php if ( ! empty( $_GET['filter-amenities'] ) && in_array($amenity->term_id, $_GET['filter-amenities']) ) : ?>checked="checked"<?php endif; ?>>
					<span><?php echo esc_html( $amenity->name ); ?></span>
				</li>
			<?php endforeach ?>
		</ul>
	</div><!-- /.form-group -->
<?php endif; ?>

