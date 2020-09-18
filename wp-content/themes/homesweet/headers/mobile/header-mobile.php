<div id="apus-header-mobile" class="header-mobile hidden-lg hidden-md clearfix">
    <div class="container">
        <?php
            $logo = homesweet_get_config('media-mobile-logo');
        ?>

        <?php if( isset($logo['url']) && !empty($logo['url']) ): ?>
            <div class="logo pull-left">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                    <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                </a>
            </div>
        <?php else: ?>
            <div class="logo logo-theme  pull-left">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                    <img src="<?php echo esc_url_raw( get_template_directory_uri().'/images/logo1.png'); ?>" alt="<?php bloginfo( 'name' ); ?>">
                </a>
            </div>
        <?php endif; ?>
        <div class="pull-right header-mobile-right">
            <button data-toggle="offcanvas" class="btn btn-offcanvas btn-toggle-canvas offcanvas pull-left" type="button">
               <i class="fa fa-bars"></i>
            </button>
            <?php if ( homesweet_get_config('show_login_register', true) ) { ?>
                <div class="pull-left">
                    <?php if (is_user_logged_in()) : ?>
                        <?php if ( has_nav_menu( 'authenticated' ) ) : ?>
                        <div class="btn-group">
                            <button class="btn btn-setting dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="icon-ap_settings" aria-hidden="true"></i></button>
                            <div class="user-menu dropdown-menu dropdown-menu-right dropdown-theme">
                                <nav data-duration="400" class=" slide animate navbar" role="navigation">
                                <?php   $args = array(
                                        'theme_location' => 'authenticated',
                                        'container_class' => '',
                                        'menu_class' => 'nav navbar-nav menu',
                                        'fallback_cb' => '',
                                        'menu_id' => 'authenticated-menu'
                                    );
                                    wp_nav_menu($args);
                                ?>
                                </nav>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="btn-group">
                            <button class="btn btn-setting dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="icon-ap_settings" aria-hidden="true"></i></button>
                            <div class="user-menu dropdown-menu dropdown-menu-right dropdown-theme">
                                <ul class="nav navbar-nav menu login">
                                    <li><a href="#customer_login"><?php esc_html_e('LOGIN', 'homesweet'); ?></a></li>
                                    <li><a href="#customer_register"><?php esc_html_e('REGISTER', 'homesweet'); ?></a></li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>