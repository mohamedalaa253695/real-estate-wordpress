<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $input_titles = ! empty( $instance['input_titles'] ) ? $instance['input_titles'] : 'labels'; ?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

<?php if ( ! empty( $instance['title'] ) ) : ?>
    <?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
    <?php echo esc_attr( $instance['title'] ); ?>
    <?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
<?php endif; ?>

<form class="filter-property-form widget-filter-form <?php echo (isset($instance['layout_type']) ? $instance['layout_type'] : ''); ?>" method="get" action="<?php echo get_post_type_archive_link( 'property' ); ?>">
	<?php $skip = Realia_Filter::get_field_names(); ?>

	<?php if ( isset($instance['layout_type']) && $instance['layout_type'] == 'horizontal1' ) { ?>
		<?php $fields = Realia_Filter::get_fields(); ?>
		<?php if ( ! empty( $instance['sort'] ) ) : ?>
			<?php
			$keys = explode( ',', $instance['sort'] );
			$filtered_keys = array_filter( $keys );
			$fields = array_merge( array_flip( $filtered_keys ), $fields );
			?>
		<?php endif; ?>
		<div class="row top-search">
			<div class="col-md-9">
				<div class="row row-first">
					<?php foreach ( $fields as $key => $value ) : ?>
						<?php if ( empty( $instance['hide_'.$key] ) ) : ?>
							<?php if ( in_array($key, array('property_title')) ) { ?>
							<div class="col-sm-6">
							<?php } elseif( in_array($key, array('amenity')) ) { ?>
							<div class="col-sm-12">
							<?php } else { ?>
							<div class="col-sm-3">
							<?php } ?>
								
								<?php $template = str_replace( '_', '-', $key ); ?>
								<?php include Realia_Template_Loader::locate( 'widgets/filter-fields/' . $template ); ?>

							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="col-md-3">
				<?php if ( ! empty( $instance['show_adv_fields'] ) ) : ?>
					<a href="#toggle_adv" class="toggle-adv text-theme visiable-line">
						<i class="icon-ap_settings"></i> <span><?php esc_html_e('Advance', 'homesweet'); ?></span>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $instance['button_text'] ) ) : ?>
					<div class="visiable-line">
						<button class="button btn btn-blue"><?php echo esc_attr( $instance['button_text'] ); ?></button>
					</div><!-- /.form-group -->
				<?php endif; ?>
			</div>
		</div>
		<?php if ( ! empty( $instance['show_adv_fields'] ) ) : ?>
			<div class="advance-fields clearfix">
				<div class="row">
					<?php $fields_adv = Realia_Filter::get_fields(); ?>
					<?php if ( ! empty( $instance['sort_adv'] ) ) : ?>
						<?php
						$keys = explode( ',', $instance['sort_adv'] );
						$filtered_keys = array_filter( $keys );
						$fields_adv = array_merge( array_flip( $filtered_keys ), $fields_adv );
						?>
					<?php endif; ?>

					<?php foreach ( $fields_adv as $key => $value ) : ?>
						<?php if ( empty( $instance['hide_adv_'.$key] ) ) : ?>

							<?php if( in_array($key, array('amenity')) ) { ?>
							<div class="col-sm-12">
							<?php } elseif( in_array($key, array('home_area','lot_area')) ) { ?>
							<div class="col-sm-6">
							<?php } else { ?>
							<div class="col-sm-3">
							<?php } ?>

								<?php $template = str_replace( '_', '-', $key ); ?>
								<?php include Realia_Template_Loader::locate( 'widgets/filter-fields/' . $template ); ?>

							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	<?php } elseif ( isset($instance['layout_type']) && $instance['layout_type'] == 'horizontal2' ) { ?>
		<?php $fields = Realia_Filter::get_fields(); ?>
		<?php if ( ! empty( $instance['sort'] ) ) : ?>
			<?php
			$keys = explode( ',', $instance['sort'] );
			$filtered_keys = array_filter( $keys );
			$fields = array_merge( array_flip( $filtered_keys ), $fields );
			?>
		<?php endif; ?>
		<div class="top-search">
			<div class="row row-first">
				<?php foreach ( $fields as $key => $value ) : ?>
					<?php if ( empty( $instance['hide_'.$key] ) ) : ?>
						<?php if ( in_array($key, array('property_title', 'price')) ) { ?>
						<div class="col-sm-8">
						<?php } elseif( in_array($key, array('amenity')) ) { ?>
						<div class="col-sm-12">
						<?php } else { ?>
						<div class="col-sm-4">
						<?php } ?>
							
							<?php $template = str_replace( '_', '-', $key ); ?>
							<?php include Realia_Template_Loader::locate( 'widgets/filter-fields/' . $template ); ?>

						</div>
					<?php endif; ?>
				<?php endforeach; ?>

				<div class="col-md-4">
					<?php if ( ! empty( $instance['button_text'] ) ) : ?>
						<div class="clearfix">
							<button class="button btn btn-block btn-purple"><?php echo esc_attr( $instance['button_text'] ); ?></button>
						</div><!-- /.form-group -->
					<?php endif; ?>
					<?php if ( ! empty( $instance['show_adv_fields'] ) ) : ?>
						<a href="#toggle_adv" class="toggle-adv text-theme visiable-line">
							<i class="icon-ap_settings"></i> <span><?php esc_html_e('Advance', 'homesweet'); ?></span>
						</a>
					<?php endif; ?>
				</div>
			</div>
			
		</div>
		<?php if ( ! empty( $instance['show_adv_fields'] ) ) : ?>
			<div class="advance-fields clearfix">
				<div class="row">
					<?php $fields_adv = Realia_Filter::get_fields(); ?>
					<?php if ( ! empty( $instance['sort_adv'] ) ) : ?>
						<?php
						$keys = explode( ',', $instance['sort_adv'] );
						$filtered_keys = array_filter( $keys );
						$fields_adv = array_merge( array_flip( $filtered_keys ), $fields_adv );
						?>
					<?php endif; ?>

					<?php foreach ( $fields_adv as $key => $value ) : ?>
						<?php if ( empty( $instance['hide_adv_'.$key] ) ) : ?>

							<?php if ( in_array($key, array('property_title', 'price')) ) { ?>
							<div class="col-sm-8">
							<?php } elseif( in_array($key, array('amenity')) ) { ?>
							<div class="col-sm-12">
							<?php } else { ?>
							<div class="col-sm-4">
							<?php } ?>

								<?php $template = str_replace( '_', '-', $key ); ?>
								<?php include Realia_Template_Loader::locate( 'widgets/filter-fields/' . $template ); ?>

							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	<?php } else { ?>

		<?php $fields = Realia_Filter::get_fields(); ?>
		<?php if ( ! empty( $instance['sort'] ) ) : ?>
			<?php
			$keys = explode( ',', $instance['sort'] );
			$filtered_keys = array_filter( $keys );
			$fields = array_merge( array_flip( $filtered_keys ), $fields );
			?>
		<?php endif; ?>
		
		<?php foreach ( $fields as $key => $value ) : ?>
			<?php if ( empty( $instance['hide_'.$key] ) ) : ?>
				<?php $template = str_replace( '_', '-', $key ); ?>
				<?php include Realia_Template_Loader::locate( 'widgets/filter-fields/' . $template ); ?>
			<?php endif; ?>
		<?php endforeach; ?>

		<?php if ( ! empty( $instance['button_text'] ) ) : ?>
			<div class="form-group">
				<button class="button btn btn-purple btn-block"><?php echo esc_attr( $instance['button_text'] ); ?></button>
			</div><!-- /.form-group -->
		<?php endif; ?>

		<?php if ( ! empty( $instance['show_adv_fields'] ) ) : ?>
			<a href="#toggle_adv" class="toggle-adv">
				<i class="icon-ap_settings"></i> <span><?php esc_html_e('Advance', 'homesweet'); ?></span>
			</a>

			<div class="advance-fields">
				<?php $fields_adv = Realia_Filter::get_fields(); ?>
				<?php if ( ! empty( $instance['sort_adv'] ) ) : ?>
					<?php
					$keys = explode( ',', $instance['sort_adv'] );
					$filtered_keys = array_filter( $keys );
					$fields_adv = array_merge( array_flip( $filtered_keys ), $fields_adv );
					?>
				<?php endif; ?>

				<?php foreach ( $fields_adv as $key => $value ) : ?>
					<?php if ( empty( $instance['hide_adv_'.$key] ) ) : ?>
						<?php $template = str_replace( '_', '-', $key ); ?>
						<?php include Realia_Template_Loader::locate( 'widgets/filter-fields/' . $template ); ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	<?php } ?>

	<?php
	$current_sort_by =  !empty($_GET['filter-sort-by']) ? $_GET['filter-sort-by']  : (isset($_COOKIE['filter-sort-by']) ? $_COOKIE['filter-sort-by'] : '');
	$current_sort_order = !empty($_GET['filter-sort-order']) ? $_GET['filter-sort-order'] : (isset($_COOKIE['filter-sort-order']) ? $_COOKIE['filter-sort-order'] : '');
	if ( $current_sort_by ) {
		?>
		<input id="filter-sort-by" type="hidden" name="filter-sort-by" value="<?php echo trim($current_sort_by); ?>">
		<?php
	}
	if ( $current_sort_order ) {
		?>
		<input id="filter-sort-order" type="hidden" name="filter-sort-order" value="<?php echo trim($current_sort_order); ?>">
		<?php
	}
	?>
</form>

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>
