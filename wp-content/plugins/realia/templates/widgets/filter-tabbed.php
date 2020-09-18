<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php
$input_titles = ! empty( $instance['input_titles'] ) ? $instance['input_titles'] : 'labels';
$classes = ! empty( $instance['classes'] ) ? $instance['classes'] : '';
?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

<?php if ( ! empty( $instance['title'] ) ) : ?>
	<?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
	<?php echo esc_attr( $instance['title'] ); ?>
	<?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
<?php endif; ?>

<div class="tabs <?php echo esc_attr( $classes );?>">
	<ul class="tabs-navigation">
		<?php
		/**
		 * realia_before_tabbed_widget_navigation_items
		 */
		do_action( 'realia_before_tabbed_widget_navigation_items', get_the_ID() );
		?>

		<?php $contract_options = Realia_Post_Type_Property::contract_options(); ?>

		<?php foreach( $contract_options as $contract_key => $contract_value ): ?>
			<?php
			$contract_key_lower = strtolower( $contract_key );

			if( $contract_key == array_keys( $contract_options )[0] ) {
				$is_active = empty( $_GET['filter-contract'] ) || $contract_key == $_GET['filter-contract'];
			} else {
				$is_active = ! empty( $_GET['filter-contract'] ) && $contract_key == $_GET['filter-contract'];
			}
			?>
			<li class="<?php echo $contract_key_lower; ?> <?php if ( $is_active ): ?>active<?php endif; ?>"><a href="#<?php echo esc_attr( $args['widget_id'] ); ?>-<?php echo $contract_key_lower; ?>"><?php echo $contract_value; ?></a></li>
		<?php endforeach; ?>

		<?php
		/**
		 * realia_after_tabbed_widget_navigation_items
		 */
		do_action( 'realia_after_tabbed_widget_navigation_items', get_the_ID() );
		?>

	</ul>

	<?php
		$fields = Realia_Filter::get_fields();
		if( array_key_exists( 'contract', $fields ) ) {
			unset( $fields['contract'] );
		}
	?>

	<div class="tabs-content">

	<?php foreach( $contract_options as $contract_key => $contract_value ): ?>
		<?php
		$contract_key_lower = strtolower( $contract_key );

		if( $contract_key == array_keys( $contract_options )[0] ) {
			$is_active = empty( $_GET['filter-contract'] ) || $contract_key == $_GET['filter-contract'];
		} else {
			$is_active = ! empty( $_GET['filter-contract'] ) && $contract_key == $_GET['filter-contract'];
		}
		?>

		<div class="tab-content <?php echo $contract_key_lower; ?>-tab <?php if ( $is_active ) : ?>active<?php endif; ?>" id="<?php echo esc_attr( $args['widget_id'] ); ?>-<?php echo $contract_key_lower; ?>">
			<form method="get" action="<?php echo get_post_type_archive_link( 'property' ); ?>">
				<?php $skip = Realia_Filter::get_field_names(); ?>

				<?php foreach ( $_GET as $key => $value ) : ?>
					<?php if ( ! in_array( $key, $skip ) ) : ?>
						<input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_html( $value ); ?>">
					<?php endif; ?>
				<?php endforeach; ?>

				<input type="hidden" name="filter-contract" value="<?php echo $contract_key; ?>">

				<?php if ( ! empty( $instance[ 'sort_' . $contract_key_lower ] ) ) : ?>
					<?php
					$keys = explode( ',', $instance[ 'sort_' . $contract_key_lower ] );
					$filtered_keys = array_filter( $keys );
					$fields = array_merge( array_flip( $filtered_keys ), $fields );
					?>
				<?php endif; ?>

				<?php $field_id_prefix = $contract_key_lower . '_'; ?>

				<?php foreach ( $fields as $key => $value ) : ?>
					<?php $template = str_replace( '_', '-', $key ); ?>
					<?php $instance[ 'hide_' . $key ] = ! empty( $instance[ $contract_key_lower . '_hide_' . $key ] ) ? $instance[ $contract_key_lower . '_hide_' . $key ] : null; ?>
					<?php include Realia_Template_Loader::locate( 'widgets/filter-fields/' . $template ); ?>
				<?php endforeach; ?>

				<?php if ( ! empty( $instance['button_text'] ) ) : ?>
					<div class="form-group">
						<button class="button"><?php echo esc_attr( $instance['button_text'] ); ?></button>
					</div><!-- /.form-group -->
				<?php endif; ?>
			</form>
		</div>

	<?php endforeach; ?>

	</div>
</div>

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>
