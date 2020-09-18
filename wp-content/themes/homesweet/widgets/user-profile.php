<?php
extract( $args );
extract( $instance );

$output = '';

$atts['title'] = '';
if ($nav_menu) {
	$term = get_term_by( 'slug', $nav_menu, 'nav_menu' );
	if ( !empty($term) ) {
		$atts['nav_menu'] = $term->term_id;
	}
}
if ( is_user_logged_in() ) {
	$output = '<div class="apus_user_profile">';
	if ( $enable_short_info ) {
		$user_id = get_current_user_id();
		$user = get_userdata( $user_id );
		$changepass_page_id = get_theme_mod('realia_general_password_page', null);

		$output .= '<div class="profile-header">';
			$output .= '<div class="media">';
				$output .= '<div class="media-left media-middle profile-avarta">' . get_avatar($user_id, 80) . '</div>';
				$output .= '<div class="media-body media-middle profile-info">' . '<h3>'.$user->data->display_name .'</h3>' . '<a href="'.esc_url(get_permalink($changepass_page_id)).'">'.esc_html__('Change Password', 'homesweet').'</a></div>';
			$output .= '</div>';
		$output .= '</div>';
	}
	
	$type = 'WP_Nav_Menu_Widget';
	$args = array();
	global $wp_widget_factory;
	// to avoid unwanted warnings let's check before using widget
	if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
		ob_start();
		the_widget( $type, $atts, $args );
		$output .= ob_get_clean();

		$output .= '</div>';

		echo trim($output);
	} else {
		echo trim($this->debugComment( 'Widget ' . esc_attr( $type ) . 'Not found in : widget custom_menu' ));
	}
}