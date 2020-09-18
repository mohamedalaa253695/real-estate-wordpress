<?php

if ( !function_exists ('homesweet_custom_styles') ) {
	function homesweet_custom_styles() {
		global $post;	
		ob_start();	
		?>
		
			/* check main color */ 
			<?php if ( homesweet_get_config('main_color') != "" ) : ?>

				/* seting background main */
				.bg-theme
				{
					background: <?php echo esc_html( homesweet_get_config('main_color') ) ?> ;
				}
				/* setting color*/
				.widget .widget-title, .widget .widgettitle, .widget .widget-heading,
				.widget-text-heading .title{
					color: <?php echo esc_html( homesweet_get_config('main_color') ) ?>;
				}
				.apus-footer .dark .widget-title, .apus-footer .dark .widgettitle, .apus-footer .dark .widget-heading,.apus-footer .dark .widget-title span,
				.widget-newletter.style2 .widget-title span,
				.text-theme
				{
					color: <?php echo esc_html( homesweet_get_config('main_color') ) ?> !important;
				}
				/* setting border color*/
				.border-theme{
					border-color: <?php echo esc_html( homesweet_get_config('main_color') ) ?> ;
				}
			<?php endif; ?>

			/* check second color */ 
			<?php if ( homesweet_get_config('second_color') != "" ) : ?>

				/* seting background main */
				.add-fix-top,
				.navbar-nav.megamenu > li::before,
				.bg-theme-second,.btn-theme-second
				{
					background: <?php echo esc_html( homesweet_get_config('second_color') ) ?>;
				}
				/* setting color*/
				.widget-social .social > li a,
				.widget-text-heading.small .title{
					color: <?php echo esc_html( homesweet_get_config('second_color') ) ?>;
				}
				.widget-filter-form .filter-amenities-title i,
				.apus-footer .properties-list-small .property-box-price,
				.text-second,.second-color
				{
					color: <?php echo esc_html( homesweet_get_config('second_color') ) ?> !important;
				}
				/* setting border color*/
				.btn-theme-second
				{
					border-color: <?php echo esc_html( homesweet_get_config('second_color') ) ?>;
				}

			<?php endif; ?>
			

			<?php if ( homesweet_get_config('button_main_color') != "" ) : ?>
				.btn.btn-purple,
				.btn.btn-theme{
					background: <?php echo esc_html( homesweet_get_config('button_main_color') ) ?>;
				}
				.btn.btn-purple,
				.btn.btn-theme{
					border-color: <?php echo esc_html( homesweet_get_config('button_main_color') ) ?>;
				}
			<?php endif; ?>
			<?php if ( homesweet_get_config('button_hover_main_color') != "" ) : ?>
				.btn.btn-purple:hover,.btn.btn-purple:active,.btn.btn-purple:focus,
				.btn.btn-theme:hover,.btn.btn-theme:active,.btn.btn-theme:focus{
					background: <?php echo esc_html( homesweet_get_config('button_hover_main_color') ) ?>;
				}
				.btn.btn-purple:hover,.btn.btn-purple:active,.btn.btn-purple:focus,
				.btn.btn-theme:hover,.btn.btn-theme:active,.btn.btn-theme:focus{
					border-color: <?php echo esc_html( homesweet_get_config('button_hover_main_color') ) ?>;
				}
			<?php endif; ?>

			/* Typo */
			<?php
				$main_font = homesweet_get_config('main_font');
				if ( !empty($main_font) ) :
			?>
				/* seting background main */
				body, p
				{
					<?php if ( isset($main_font['font-family']) && $main_font['font-family'] ) { ?>
						font-family: <?php echo esc_html( $main_font['font-family'] ) ?>;
					<?php } ?>
					<?php if ( isset($main_font['font-weight']) && $main_font['font-weight'] ) { ?>
						font-weight: <?php echo esc_html( $main_font['font-weight'] ) ?>;
					<?php } ?>
					<?php if ( isset($main_font['font-style']) && $main_font['font-style'] ) { ?>
						font-style: <?php echo esc_html( $main_font['font-style'] ) ?>;
					<?php } ?>
					<?php if ( isset($main_font['font-size']) && $main_font['font-size'] ) { ?>
						font-size: <?php echo esc_html( $main_font['font-size'] ) ?>;
					<?php } ?>
					<?php if ( isset($main_font['line-height']) && $main_font['line-height'] ) { ?>
						line-height: <?php echo esc_html( $main_font['line-height'] ) ?>;
					<?php } ?>
					<?php if ( isset($main_font['color']) && $main_font['color'] ) { ?>
						color: <?php echo esc_html( $main_font['color'] ) ?>;
					<?php } ?>
				}
				
			<?php endif; ?>

			<?php
				$second_font = homesweet_get_config('second_font');
				if ( !empty($second_font) ) :
			?>
				/* seting background main */
				h1,h2,h3,h4,h5,h6,.widget-title,.widgettitle
				{
					<?php if ( isset($second_font['font-family']) && $second_font['font-family'] ) { ?>
						font-family: <?php echo esc_html( $second_font['font-family'] ) ?>;
					<?php } ?>
					<?php if ( isset($second_font['font-weight']) && $second_font['font-weight'] ) { ?>
						font-weight: <?php echo esc_html( $second_font['font-weight'] ) ?>;
					<?php } ?>
					<?php if ( isset($second_font['font-style']) && $second_font['font-style'] ) { ?>
						font-style: <?php echo esc_html( $second_font['font-style'] ) ?>;
					<?php } ?>
					<?php if ( isset($second_font['font-size']) && $second_font['font-size'] ) { ?>
						font-size: <?php echo esc_html( $second_font['font-size'] ) ?>;
					<?php } ?>
					<?php if ( isset($second_font['line-height']) && $second_font['line-height'] ) { ?>
						line-height: <?php echo esc_html( $second_font['line-height'] ) ?>;
					<?php } ?>
					<?php if ( isset($second_font['color']) && $second_font['color'] ) { ?>
						color: <?php echo esc_html( $second_font['color'] ) ?>;
					<?php } ?>
				}
				
			<?php endif; ?>

			/* Custom CSS */
			<?php if ( homesweet_get_config('custom_css') != "" ) : ?>
				<?php echo homesweet_get_config('custom_css') ?>
			<?php endif; ?>

	<?php
		$content = ob_get_clean();
		$content = str_replace(array("\r\n", "\r"), "\n", $content);
		$lines = explode("\n", $content);
		$new_lines = array();
		foreach ($lines as $i => $line) {
			if (!empty($line)) {
				$new_lines[] = trim($line);
			}
		}
		
		return implode($new_lines);
	}
}
