<?php if ( homesweet_get_config('show_searchform') ): ?>

	<div class="apus-search-form">
		<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
		  	<div class="input-group">
		  		<input type="text" placeholder="<?php esc_html_e( 'Search', 'homesweet' ); ?>" name="s" class="apus-search form-control"/>
				<span class="input-group-btn">
					<button type="submit" class="button-search btn"><i class="fa fa-search"></i></button>
				</span>
		  	</div>
		  	<?php if ( defined('HOMESWEET_REALIA_ACTIVED') ) { ?>
				<input type="hidden" name="post_type" value="property" class="post_type" />
			<?php } ?>
		</form>
	</div>
<?php endif; ?>