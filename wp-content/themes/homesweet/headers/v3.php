<header id="apus-header" class="apus-header header-v1 header-v3 hidden-sm hidden-xs" role="banner">
    <div class="header-middle">
        <div class="container">
            <div class="pull-left">
                <div class="logo-in-theme ">
                    <?php get_template_part( 'page-templates/parts/logo' ); ?>
                </div>
            </div>
            <div class="pull-right">
                <?php if(is_active_sidebar('header-infor-sidebar')) { ?>
                    <div class="header-infor pull-left">
                        <?php dynamic_sidebar( 'header-infor-sidebar' ); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="<?php echo (homesweet_get_config('keep_header') ? 'main-sticky-header-wrapper' : ''); ?>">
        <div class="<?php echo (homesweet_get_config('keep_header') ? 'main-sticky-header' : ''); ?>">
            <div class="header-bottom">
                <div class="container">
                    <div class="bottom-inner clearfix">
                        <?php if ( has_nav_menu( 'primary' ) ) : ?>
                            <div class="main-menu pull-left">
                                <nav data-duration="400" class="hidden-xs hidden-sm apus-megamenu slide animate navbar p-static" role="navigation">
                                <?php   $args = array(
                                        'theme_location' => 'primary',
                                        'container_class' => 'collapse navbar-collapse',
                                        'menu_class' => 'nav navbar-nav megamenu',
                                        'fallback_cb' => '',
                                        'menu_id' => 'primary-menu',
                                        'walker' => new Homesweet_Nav_Menu()
                                    );
                                    wp_nav_menu($args);
                                ?>
                                </nav>
                            </div>
                        <?php endif; ?>
                        <div class="pull-right">
                            <?php if ( homesweet_get_config('show_login_register', true) ) { ?>
                                <div class="pull-left">
                                    <?php if (is_user_logged_in()) : ?>
                                        <?php if ( has_nav_menu( 'authenticated' ) ) : ?>
                                        <div class="btn-group">
                                            <?php
                                            $user_id = get_current_user_id();
                                            $user = get_userdata( $user_id );
                                            ?>
                                            <button class="btn btn-setting dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo esc_attr($user->data->display_name); ?>" data-hover="dropdown" data-delay="100">
                                                <div class="profile-menus">
                                                    <div class="profile-avarta pull-left"><?php echo get_avatar($user_id, 32); ?></div>
                                                    <div class="profile-info pull-left">
                                                        <span><?php echo esc_html($user->data->display_name); ?></span>
                                                        <i class="icon-ap_down"></i>
                                                    </div>
                                                </div>
                                                
                                            </button>
                                            <div class="user-menu dropdown-menu dropdown-menu-right dropdown-theme">
                                                <nav data-duration="400" class="hidden-xs hidden-sm slide animate navbar" role="navigation">
                                                <?php   $args = array(
                                                        'theme_location' => 'authenticated',
                                                        'container_class' => 'collapse navbar-collapse',
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
                                        <nav data-duration="400" class="slide animate navbar no-margin" role="navigation">
                                            <div class="collapse navbar-collapse">
                                                <ul id="login" class="login">
                                                    <li> <img src="<?php echo esc_url_raw( get_template_directory_uri().'/images/login.png'); ?>" alt=""> <a href="#customer_login"><?php esc_html_e('Login', 'homesweet'); ?></a></li>
                                                    <li> <img src="<?php echo esc_url_raw( get_template_directory_uri().'/images/register.png'); ?>" alt=""><a href="#customer_register"><?php esc_html_e('Register', 'homesweet'); ?></a></li>
                                                </ul>
                                            </div>
                                        </nav>
                                    <?php endif; ?>
                                </div>
                            <?php } ?>
                            <?php
                                if ( homesweet_get_config('show_create_property_btn', 1) && defined('HOMESWEET_REALIA_ACTIVED') ) {
                                $create_page_id = get_theme_mod( 'realia_submission_create_page', null );
                            ?>
                                <div class="pull-right">
                                    <a class="btn btn-submit" href="<?php echo esc_url(get_permalink($create_page_id)); ?>"><i class="ion-ios-plus-empty"></i> <?php echo esc_html__('Add Property','homesweet'); ?></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>