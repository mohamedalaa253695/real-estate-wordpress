<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $create_page_id = get_theme_mod( 'realia_submission_create_page', null ); ?>

<?php if ( ! empty( $create_page_id ) ) : ?>
	<?php if ( Realia_Packages::is_allowed_to_add_submission( get_current_user_id() ) ) :   ?>
		<a href="<?php echo get_permalink( $create_page_id ); ?>" class="property-create"><?php echo esc_html__( 'Create Property', 'homesweet' ); ?></a>
	<?php endif; ?>
<?php endif; ?>

<?php $paged = ( get_query_var( 'paged' )) ? get_query_var( 'paged' ) : 1; ?>

<?php query_posts( array(
	'post_type'     => 'property',
	'post_status'   => 'any',
	'paged'         => $paged,
	'author'        => get_current_user_id(),
) ); ?>

<?php if ( have_posts() ) : ?>
<div class="my-properties">
	<table class="property-table">
		<tbody>
		<?php while ( have_posts() ) : the_post(); global $post; ?>
			<tr>
				<td class="property-table-info">
					<?php if ( get_post_status() == 'pending' ) : ?>
						<div class="ribbon warning">
						</div><!-- /.ribbon -->
					<?php elseif ( get_post_status() == 'publish' ) : ?>
						<div class="ribbon publish"></div><!-- /.ribbon -->
					<?php elseif ( get_post_status() == 'draft' ) : ?>
						<div class="ribbon draft"></div><!-- /.ribbon -->
					<?php endif; ?>

					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="property-table-info-image">
							<?php homesweet_realia_post_thumbnail($post, 'thumbnail'); ?>
						</a><!-- /.property-table-info-image -->
					<?php else : ?>
						<a href="<?php the_permalink(); ?>" class="property-table-info-image-none">
							<?php echo esc_html__( 'No image', 'homesweet' ); ?>
						</a><!-- /.property-table-info-image-none -->
					<?php endif; ?>

					<div class="property-table-info-content">
						<div class="property-table-info-content-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</div><!-- /.property-table-info-content-title -->

						<?php $location = Realia_Query::get_property_location_name(); ?>
						<?php if ( ! empty( $location ) ) : ?>
							<div class="property-table-info-content-location">
								<i class="icon-ap_pin" aria-hidden="true"></i>
								<?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?>
							</div><!-- /.property-table-info-content-location -->
						<?php endif; ?>

						<?php $price = Realia_Price::get_property_price(); ?>
						<?php if ( ! empty( $price ) ) : ?>
							<div class="property-table-info-content-price">
								<?php echo wp_kses( $price, wp_kses_allowed_html( 'post' ) ); ?>
							</div><!-- /.property-table-info-content-price -->
						<?php endif; ?>
					</div><!-- /.property-table-info-content -->
				</td>

				<td class="property-table-actions min-width nowrap">
					<div class="property-table-actions-inner">
						<?php $payment_page_id = get_theme_mod( 'realia_submission_payment_page', null ); ?>

						<?php if ( ! empty( $payment_page_id ) ) : ?>

							<!-- STICKY -->
							<?php $is_sticky = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'sticky', true ); ?>
							<?php if ( ! $is_sticky ) : ?>
								<?php $enable_sticky = get_theme_mod( 'realia_submission_enable_sticky', false ); ?>
								<?php if ( ! empty( $enable_sticky ) ) : ?>
									<?php $price = get_theme_mod( 'realia_submission_sticky_price', null ); ?>
									<?php if ( ! empty( $price ) ) : ?>
										<form method="post" action="<?php echo get_permalink( $payment_page_id ); ?>">
											<input type="hidden" name="payment_type" value="pay_for_sticky">
											<input type="hidden" name="object_id" value="<?php the_ID(); ?>">

											<button type="submit">
												<?php echo esc_html__( 'Make TOP', 'homesweet' ); ?> <span class="label label-primary"><?php echo Realia_Price::format_price( $price ); ?></span>
											</button>
										</form>
									<?php endif; ?>
								<?php endif; ?>
							<?php else : ?>
								<button class="disabled">
									<?php echo esc_html__( 'Sticky', 'homesweet' ); ?>
								</button>
							<?php endif; ?>

							<!-- FEATURED -->
							<?php $is_featured = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'featured', true ); ?>
							<?php if ( ! $is_featured ) : ?>
								<?php $enable_featured = get_theme_mod( 'realia_submission_enable_featured', false ); ?>
								<?php if ( ! empty( $enable_featured ) ) : ?>
									<?php $price = get_theme_mod( 'realia_submission_featured_price', null ); ?>

									<?php if ( ! empty( $price ) ) : ?>
										<form method="post" action="<?php echo get_permalink( $payment_page_id ); ?>">
											<input type="hidden" name="payment_type" value="pay_for_featured">
											<input type="hidden" name="object_id" value="<?php the_ID(); ?>">

											<button type="submit">
												<?php echo esc_html__( 'Make featured', 'homesweet' ); ?> <span class="label label-primary"><?php echo Realia_Price::format_price( $price ); ?></span>
											</button>
										</form>
									<?php endif; ?>
								<?php endif; ?>
							<?php else : ?>
								<button class="disabled">
									<?php echo esc_html__( 'Featured', 'homesweet' ); ?>
								</button>
							<?php endif; ?>

							<!-- PUBLISHED -->
							<?php $submission_type = get_theme_mod( 'realia_submission_type', false ); ?>
							<?php $property_status = get_post_status(); ?>
							<?php if ( 'publish' == $property_status ) : ?>
								<button class="disabled">
									<?php echo esc_html__( 'Published', 'homesweet' ); ?>
								</button>
							<?php else : ?>
								<!-- PAY PER POST -->
								<?php if ( 'pay-per-post' == $submission_type ) : ?>
									<?php $price = get_theme_mod( 'realia_submission_pay_per_post_price', null ); ?>
									<?php if ( ! empty( $price ) ) : ?>
										<form method="post" action="<?php echo get_permalink( $payment_page_id ); ?>">
											<input type="hidden" name="payment_type" value="pay_per_post">
											<input type="hidden" name="object_id" value="<?php the_ID(); ?>">

											<button type="submit">
												<?php echo esc_html__( 'Publish', 'homesweet' ); ?> <span class="label label-primary"><?php echo Realia_Price::format_price( $price ); ?></span>
											</button>
										</form>
									<?php endif; ?>
								<?php elseif ( 'packages' == $submission_type ) : ?>
									<?php // Nothing to do ?>
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>
					</div><!-- /.property-table-actions-inner -->
				</td><!-- /.property-table-actions -->
				<td class="view">
					<a href="<?php the_permalink(); ?>" class="button-view property-table-action">
						<i class="fa fa-eye" aria-hidden="true"></i>
						<?php echo esc_html__( 'View', 'homesweet' ); ?>
					</a>
				</td>
				<td class="edit">
					<?php $edit_page_id = get_theme_mod( 'realia_submission_edit_page', null ); ?>
					<?php if ( ! empty( $edit_page_id ) ) : ?>
						<a href="<?php echo get_permalink( $edit_page_id ); ?>?id=<?php the_ID(); ?>" class="property-table-action">
							<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
							<?php echo esc_html__( 'Edit', 'homesweet' ); ?>
						</a>
					<?php endif; ?>
				</td>
				<td class="min-width nowrap">
					<?php $remove_page_id = get_theme_mod( 'realia_submission_remove_page', null ); ?>

					<?php if ( ! empty( $remove_page_id ) ) : ?>
						<a href="<?php echo get_permalink( $remove_page_id ); ?>?id=<?php the_ID(); ?>" class="property-table-action property-button-delete">
							<i class="ion-ios-close-empty"></i>
						</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>
</div>
<div class="space-top-30">
	<?php the_posts_pagination( array(
		'prev_text'          => esc_html__( 'Previous page', 'homesweet' ),
		'next_text'          => esc_html__( 'Next page', 'homesweet' ),
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'homesweet' ) . ' </span>',
	) ); ?>
</div>
	<?php wp_reset_query(); ?>
<?php else : ?>
	<div class="alert alert-warning">
		<p><?php echo esc_html__( 'You don\'t have any properties, yet. Start by creating new one.', 'homesweet' ); ?></p>
	</div>
<?php endif; ?>