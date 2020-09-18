<?php 

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
?>
<div class="widget widget-search-saved <?php echo esc_attr($el_class); ?>">
<?php
if ( class_exists('Homesweet_Realia_Save_Search') ) {
	if ( is_user_logged_in() ) {
		$user_id = get_current_user_id();
		$datas = get_the_author_meta( 'save_search_info', $user_id );
		if ( !empty($datas) ) {
			foreach ($datas as $key => $value) {
				if ( !empty($value['title']) ) {
					$render = Homesweet_Realia_Save_Search::render_data($value);
				?>
				<div class="search-page-item" id="search-save-<?php echo esc_attr($key); ?>">
					<div class="heading-wrapper">
						<h3>
							<?php $url = isset($render['url']) ? $render['url'] : ''; ?>
							<a href="<?php echo esc_url($url); ?>"><?php echo trim($value['title']); ?></a>
							<a href="#search-save-<?php echo esc_attr($key); ?>" class="apus-search-save-remove" data-id="<?php echo esc_attr( $key ); ?>">
								<i class=" icon-ap_close" aria-hidden="true"></i>
							</a>
						</h3>
						
					</div>
					<?php if ( !empty($render['filters']) ) { ?>
						<ul class="content-wrapper">
							<li><span><?php echo esc_html__('Search Keywords:', 'homesweet'); ?></span></li>
							<?php foreach ($render['filters'] as $value) { ?>
								<li>
									<span><?php echo trim($value); ?></span>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
				</div>
				<?php
				}
			}
		} else {
			?>
			<div class="msg"><?php esc_html_e('Have not any search page saved', 'homesweet'); ?></div>
			<?php
		}
	} else {
		?>
		<a href="<?php echo esc_url( get_permalink( get_theme_mod('realia_general_login_required_page', null) ) ); ?>">
	        <?php esc_html_e( 'Please login to view this page', 'homesweet' ); ?>
	    </a>
		<?php
	}
}
?>
</div>