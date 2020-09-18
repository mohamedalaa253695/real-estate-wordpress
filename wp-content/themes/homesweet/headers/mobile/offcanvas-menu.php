<div id="apus-mobile-menu" class="apus-offcanvas hidden-lg hidden-md"> 
    <div class="apus-offcanvas-body">
        <div class="offcanvas-head bg-primary">
            <a class="btn-toggle-canvas" data-toggle="offcanvas">
                <i class="fa fa-close"></i> <strong><?php esc_html_e( 'MENU', 'homesweet' ); ?></strong>
            </a>
        </div>

        <nav class="navbar navbar-offcanvas navbar-static" role="navigation">
            <?php
                $args = array(
                    'theme_location' => 'primary',
                    'container_class' => 'navbar-collapse navbar-offcanvas-collapse',
                    'menu_class' => 'nav navbar-nav',
                    'fallback_cb' => '',
                    'menu_id' => 'main-mobile-menu',
                    'walker' => new Homesweet_Mobile_Menu()
                );
                wp_nav_menu($args);
            ?>
        </nav>

    </div>
</div>
<div class="over-dark"></div>