<?php
/**
 *
 * Search form.
 * @since 1.0.0
 * @version 1.0.0
 *
 */
?>
<div class="widget-search">
	<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
		<div class="input-group">
			<input type="text" placeholder="<?php esc_html_e( 'Search', 'homesweet' ); ?>" name="s" class="form-control"/>
			<span class="input-group-btn"> <button type="submit" class="btn"><i class="ion-ios-search"></i> </span>
			<?php if ( defined('HOMESWEET_REALIA_ACTIVED') ) { ?>
				<input type="hidden" name="post_type" value="property" class="post_type" />
			<?php } ?>
		</div>
	</form>
</div>