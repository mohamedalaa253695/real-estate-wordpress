<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
$price_min = ! empty( $instance['price_min'] ) ? $instance['price_min'] : 0;
$price_max = ! empty( $instance['price_max'] ) ? $instance['price_max'] : 1000000;
$input_titles = ! empty( $instance['input_titles'] ) ? $instance['input_titles'] : '';
$layout_type = ! empty( $instance['layout_type'] ) ? $instance['layout_type'] : '';
$sort = ! empty( $instance['sort'] ) ? $instance['sort'] : '';
$sort_adv = ! empty( $instance['sort_adv'] ) ? $instance['sort_adv'] : '';
$_id = homesweet_random_key();
?>

<!-- TITLE -->
<div id="filter-property-<?php echo esc_attr($_id); ?>">
	<p>
	    <h3><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
	        <?php echo esc_html__( 'Title', 'homesweet' ); ?>
	    </label></h3>

	    <input  class="widefat"
	            id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
	            name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
	            type="text"
	            value="<?php echo esc_attr( $title ); ?>">
	</p>

	<!-- BUTTON TEXT -->
	<p>
	    <h3><label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>">
	        <?php echo esc_html__( 'Button text', 'homesweet' ); ?>
	    </label></h3>

	    <input  class="widefat"
	            id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"
	            name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>"
	            type="text"
	            value="<?php echo esc_attr( $button_text ); ?>">
	</p>

	<!-- INPUT TITLES -->
	<h3><label><?php echo esc_html__( 'Input titles', 'homesweet' ); ?></label></h3>

	<ul>
		<li>
			<label>
				<input  type="radio"
				        class="radio"
				        value="labels"
						<?php echo ( empty( $input_titles ) || 'labels' == $input_titles ) ? 'checked="checked"' : ''; ?>
				        id="<?php echo esc_attr( $this->get_field_id( 'input_titles' ) ); ?>"
				        name="<?php echo esc_attr( $this->get_field_name( 'input_titles' ) ); ?>">
					<?php echo esc_html__( 'Labels', 'homesweet' ); ?>
			</label>
		</li>

		<li>
			<label>
				<input  type="radio"
				        class="radio"
				        value="placeholders"
						<?php echo ( 'placeholders' == $input_titles ) ? 'checked="checked"' : ''; ?>
				        id="<?php echo esc_attr( $this->get_field_id( 'input_titles' ) ); ?>"
				        name="<?php echo esc_attr( $this->get_field_name( 'input_titles' ) ); ?>">
				<?php echo esc_html__( 'Placeholders', 'homesweet' ); ?>
			</label>
		</li>
	</ul>

	<p>
	    <h3><label><?php echo esc_html__( 'Layout Type', 'homesweet' ); ?></label></h3>

      	<select class="widefat"
	            id="<?php echo esc_attr( $this->get_field_id( 'layout_type' ) ); ?>"
	            name="<?php echo esc_attr( $this->get_field_name( 'layout_type' ) ); ?>">
        	<option value="horizontal1" <?php echo ( empty( $layout_type ) || 'horizontal1' == $layout_type ) ? 'selected="selected"' : ''; ?>><?php echo esc_html__( 'Horizontal 1', 'homesweet' ); ?></option>
        	<option value="horizontal2" <?php echo ( empty( $layout_type ) || 'horizontal2' == $layout_type ) ? 'selected="selected"' : ''; ?>><?php echo esc_html__( 'Horizontal 2', 'homesweet' ); ?></option>
        	<option value="vertical" <?php echo ( empty( $layout_type ) || 'vertical' == $layout_type ) ? 'selected="selected"' : ''; ?>><?php echo esc_html__( 'Vertical', 'homesweet' ); ?></option>
        </select>
	</p>

	<p>
	    <h3><label for="<?php echo esc_attr( $this->get_field_id( 'price_min' ) ); ?>">
	        <?php echo esc_html__( 'Price Min', 'homesweet' ); ?>
	    </label></h3>

	    <input  class="widefat"
	            id="<?php echo esc_attr( $this->get_field_id( 'price_min' ) ); ?>"
	            name="<?php echo esc_attr( $this->get_field_name( 'price_min' ) ); ?>"
	            type="text"
	            value="<?php echo esc_attr( $price_min ); ?>">
	</p>

	<p>
	    <h3><label for="<?php echo esc_attr( $this->get_field_id( 'price_max' ) ); ?>">
	        <?php echo esc_html__( 'Price Max', 'homesweet' ); ?>
	    </label></h3>

	    <input  class="widefat"
	            id="<?php echo esc_attr( $this->get_field_id( 'price_max' ) ); ?>"
	            name="<?php echo esc_attr( $this->get_field_name( 'price_max' ) ); ?>"
	            type="text"
	            value="<?php echo esc_attr( $price_max ); ?>">
	</p>
	<hr>

	<h3><?php echo esc_html__('Default Filter Fields', 'homesweet'); ?></h3>
	<ul class="realia-filter-fields realia-default-filter-fields">
		<?php $fields = Realia_Filter::get_fields(); ?>

		<?php if ( ! empty( $instance['sort'] ) ) : ?>
			<?php
			$keys = explode( ',', $instance['sort'] );
			$filtered_keys = array_filter( $keys );
			$fields = array_replace( array_flip( $filtered_keys ), $fields );
			?>
		<?php endif; ?>

		<input type="hidden"
		       value="<?php echo esc_attr( $sort ); ?>"
		       id="<?php echo esc_attr( $this->get_field_id( 'sort' ) ); ?>"
		       name="<?php echo esc_attr( $this->get_field_name( 'sort' ) ); ?>" value="<?php echo esc_attr( $sort ); ?>">

		<?php foreach ( $fields as $key => $value ) : ?>
			<li data-field-id="<?php echo esc_attr( $key ); ?>" <?php if ( ! empty( $instance[ 'hide_' . $key ] ) ) : ?>class="invisible"<?php endif; ?>>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'hide_' . $key ) ); ?>">
						<?php echo esc_attr( $value ); ?>
					</label>

					<span class="visibility">
						<input 	type="checkbox"
					            class="checkbox field-visibility"
								<?php echo ! empty( $instance[ 'hide_'. $key ] ) ? 'checked="checked"' : ''; ?>
					            name="<?php echo esc_attr( $this->get_field_name( 'hide_' . $key ) ); ?>">

						<i class="dashicons dashicons-visibility"></i>
					</span>
				</p>
			</li>
		<?php endforeach ?>
	</ul>

	<p>
		<h3><label><?php echo esc_html__( 'Show Advance Filter Fields', 'homesweet' ); ?></label></h3>
		<label>
			<input type="checkbox" class="checkbox field-visibility show_adv_fields"
					<?php echo trim(! empty( $instance['show_adv_fields'] ) ? 'checked="checked"' : ''); ?>
		            name="<?php echo esc_attr( $this->get_field_name( 'show_adv_fields' ) ); ?>">
	        <?php echo esc_html__( 'Show Advance Filter Fields', 'homesweet' ); ?>
	    </label>
	</p>
	<hr>
	<div class="realia-advance-filter-fields-wrapper">
		<h3><?php echo esc_html__('Advance Filter Fields', 'homesweet'); ?></h3>
		<ul class="realia-filter-fields realia-advance-filter-fields">
			<?php $fields = Realia_Filter::get_fields(); ?>

			<?php if ( ! empty( $instance['sort_adv'] ) ) : ?>
				<?php
				$keys = explode( ',', $instance['sort_adv'] );
				$filtered_keys = array_filter( $keys );
				$fields = array_replace( array_flip( $filtered_keys ), $fields );
				?>
			<?php endif; ?>

			<input type="hidden"
			       value="<?php echo esc_attr( $sort_adv ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'sort_adv' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'sort_adv' ) ); ?>" value="<?php echo esc_attr( $sort_adv ); ?>">

			<?php foreach ( $fields as $key => $value ) : ?>
				<li data-field-id="<?php echo esc_attr( $key ); ?>" <?php if ( ! empty( $instance[ 'hide_adv_' . $key ] ) ) : ?>class="invisible"<?php endif; ?>>
					<p>
						<label for="<?php echo esc_attr( $this->get_field_id( 'hide_adv_' . $key ) ); ?>">
							<?php echo esc_attr( $value ); ?>
						</label>

						<span class="visibility">
							<input type="checkbox"
						            class="checkbox field-visibility"
									<?php echo ! empty( $instance[ 'hide_adv_'. $key ] ) ? 'checked="checked"' : ''; ?>
						            name="<?php echo esc_attr( $this->get_field_name( 'hide_adv_' . $key ) ); ?>">

							<i class="dashicons dashicons-visibility"></i>
						</span>
						
					</p>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		var self = $("body #filter-property-<?php echo esc_attr($_id); ?>");

		$('.realia-default-filter-fields', self).each(function() {
			var el = $(this);

			el.sortable({
				update: function(event, ui) {
					var data = el.sortable('toArray', {
						attribute: 'data-field-id'
					});

					$('#<?php echo esc_attr( $this->get_field_id( 'sort' ) ); ?>').attr('value', data);
				}
			});

			$(this).find('input[type=checkbox]').on('change', function() {
				if ($(this).is(':checked')) {
					$(this).closest('li').addClass('invisible');
				} else {
					$(this).closest('li').removeClass('invisible');
				}
			});
		});

		$('.realia-advance-filter-fields', self).each(function() {
			var el = $(this);

			el.sortable({
				update: function(event, ui) {
					var data = el.sortable('toArray', {
						attribute: 'data-field-id'
					});

					$('#<?php echo esc_attr( $this->get_field_id( 'sort_adv' ) ); ?>').attr('value', data);
				}
			});

			$(this).find('input[type=checkbox]').on('change', function() {
				if ($(this).is(':checked')) {
					$(this).closest('li').addClass('invisible');
				} else {
					$(this).closest('li').removeClass('invisible');
				}
			});
		});
		$('.show_adv_fields', self).on('change', function() {
			if ($(this).is(':checked')) {
				$('.realia-advance-filter-fields-wrapper', self).show();
			} else {
				$('.realia-advance-filter-fields-wrapper', self).hide();
			}
		});
		if ( $('.show_adv_fields', self).is(':checked') ) {
			$('.realia-advance-filter-fields-wrapper', self).show();
		} else {
			$('.realia-advance-filter-fields-wrapper', self).hide();
		}
	});
</script>
