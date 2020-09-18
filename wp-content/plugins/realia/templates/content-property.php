<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php do_action( 'realia_before_property_detail', get_the_ID() ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title property-title">', '</h1>' );
		else :
			the_title( sprintf( '<h2 class="entry-title property-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		endif;
		?>
	</header><!-- .entry-header -->

	<div class="property-detail-actions">
		<?php do_action( 'property_actions', get_the_ID() ); ?>
	</div><!-- /.property-detail-actions -->

	<div class="property-detail-subtitle">
		<?php $location = Realia_Query::get_property_location_name( null, "," ); ?>
		<?php if ( ! empty ( $location ) ) : ?>
			<div class="property-location">
				<?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?>
			</div>
		<?php endif; ?>
		<?php $price = Realia_Price::get_property_price(); ?>
		<?php if ( ! empty( $price ) ) : ?>
			<div class="property-price">
				<?php echo wp_kses( $price, wp_kses_allowed_html( 'post' ) ); ?>
			</div>
		<?php endif; ?>
	</div>

	<?php $is_child_property = Realia_Post_Types::is_child_property(); ?>
	<?php if ( $is_child_property ) : ?>
		<?php $parent_listing = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'parent_property', true ); ?>
		<a class="link-to-parent-property" href="<?php echo get_permalink( $parent_listing ); ?>"><?php echo __( 'Back to', 'realia' ); ?> <?php echo get_the_title( $parent_listing ); ?></a>
	<?php endif; ?>

	<?php Realia_Post_Types::render_property_detail_sections(); ?>
</article><!-- #post-## -->

<?php do_action( 'realia_after_property_detail', get_the_ID() ); ?>