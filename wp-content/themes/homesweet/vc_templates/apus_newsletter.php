<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

?>
<div class="widget widget-newletter <?php echo esc_attr($el_class).' '.(isset($style) ? esc_attr($style) : ''); ?> <?php echo ($title != '') ? 'hastitle' : ''; ?>" >
    <div class="left-info">
	    <?php if ($title!=''): ?>
	        <h3 class="widget-title">
	            <span><?php echo esc_attr( $title ); ?></span>
	        </h3>
	    <?php endif; ?>
	    <?php if (!empty($description)) { ?>
			<p class="widget-description">
				<?php echo trim( $description ); ?>
			</p>
		<?php } ?>
    </div>
    <div class="widget-content"> 
		<?php
			if ( function_exists( 'mc4wp_show_form' ) ) {
			  	try {
			  	    $form = mc4wp_get_form(); 
					mc4wp_show_form( $form->ID );
				} catch( Exception $e ) {
				 	esc_html_e( 'Please create a newsletter form from Mailchip plugins', 'homesweet' );	
				}
			}
		?>
	</div>
</div>