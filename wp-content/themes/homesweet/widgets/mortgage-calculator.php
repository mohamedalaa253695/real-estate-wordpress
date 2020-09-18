<?php
extract( $args );
extract( $instance );

$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo ($before_title)  . trim( $title ) . $after_title;
}

$currency_index = 0;
$currencies = get_theme_mod( 'realia_currencies' );
$currency_symbol = ! empty( $currencies[ $currency_index ]['symbol'] ) ? $currencies[ $currency_index ]['symbol'] : '$';

?>

<div class="apus-mortgage-calculator">
	<div class="form-group">
		<label for="apus_mortgage_property_price"><?php esc_html_e('Property Price', 'homesweet'); ?></label>
		<input class="form-control" id="apus_mortgage_property_price" type="text" placeholder="<?php echo esc_attr($currency_symbol); ?>">
	</div>
	<div class="form-group">
		<label for="apus_mortgage_deposit"><?php esc_html_e('Deposit', 'homesweet'); ?></label>
		<input class="form-control" id="apus_mortgage_deposit" type="text" placeholder="<?php echo esc_attr($currency_symbol); ?>">
	</div>
	<div class="form-group">
		<label for="apus_mortgage_interest_rate"><?php esc_html_e('Interest Rate (%)', 'homesweet'); ?></label>
		<input class="form-control" id="apus_mortgage_interest_rate" type="text" placeholder="<?php esc_html_e('%', 'homesweet'); ?>">
	</div>
	<div class="form-group">
		<label for="apus_mortgage_term_years"><?php esc_html_e('Loan Term (Years)', 'homesweet'); ?></label>
		<input class="form-control" id="apus_mortgage_term_years" type="text" placeholder="<?php esc_html_e('Year', 'homesweet'); ?>">
	</div>
	<button id="btn_mortgage_get_results" class="btn btn-purple btn-block"><?php esc_html_e('Calculate', 'homesweet'); ?></button>
	<div class="apus_mortgage_results"></div>
</div>