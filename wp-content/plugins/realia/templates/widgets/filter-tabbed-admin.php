<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
$input_titles = ! empty( $instance['input_titles'] ) ? $instance['input_titles'] : '';
$classes = ! empty( $instance['classes'] ) ? $instance['classes'] : '';
?>

<!-- TITLE -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		<?php echo __( 'Title', 'realia' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $title ); ?>">
</p>

<!-- BUTTON TEXT -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>">
		<?php echo __( 'Button text', 'realia' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $button_text ); ?>">
</p>

<!-- INPUT TITLES -->
<label><?php echo __( 'Input titles', 'realia' ); ?></label>

<ul>
	<li>
		<label>
			<input  type="radio"
			        class="radio"
			        value="labels"
				<?php echo ( empty( $input_titles ) || 'labels' == $input_titles ) ? 'checked="checked"' : ''; ?>
			        id="<?php echo esc_attr( $this->get_field_id( 'input_titles' ) ); ?>"
			        name="<?php echo esc_attr( $this->get_field_name( 'input_titles' ) ); ?>">
			<?php echo __( 'Labels', 'realia' ); ?>
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
			<?php echo __( 'Placeholders', 'realia' ); ?>
		</label>
	</li>
</ul>

<!-- CLASSES -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'classes' ) ); ?>">
		<?php echo __( 'Classes', 'realia' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'classes' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'classes' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $classes ); ?>">
	<br>
	<small><?php echo __( 'Additional classes e.g. <i>transparent-background map-overlay</i>', 'realia' ); ?></small>
</p>


<hr>

<?php
	$fields = Realia_Filter::get_fields();
	if( array_key_exists( 'contract', $fields ) ) {
		unset( $fields['contract'] );
	}
?>

<?php foreach( Realia_Post_Type_Property::contract_options() as $contract_key => $contract_value ): ?>
	<h3><?php echo __( 'Fields', 'realia' ) . ': ' . $contract_value; ?></h3>

	<?php $contract_key = strtolower( $contract_key ); ?>
	<?php $field_id = 'sort_' . $contract_key; ?>
	<?php $sort = ! empty( $instance[ $field_id ] ) ? $instance[ $field_id ] : ''; ?>

	<input type="hidden"
		   value="<?php echo esc_attr( $sort ); ?>"
		   id="<?php echo esc_attr( $this->get_field_id( $field_id ) ); ?>"
		   name="<?php echo esc_attr( $this->get_field_name( $field_id ) ); ?>">

	<ul class="realia-filter-tabbed-fields"  data-sort-field="<?php echo esc_attr( $this->get_field_id( $field_id ) ); ?>">
		<?php if ( ! empty( $sort ) ) : ?>
			<?php
			$keys = explode( ',', $sort );
			$filtered_keys = array_filter( $keys );
			$fields = array_replace( array_flip( $filtered_keys ), $fields );
			?>
		<?php endif; ?>

		<?php foreach ( $fields as $key => $value ) : ?>
			<?php $hide_field_id = $contract_key . '_hide_' . $key; ?>

			<li data-field-id="<?php echo esc_attr( $key ); ?>" <?php if ( ! empty( $instance[ $hide_field_id ] ) ) : ?>class="invisible"<?php endif; ?>>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( $hide_field_id ) ); ?>">
						<?php echo esc_attr( $value ); ?>
					</label>

				<span class="visibility">
					<input 	type="checkbox"
							  class="checkbox field-visibility"
						<?php echo ! empty( $instance[ $hide_field_id ] ) ? 'checked="checked"' : ''; ?>
							  name="<?php echo esc_attr( $this->get_field_name( $hide_field_id ) ); ?>">

					<i class="dashicons dashicons-visibility"></i>
				</span>
				</p>
			</li>
		<?php endforeach ?>
	</ul>
<?php endforeach; ?>


<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.widget .realia-filter-tabbed-fields').each(function() {
			var el = $(this);

			el.sortable({
				update: function(event, ui) {
					var data = el.sortable('toArray', {
						attribute: 'data-field-id'
					});
					$('#' + $(this).data('sort-field')).attr('value', data);
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
	});
</script>
