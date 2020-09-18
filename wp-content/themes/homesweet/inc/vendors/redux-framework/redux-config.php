<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if (!class_exists('Homesweet_Redux_Framework_Config')) {

    class Homesweet_Redux_Framework_Config
    {
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct()
        {
            if (!class_exists('ReduxFramework')) {
                return;
            }
            add_action('init', array($this, 'initSettings'), 10);
        }

        public function initSettings()
        {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        public function setSections()
        {
            global $wp_registered_sidebars;
            $sidebars = array();

            if ( !empty($wp_registered_sidebars) ) {
                foreach ($wp_registered_sidebars as $sidebar) {
                    $sidebars[$sidebar['id']] = $sidebar['name'];
                }
            }
            $columns = array( '1' => esc_html__('1 Column', 'homesweet'),
                '2' => esc_html__('2 Columns', 'homesweet'),
                '3' => esc_html__('3 Columns', 'homesweet'),
                '4' => esc_html__('4 Columns', 'homesweet'),
                '6' => esc_html__('6 Columns', 'homesweet')
            );
            
            $general_fields = array();
            if ( !function_exists( 'wp_site_icon' ) ) {
                $general_fields[] = array(
                    'id' => 'media-favicon',
                    'type' => 'media',
                    'title' => esc_html__('Favicon Upload', 'homesweet'),
                    'subtitle' => esc_html__('Upload a 16px x 16px .png or .gif image that will be your favicon.', 'homesweet'),
                );
            }
            $general_fields[] = array(
                'id' => 'preload',
                'type' => 'switch',
                'title' => esc_html__('Preload Website', 'homesweet'),
                'default' => true,
            );
            $general_fields[] = array(
                'id' => 'image_lazy_loading',
                'type' => 'switch',
                'title' => esc_html__('Image Lazy Loading', 'homesweet'),
                'default' => true,
            );
            // General Settings Tab
            $this->sections[] = array(
                'icon' => 'el-icon-cogs',
                'title' => esc_html__('General', 'homesweet'),
                'fields' => $general_fields
            );
            
            // Header
            $this->sections[] = array(
                'icon' => 'el el-website',
                'title' => esc_html__('Header', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'media-logo',
                        'type' => 'media',
                        'title' => esc_html__('Logo Upload', 'homesweet'),
                        'subtitle' => esc_html__('Upload a .png or .gif image that will be your logo.', 'homesweet'),
                    ),
                    array(
                        'id' => 'media-mobile-logo',
                        'type' => 'media',
                        'title' => esc_html__('Mobile Logo Upload', 'homesweet'),
                        'subtitle' => esc_html__('Upload a .png or .gif image that will be your logo.', 'homesweet'),
                    ),
                    array(
                        'id' => 'header_type',
                        'type' => 'select',
                        'title' => esc_html__('Header Layout Type', 'homesweet'),
                        'subtitle' => esc_html__('Choose a header for your website.', 'homesweet'),
                        'options' => homesweet_get_header_layouts()
                    ),
                    array(
                        'id' => 'keep_header',
                        'type' => 'switch',
                        'title' => esc_html__('Keep Header', 'homesweet'),
                        'default' => false
                    ),
                    array(
                        'id' => 'show_create_property_btn',
                        'type' => 'switch',
                        'title' => esc_html__('Show Create Property Button', 'homesweet'),
                        'default' => true
                    ),
                    array(
                        'id' => 'show_login_register',
                        'type' => 'switch',
                        'title' => esc_html__('Show Login/Register/Profile', 'homesweet'),
                        'default' => true
                    ),
                )
            );
            // Footer
            $this->sections[] = array(
                'icon' => 'el el-website',
                'title' => esc_html__('Footer', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'footer_type',
                        'type' => 'select',
                        'title' => esc_html__('Footer Layout Type', 'homesweet'),
                        'subtitle' => esc_html__('Choose a footer for your website.', 'homesweet'),
                        'options' => homesweet_get_footer_layouts()
                    ),
                    array(
                        'id' => 'copyright_text',
                        'type' => 'editor',
                        'title' => esc_html__('Copyright Text', 'homesweet'),
                        'default' => 'Powered by Redux Framework.',
                        'required' => array('footer_type','=','')
                    ),
                    array (
                        'title' => esc_html__('Logo Copyright For Footer Default', 'homesweet'),
                        'subtitle' => '<em>'.esc_html__('Logo Copyright of the site.', 'homesweet').'</em>',
                        'id' => 'logo_copyright',
                        'type' => 'media',
                    ),
                    array(
                        'id' => 'back_to_top',
                        'type' => 'switch',
                        'title' => esc_html__('Back To Top Button', 'homesweet'),
                        'subtitle' => esc_html__('Toggle whether or not to enable a back to top button on your pages.', 'homesweet'),
                        'default' => true,
                    ),
                )
            );

            // Blog settings
            $this->sections[] = array(
                'icon' => 'el el-pencil',
                'title' => esc_html__('Blog', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'show_blog_breadcrumbs',
                        'type' => 'switch',
                        'title' => esc_html__('Breadcrumbs', 'homesweet'),
                        'default' => 1
                    ),
                    array (
                        'title' => esc_html__('Breadcrumbs Background Color', 'homesweet'),
                        'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'homesweet').'</em>',
                        'id' => 'blog_breadcrumb_color',
                        'type' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => 'blog_breadcrumb_image',
                        'type' => 'media',
                        'title' => esc_html__('Breadcrumbs Background', 'homesweet'),
                        'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'homesweet'),
                    ),
                )
            );
            // Archive Blogs settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Blog & Post Archives', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'blog_archive_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Layout', 'homesweet'),
                        'subtitle' => esc_html__('Select the variation you want to apply on your store.', 'homesweet'),
                        'options' => array(
                            'main' => array(
                                'title' => esc_html__('Main Only', 'homesweet'),
                                'alt' => esc_html__('Main Only', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                            ),
                            'left-main' => array(
                                'title' => esc_html__('Left - Main Sidebar', 'homesweet'),
                                'alt' => esc_html__('Left - Main Sidebar', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                            ),
                            'main-right' => array(
                                'title' => esc_html__('Main - Right Sidebar', 'homesweet'),
                                'alt' => esc_html__('Main - Right Sidebar', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                            ),
                        ),
                        'default' => 'left-main'
                    ),
                    array(
                        'id' => 'blog_archive_fullwidth',
                        'type' => 'switch',
                        'title' => esc_html__('Is Full Width?', 'homesweet'),
                        'default' => false
                    ),
                    array(
                        'id' => 'blog_archive_left_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Left Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'homesweet'),
                        'options' => $sidebars
                    ),
                    array(
                        'id' => 'blog_archive_right_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Right Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'homesweet'),
                        'options' => $sidebars
                        
                    ),
                    array(
                        'id' => 'blog_display_mode',
                        'type' => 'select',
                        'title' => esc_html__('Display Mode', 'homesweet'),
                        'options' => array(
                            'grid' => esc_html__('Grid Layout', 'homesweet'),
                            'grid-v2' => esc_html__('Grid Version 2 Layout', 'homesweet'),
                            'mansory' => esc_html__('Mansory Layout', 'homesweet'),
                            'list' => esc_html__('List Layout', 'homesweet')
                        ),
                        'default' => 'grid'
                    ),
                    array(
                        'id' => 'blog_columns',
                        'type' => 'select',
                        'title' => esc_html__('Blog Columns', 'homesweet'),
                        'options' => $columns,
                        'default' => 1
                    ),
                    array(
                        'id' => 'blog_item_thumbsize',
                        'type' => 'text',
                        'title' => esc_html__('Thumbnail Size', 'homesweet'),
                        'subtitle' => esc_html__('This featured for the site is using Visual Composer.', 'homesweet'),
                        'desc' => esc_html__('Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) .', 'homesweet'),
                    ),

                )
            );
            // Single Blogs settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Blog', 'homesweet'),
                'fields' => array(
                    
                    array(
                        'id' => 'blog_single_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Archive Blog Layout', 'homesweet'),
                        'subtitle' => esc_html__('Select the variation you want to apply on your store.', 'homesweet'),
                        'options' => array(
                            'main' => array(
                                'title' => esc_html__('Main Only', 'homesweet'),
                                'alt' => esc_html__('Main Only', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                            ),
                            'left-main' => array(
                                'title' => esc_html__('Left - Main Sidebar', 'homesweet'),
                                'alt' => esc_html__('Left - Main Sidebar', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                            ),
                            'main-right' => array(
                                'title' => esc_html__('Main - Right Sidebar', 'homesweet'),
                                'alt' => esc_html__('Main - Right Sidebar', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                            ),
                        ),
                        'default' => 'left-main'
                    ),
                    array(
                        'id' => 'blog_single_fullwidth',
                        'type' => 'switch',
                        'title' => esc_html__('Is Full Width?', 'homesweet'),
                        'default' => false
                    ),
                    array(
                        'id' => 'blog_single_left_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Single Blog Left Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'homesweet'),
                        'options' => $sidebars
                    ),
                    array(
                        'id' => 'blog_single_right_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Single Blog Right Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'homesweet'),
                        'options' => $sidebars
                    ),
                    array(
                        'id' => 'show_blog_social_share',
                        'type' => 'switch',
                        'title' => esc_html__('Show Social Share', 'homesweet'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'show_blog_releated',
                        'type' => 'switch',
                        'title' => esc_html__('Show Releated Posts', 'homesweet'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'number_blog_releated',
                        'type' => 'text',
                        'title' => esc_html__('Number of related posts to show', 'homesweet'),
                        'required' => array('show_blog_releated', '=', '1'),
                        'default' => 3,
                        'min' => '1',
                        'step' => '1',
                        'max' => '20',
                        'type' => 'slider'
                    ),
                    array(
                        'id' => 'releated_blog_columns',
                        'type' => 'select',
                        'title' => esc_html__('Releated Blogs Columns', 'homesweet'),
                        'required' => array('show_blog_releated', '=', '1'),
                        'options' => $columns,
                        'default' => 3
                    ),

                )
            );
            // Agency
            $this->sections[] = array(
                'title' => esc_html__('Agency', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'show_agency_breadcrumbs',
                        'type' => 'switch',
                        'title' => esc_html__('Breadcrumbs', 'homesweet'),
                        'default' => 1
                    ),
                    array (
                        'title' => esc_html__('Breadcrumbs Background Color', 'homesweet'),
                        'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'homesweet').'</em>',
                        'id' => 'agency_breadcrumb_color',
                        'type' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => 'agency_breadcrumb_image',
                        'type' => 'media',
                        'title' => esc_html__('Breadcrumbs Background', 'homesweet'),
                        'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'homesweet'),
                    )
                )
            );
            // Archive settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Agency Archives', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'agency_archive_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Sidebar position', 'homesweet'),
                        'subtitle' => esc_html__('Select the layout you want to apply on your archive agency page.', 'homesweet'),
                        'options' => array(
                            'main' => array(
                                'title' => esc_html__('Main Content', 'homesweet'),
                                'alt' => esc_html__('Main Content', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                            ),
                            'left-main' => array(
                                'title' => esc_html__('Left Sidebar - Main Content', 'homesweet'),
                                'alt' => esc_html__('Left Sidebar - Main Content', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                            ),
                            'main-right' => array(
                                'title' => esc_html__('Main Content - Right Sidebar', 'homesweet'),
                                'alt' => esc_html__('Main Content - Right Sidebar', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                            ),
                        ),
                        'default' => 'left-main'
                    ),
                    array(
                        'id' => 'agency_archive_fullwidth',
                        'type' => 'switch',
                        'title' => esc_html__('Is Full Width?', 'homesweet'),
                        'default' => false
                    ),
                    array(
                        'id' => 'agency_archive_left_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Left Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'homesweet'),
                        'options' => $sidebars
                    ),
                    array(
                        'id' => 'agency_archive_right_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Right Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'homesweet'),
                        'options' => $sidebars
                    ),
                    array(
                        'id' => 'agency_columns',
                        'type' => 'select',
                        'title' => esc_html__('Agency Columns', 'homesweet'),
                        'options' => $columns,
                        'default' => 4
                    ),
                    array(
                        'id' => 'show_agency_agents',
                        'type' => 'switch',
                        'title' => esc_html__('Show Agency Agents', 'homesweet'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'number_agency_agents',
                        'title' => esc_html__('Number agents', 'homesweet'),
                        'default' => 4,
                        'min' => '1',
                        'step' => '1',
                        'max' => '20',
                        'type' => 'slider',
                        'required' => array('show_agency_agents','equals',true),
                    ),
                    array(
                        'id' => 'agent_agency_columns',
                        'type' => 'select',
                        'title' => esc_html__('Columns', 'homesweet'),
                        'options' => $columns,
                        'default' => 4,
                        'required' => array('show_agency_agents','equals',true),
                    ),
                )
            );
            // Agency Page
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Single Agency', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'agency_single_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Sidebar position', 'homesweet'),
                        'subtitle' => esc_html__('Select the layout you want to apply on your Single Product Page.', 'homesweet'),
                        'options' => array(
                            'main' => array(
                                'title' => esc_html__('Main Only', 'homesweet'),
                                'alt' => esc_html__('Main Only', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                            ),
                            'left-main' => array(
                                'title' => esc_html__('Left - Main Sidebar', 'homesweet'),
                                'alt' => esc_html__('Left - Main Sidebar', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                            ),
                            'main-right' => array(
                                'title' => esc_html__('Main - Right Sidebar', 'homesweet'),
                                'alt' => esc_html__('Main - Right Sidebar', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                            ),
                        ),
                        'default' => 'left-main'
                    ),
                    array(
                        'id' => 'agency_single_fullwidth',
                        'type' => 'switch',
                        'title' => esc_html__('Is Full Width?', 'homesweet'),
                        'default' => false
                    ),
                    array(
                        'id' => 'agency_single_left_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Single Product Left Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'homesweet'),
                        'options' => $sidebars
                    ),
                    array(
                        'id' => 'agency_single_right_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Single Product Right Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'homesweet'),
                        'options' => $sidebars
                    ),
                    array(
                        'id' => 'show_agency_social_share',
                        'type' => 'switch',
                        'title' => esc_html__('Show Social Share', 'homesweet'),
                        'default' => 1
                    )

                )
            );
            // Agent
            $this->sections[] = array(
                'title' => esc_html__('Agent', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'show_agent_breadcrumbs',
                        'type' => 'switch',
                        'title' => esc_html__('Breadcrumbs', 'homesweet'),
                        'default' => 1
                    ),
                    array (
                        'title' => esc_html__('Breadcrumbs Background Color', 'homesweet'),
                        'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'homesweet').'</em>',
                        'id' => 'agent_breadcrumb_color',
                        'type' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => 'agent_breadcrumb_image',
                        'type' => 'media',
                        'title' => esc_html__('Breadcrumbs Background', 'homesweet'),
                        'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'homesweet'),
                    )
                )
            );
            // Archive settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Agent Archives', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'agent_archive_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Sidebar position', 'homesweet'),
                        'subtitle' => esc_html__('Select the layout you want to apply on your archive agent page.', 'homesweet'),
                        'options' => array(
                            'main' => array(
                                'title' => esc_html__('Main Content', 'homesweet'),
                                'alt' => esc_html__('Main Content', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                            ),
                            'left-main' => array(
                                'title' => esc_html__('Left Sidebar - Main Content', 'homesweet'),
                                'alt' => esc_html__('Left Sidebar - Main Content', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                            ),
                            'main-right' => array(
                                'title' => esc_html__('Main Content - Right Sidebar', 'homesweet'),
                                'alt' => esc_html__('Main Content - Right Sidebar', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                            ),
                        ),
                        'default' => 'left-main'
                    ),
                    array(
                        'id' => 'agent_archive_fullwidth',
                        'type' => 'switch',
                        'title' => esc_html__('Is Full Width?', 'homesweet'),
                        'default' => false
                    ),
                    array(
                        'id' => 'agent_archive_left_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Left Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'homesweet'),
                        'options' => $sidebars
                    ),
                    array(
                        'id' => 'agent_archive_right_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Right Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'homesweet'),
                        'options' => $sidebars
                    ),
                    array(
                        'id' => 'agent_columns',
                        'type' => 'select',
                        'title' => esc_html__('Agent Columns', 'homesweet'),
                        'options' => $columns,
                        'default' => 4
                    ),
                )
            );
            // Agent Page
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Single Agent', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'agent_single_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Sidebar position', 'homesweet'),
                        'subtitle' => esc_html__('Select the layout you want to apply on your Single Product Page.', 'homesweet'),
                        'options' => array(
                            'main' => array(
                                'title' => esc_html__('Main Only', 'homesweet'),
                                'alt' => esc_html__('Main Only', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                            ),
                            'left-main' => array(
                                'title' => esc_html__('Left - Main Sidebar', 'homesweet'),
                                'alt' => esc_html__('Left - Main Sidebar', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                            ),
                            'main-right' => array(
                                'title' => esc_html__('Main - Right Sidebar', 'homesweet'),
                                'alt' => esc_html__('Main - Right Sidebar', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                            ),
                        ),
                        'default' => 'left-main'
                    ),
                    array(
                        'id' => 'agent_single_fullwidth',
                        'type' => 'switch',
                        'title' => esc_html__('Is Full Width?', 'homesweet'),
                        'default' => false
                    ),
                    array(
                        'id' => 'agent_single_left_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Single Product Left Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'homesweet'),
                        'options' => $sidebars
                    ),
                    array(
                        'id' => 'agent_single_right_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Single Product Right Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'homesweet'),
                        'options' => $sidebars
                    ),
                    array(
                        'id' => 'show_agent_properties',
                        'type' => 'switch',
                        'title' => esc_html__('Show Agent Properties', 'homesweet'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'number_agent_properties',
                        'title' => esc_html__('Number properties', 'homesweet'),
                        'default' => 4,
                        'min' => '1',
                        'step' => '1',
                        'max' => '20',
                        'type' => 'slider',
                        'required' => array('show_agent_properties','equals',true),
                    ),
                    array(
                        'id' => 'property_agent_columns',
                        'type' => 'select',
                        'title' => esc_html__('Columns', 'homesweet'),
                        'options' => $columns,
                        'default' => 4,
                        'required' => array('show_agent_properties','equals',true),
                    ),
                    array(
                        'id' => 'show_agent_contact_form',
                        'type' => 'switch',
                        'title' => esc_html__('Show Agent Contact Form', 'homesweet'),
                        'default' => 1
                    ),
                )
            );
            // Property Global Settings
            $pages = array();
            if ( is_admin() ) {
                $args = array(
                    'sort_order' => 'asc',
                    'sort_column' => 'post_title',
                    'number' => '',
                    'post_type' => 'page',
                    'post_status' => 'publish'
                ); 
                $allpages = get_pages($args);
                if ( !empty($allpages) ) {
                    foreach ($allpages as $page) {
                        $pages[$page->post_name] = $page->post_title;
                    }
                }
            }
            $this->sections[] = array(
                'title' => esc_html__('Property Global Setting', 'homesweet'),
                'fields' => array(
                    array (
                        'id' => 'property_global_settings_favorite',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;"> '.esc_html__('Favorite Settings', 'homesweet').'</h3>',
                    ),
                    array(
                        'id' => 'enable_property_favorite',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Property Favorite?', 'homesweet'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'property_favorite_page_slug',
                        'type' => 'select',
                        'title' => esc_html__('Favorite Page', 'homesweet'),
                        'options' => $pages,
                        'required' => array('enable_property_favorite', 'equals', 1),
                    ),
                    array (
                        'id' => 'property_global_settings_save_search',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;"> '.esc_html__('Save Search Settings', 'homesweet').'</h3>',
                    ),
                    array(
                        'id' => 'enable_property_save_search',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Property Save Search?', 'homesweet'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'save_search_title',
                        'type' => 'text',
                        'title' => esc_html__('Form Title', 'homesweet'),
                        'default' => 'Save Search',
                        'required' => array('enable_property_save_search', 'equals', 1),
                    ),
                    array(
                        'id' => 'save_search_description',
                        'type' => 'textarea',
                        'title' => esc_html__('Form Description', 'homesweet'),
                        'default' => '',
                        'required' => array('enable_property_save_search', 'equals', 1),
                    ),
                )
            );
            // Property Archive settings
            $this->sections[] = array(
                'title' => esc_html__('Property Archives Page', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'property_archive_layout_version',
                        'type' => 'select',
                        'title' => esc_html__('Archive Layout', 'homesweet'),
                        'subtitle' => esc_html__('Choose a layout for archvie, taxonomy page.', 'homesweet'),
                        'options' => array(
                            'default' => esc_html__('Default', 'homesweet'),
                            'half-map' => esc_html__('Half Map', 'homesweet'),
                            'full-map' => esc_html__('Full Map', 'homesweet'),
                        ),
                        'default' => 'default'
                    ),
                    array (
                        'id' => 'property_archive_default_header_top',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;"> '.esc_html__('Top Content Settings', 'homesweet').'</h3>',
                        'required' => array('property_archive_layout_version', 'equals', array('default', 'full-map')),
                    ),
                    array(
                        'id' => 'property_archive_default_header_filter',
                        'type' => 'switch',
                        'title' => esc_html__('Show Filter in Top', 'homesweet'),
                        'default' => true,
                        'required' => array('property_archive_layout_version', 'equals', array('default', 'full-map')),
                    ),
                    array(
                        'id' => 'property_archive_default_header_breadcrumb',
                        'type' => 'switch',
                        'title' => esc_html__('Show Breadcrumb/Title in Top', 'homesweet'),
                        'default' => false,
                        'required' => array('property_archive_layout_version', 'equals', array('default')),
                    ),
                    array (
                        'id' => 'property_archive_default_sidebar_position',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;"> '.esc_html__('Sidebar Settings', 'homesweet').'</h3>',
                    ),
                    array(
                        'id' => 'property_archive_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Sidebar position', 'homesweet'),
                        'subtitle' => esc_html__('Select the layout you want to apply on your archive property page.', 'homesweet'),
                        'required' => array('property_archive_layout_version', 'equals', array('default', 'full-map')),
                        'options' => array(
                            'main' => array(
                                'title' => esc_html__('Main Content', 'homesweet'),
                                'alt' => esc_html__('Main Content', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                            ),
                            'left-main' => array(
                                'title' => esc_html__('Left Sidebar - Main Content', 'homesweet'),
                                'alt' => esc_html__('Left Sidebar - Main Content', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                            ),
                            'main-right' => array(
                                'title' => esc_html__('Main Content - Right Sidebar', 'homesweet'),
                                'alt' => esc_html__('Main Content - Right Sidebar', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                            ),
                        ),
                        'default' => 'left-main'
                    ),
                    array(
                        'id' => 'property_archive_fullwidth',
                        'type' => 'switch',
                        'title' => esc_html__('Is Full Width?', 'homesweet'),
                        'default' => false,
                        'required' => array('property_archive_layout_version', 'equals', array('default', 'full-map')),
                    ),
                    array(
                        'id' => 'property_archive_left_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Left Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'homesweet'),
                        'options' => $sidebars,
                        'required' => array('property_archive_layout_version', 'equals', array('default', 'full-map')),
                    ),
                    array(
                        'id' => 'property_archive_right_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Right Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'homesweet'),
                        'options' => $sidebars,
                        'required' => array('property_archive_layout_version', 'equals', array('default', 'full-map')),
                    ),
                    array(
                        'id' => 'number_property_per_page',
                        'type' => 'text',
                        'title' => esc_html__('Number of Products Per Page', 'homesweet'),
                        'default' => 12,
                        'min' => '1',
                        'step' => '1',
                        'max' => '100',
                        'type' => 'slider'
                    ),
                    array(
                        'id' => 'property_columns',
                        'type' => 'select',
                        'title' => esc_html__('Property Columns', 'homesweet'),
                        'options' => $columns,
                        'default' => 3
                    ),
                    array(
                        'id' => 'property_pagination',
                        'type' => 'select',
                        'title' => esc_html__('Pagination Type', 'homesweet'),
                        'options' => array(
                            'default' => esc_html__('Default', 'homesweet'),
                            'loadmore' => esc_html__('Load More Button', 'homesweet'),
                            'infinite' => esc_html__('Infinite Scrolling', 'homesweet'),
                        ),
                        'default' => 'default'
                    ),
                )
            );
            // Single Property Page
            $yelp_cates = array();
            if ( is_admin() && function_exists('homesweet_get_yelp_categories') ) {
                $yelp_cates = homesweet_get_yelp_categories();
            }
            $options = array();
            if ( function_exists('homesweet_get_default_places') ) {
                $options = homesweet_get_default_places();
            }
            $this->sections[] = array(
                'title' => esc_html__('Property Detail page', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'property_single_layout_type',
                        'type' => 'select',
                        'title' => esc_html__('Property Layout Type', 'homesweet'),
                        'options' => array(
                            'layout1' => esc_html__('Layout 1', 'homesweet'),
                            'layout2' => esc_html__('Layout 2', 'homesweet'),
                            'layout3' => esc_html__('Layout 3', 'homesweet'),
                            'layout4' => esc_html__('Layout 4', 'homesweet'),
                            'layout5' => esc_html__('Layout 5', 'homesweet')
                        ),
                        'default' => 'layout1',
                    ),
                    array(
                        'id' => 'property_header_active_tab',
                        'type' => 'select',
                        'title' => esc_html__('Header active tab', 'homesweet'),
                        'options' => array(
                            'gallery' => esc_html__('Gallery', 'homesweet'),
                            'map' => esc_html__('Map', 'homesweet'),
                            'mapview' => esc_html__('Map View', 'homesweet'),
                            'virtual_tour' => esc_html__('Virtual Tour', 'homesweet'),
                        ),
                        'default' => 'gallery',
                    ),
                    array(
                        'id'        => 'property_sort_content',
                        'type'      => 'sorter',
                        'title'     => esc_html__( 'Property Content', 'homesweet' ),
                        'subtitle'  => esc_html__( 'Please drag and arrange the block', 'homesweet' ),
                        'options'   => array(
                            'enabled' => array(
                                'detail'       => esc_html__( 'Detail', 'homesweet' ),
                                'description'            => esc_html__( 'Description', 'homesweet' ),
                                'address'       => esc_html__( 'Address', 'homesweet' ),
                                'amenities' => esc_html__( 'Amenities', 'homesweet' ),
                                'nearby_yelp' => esc_html__( 'Nearby Yelp', 'homesweet' ),
                                'walk_score' => esc_html__( 'Walk Score', 'homesweet' ),
                                'stats_graph' => esc_html__( 'Stats Graph', 'homesweet' ),
                                'attachments' => esc_html__( 'Attachments', 'homesweet' ),
                                'floor' => esc_html__( 'Floor Plans', 'homesweet' ),
                                'video' => esc_html__( 'Video', 'homesweet' ),
                                'facilities' => esc_html__( 'Facilities', 'homesweet' ),
                                'valuation' => esc_html__( 'Valuation', 'homesweet' ),
                                'comments' => esc_html__( 'Reviews', 'homesweet' ),
                            ),
                            'disabled' => array()
                        ),
                    ),
                    array(
                        'id' => 'show_property_sub',
                        'type' => 'switch',
                        'title' => esc_html__('Show Sub Properties', 'homesweet'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'show_property_similar',
                        'type' => 'switch',
                        'title' => esc_html__('Show Properties Similar', 'homesweet'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'show_property_social',
                        'type' => 'switch',
                        'title' => esc_html__('Show Property Social', 'homesweet'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'enable_sticky_sidebar',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Sticky Sidebar', 'homesweet'),
                        'default' => 1
                    ),
                    
                )
            );
            
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Nearby Place Settings', 'homesweet'),
                'fields' => array(
                    array(
                        'id'         => 'property_nearby_place',
                        'type'       => 'repeater',
                        'title'      => esc_html__( 'Property Nearby Place', 'homesweet' ),
                        'fields'     => array(
                            array(
                                'id' => 'nearby_place_title',
                                'type' => 'text',
                                'title' => esc_html__('Title', 'homesweet'),
                            ),
                            array(
                                'id' => 'nearby_place_icon_font',
                                'type' => 'text',
                                'title' => esc_html__('Font Icon', 'homesweet'),
                            ),
                            array(
                                'id' => 'nearby_place_image_icon',
                                'type' => 'media',
                                'title' => esc_html__('Image Icon', 'homesweet'),
                                'subtitle' => esc_html__('Upload a .jpg or .png image for icon.', 'homesweet')
                            ),
                            array(
                                'id' => 'nearby_place_category',
                                'type' => 'select',
                                'title' => esc_html__('Yelp Categories', 'homesweet'),
                                'options' => $options,
                            ),
                            array(
                                'id' => 'nearby_place_marker',
                                'type' => 'media',
                                'title' => esc_html__('Marker Icon', 'homesweet'),
                                'subtitle' => esc_html__('Upload a .jpg or .png image for icon.', 'homesweet')
                            ),
                        )
                    ),
                )
            );

            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Yelp Settings', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'api_settings_yelp_id',
                        'type' => 'text',
                        'title' => esc_html__('Yelp App ID', 'homesweet'),
                        'subtitle' => esc_html__('Add Yelp application ID. To get your Yelp Application ID, go to your Yelp Account.', 'homesweet')
                    ),
                    array(
                        'id' => 'api_settings_yelp_app_secret',
                        'type' => 'text',
                        'title' => esc_html__('Yelp App Secret', 'homesweet'),
                        'subtitle' => esc_html__('Put your Yelp App Secret here. You can find it in your Yelp Application Dashboard.', 'homesweet')
                    ),
                    array(
                        'id' => 'api_settings_yelp_access_token',
                        'type' => 'text',
                        'title' => esc_html__('Yelp Access Token', 'homesweet'),
                        'subtitle' => esc_html__('Click on the button bellow to get access token.', 'homesweet'),
                        'description' => '<a href="#get_token" class="apus-get-token-btn button">'.esc_html__('Get Access Token', 'homesweet').'</a>'
                    ),
                    array(
                        'id'         => 'api_settings_yelp_categories',
                        'type'       => 'repeater',
                        'title'      => esc_html__( 'Yelp Categories', 'homesweet' ),
                        'fields'     => array(
                            array(
                                'id' => 'yelp_title',
                                'type' => 'text',
                                'title' => esc_html__('Title', 'homesweet'),
                            ),
                            array(
                                'id' => 'yelp_category',
                                'type' => 'select',
                                'title' => esc_html__('Yelp Categories', 'homesweet'),
                                'options' => $yelp_cates,
                            ),
                            array(
                                'id' => 'yelp_icon',
                                'type' => 'media',
                                'title' => esc_html__('Category Icon', 'homesweet'),
                                'subtitle' => esc_html__('Upload a .jpg or .png image for icon.', 'homesweet')
                            )
                        )
                    ),
                )
            );

            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Walk Score Settings', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'api_settings_walk_score_api_key',
                        'type' => 'text',
                        'title' => esc_html__('Walk Score API Key', 'homesweet'),
                        'subtitle' => esc_html__('Add Walk Score API key. To get your Walk Score API key, go to your Walk Score Account.', 'homesweet')
                    ),
                )
            );

            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Stats Graph Settings', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'property_stats_number_days',
                        'type' => 'text',
                        'title' => esc_html__('Number Days', 'homesweet'),
                        'default' => 15
                    ),
                    array(
                        'id' => 'property_stats_type',
                        'type' => 'select',
                        'title' => esc_html__('Graph Type', 'homesweet'),
                        'options' => array(
                            'bar' => esc_html__('Bar Chart', 'homesweet'),
                            'line' => esc_html__('Line Chart', 'homesweet'),
                        ),
                    ),
                    array (
                        'id' => 'property_stats_bg_color',
                        'type' => 'color',
                        'title' => esc_html__('Graph Background Color', 'homesweet')
                    ),
                    array (
                        'id' => 'property_stats_border_color',
                        'type' => 'color',
                        'title' => esc_html__('Graph Border Color', 'homesweet')
                    ),
                )
            );

            // compare settings
            $realia_fields = array();
            if ( class_exists('Realia_Filter') && is_admin() ) {
                $realia_fields = Realia_Filter::get_fields();
                if ( isset($realia_fields['id']) ) {
                    unset($realia_fields['id']);
                    unset($realia_fields['property_title']);
                }
            }
            $this->sections[] = array(
                'title' => esc_html__('Compare Settings', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'enable_compare_property',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Compare Property', 'homesweet'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'property_compare_page_slug',
                        'type' => 'select',
                        'title' => esc_html__('Compare Page', 'homesweet'),
                        'options' => $pages,
                        'required' => array('enable_compare_property', '=', 1),
                    ),
                    array(
                        'id'        => 'property_compare_sort_field',
                        'type'      => 'sorter',
                        'title'     => esc_html__( 'Compare Fields', 'homesweet' ),
                        'subtitle'  => esc_html__( 'Please drag and arrange the field', 'homesweet' ),
                        'options'   => array(
                            'enabled' => $realia_fields,
                            'disabled' => array()
                        ),
                        'required' => array('enable_compare_property', '=', 1)
                    ),
                )
            );
            $this->sections[] = array(
                'title' => esc_html__('Map Settings', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'map_custom_style',
                        'type' => 'textarea',
                        'title' => esc_html__('Map Custom Style', 'homesweet'),
                        'description' => wp_kses(__('Add Map Custom Style code. You can find all styles from here <a href="//snazzymaps.com">https://snazzymaps.com</a>', 'homesweet'), array('a' => array('href' => array()))),
                    ),
                    array(
                        'id' => 'map_zoom',
                        'type' => 'text',
                        'title' => esc_html__('Map Zoom', 'homesweet'),
                        'default' => 15,
                        'min' => '1',
                        'step' => '1',
                        'max' => '20',
                        'type' => 'slider'
                    ),
                    array(
                        'id' => 'map_marker_icon',
                        'type' => 'media',
                        'title' => esc_html__('Map marker Icon', 'homesweet'),
                        'subtitle' => esc_html__('Upload a .jpg or .png icon.', 'homesweet'),
                    ),
                )
            );
            // submit Property
            $realia_fields = array();
            if ( is_admin() && class_exists('Homesweet_Realia_Submition_Form') ) {
                $realia_fields = Homesweet_Realia_Submition_Form::default_fields();
            }

            $this->sections[] = array(
                'title' => esc_html__('Submit Property Settings', 'homesweet'),
                'fields' => array(
                    array(
                        'id'        => 'property_fields_front',
                        'type'      => 'sorter',
                        'title'     => esc_html__( 'Property Fields', 'homesweet' ),
                        'subtitle'  => esc_html__( 'Please drag and arrange the field', 'homesweet' ),
                        'options'   => array(
                            'enabled' => $realia_fields,
                            'disabled' => array()
                        ),
                    ),
                )
            );
            // Page IDX settings
            $this->sections[] = array(
                'icon' => 'el el-pencil',
                'title' => esc_html__('Idx Page', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'show_page_idx_breadcrumbs',
                        'type' => 'switch',
                        'title' => esc_html__('Breadcrumbs', 'homesweet'),
                        'default' => 1
                    ),
                    array (
                        'title' => esc_html__('Breadcrumbs Background Color', 'homesweet'),
                        'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'homesweet').'</em>',
                        'id' => 'page_idx_breadcrumb_color',
                        'type' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => 'page_idx_breadcrumb_image',
                        'type' => 'media',
                        'title' => esc_html__('Breadcrumbs Background', 'homesweet'),
                        'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'homesweet'),
                    ),
                    array(
                        'id' => 'page_idx_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Sidebar position', 'homesweet'),
                        'subtitle' => esc_html__('Select the variation you want to apply on your store.', 'homesweet'),
                        'options' => array(
                            'main' => array(
                                'title' => esc_html__('Main Only', 'homesweet'),
                                'alt' => esc_html__('Main Only', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                            ),
                            'left-main' => array(
                                'title' => esc_html__('Left - Main Sidebar', 'homesweet'),
                                'alt' => esc_html__('Left - Main Sidebar', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                            ),
                            'main-right' => array(
                                'title' => esc_html__('Main - Right Sidebar', 'homesweet'),
                                'alt' => esc_html__('Main - Right Sidebar', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                            ),
                            'left-main-right' => array(
                                'title' => esc_html__('Left - Main - Right Sidebar', 'homesweet'),
                                'alt' => esc_html__('Left - Main - Right Sidebar', 'homesweet'),
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen4.png'
                            ),
                        ),
                        'default' => 'left-main'
                    ),
                    array(
                        'id' => 'page_idx_left_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Left Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'homesweet'),
                        'options' => $sidebars
                    ),
                    array(
                        'id' => 'page_idx_right_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Right Sidebar', 'homesweet'),
                        'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'homesweet'),
                        'options' => $sidebars
                        
                    ),
                )
            );

            // 404 page
            $this->sections[] = array(
                'title' => esc_html__('404 Page', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => '404_title',
                        'type' => 'text',
                        'title' => esc_html__('Title', 'homesweet'),
                        'default' => '404'
                    ),
                    array(
                        'id' => '404_subtitle',
                        'type' => 'text',
                        'title' => esc_html__('SubTitle', 'homesweet'),
                        'default' => 'Opps! Page Not Be Found'
                    ),
                    array(
                        'id' => '404_description',
                        'type' => 'editor',
                        'title' => esc_html__('Description', 'homesweet'),
                        'default' => 'Sorry but the page you are looking for does not exist, have been removed, name changed or is temporarity unavailable.'
                    )
                )
            );
            
            // Style
            $this->sections[] = array(
                'icon' => 'el el-icon-css',
                'title' => esc_html__('Style', 'homesweet'),
                'fields' => array(
                    array (
                        'id' => 'main_font_info',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;"> '.esc_html__('Content', 'homesweet').'</h3>',
                    ),
                    array (
                        'title' => esc_html__('Main Theme Color', 'homesweet'),
                        'subtitle' => esc_html__('The main color of the site.', 'homesweet'),
                        'id' => 'main_color',
                        'type' => 'color',
                        'transparent' => false,
                    ),
                    array (
                        'title' => esc_html__('Second Theme Color', 'homesweet'),
                        'subtitle' => esc_html__('The Second color of the site.', 'homesweet'),
                        'id' => 'second_color',
                        'type' => 'color',
                        'transparent' => false,
                    ),
                    array (
                        'title' => esc_html__('Button Main Theme Color', 'homesweet'),
                        'subtitle' => esc_html__('The main color of the site.', 'homesweet'),
                        'id' => 'button_main_color',
                        'type' => 'color',
                        'transparent' => false,
                    ),
                    array (
                        'title' => esc_html__('Button Main Hover Theme Color', 'homesweet'),
                        'subtitle' => esc_html__('The main color of the site.', 'homesweet'),
                        'id' => 'button_hover_main_color',
                        'type' => 'color',
                        'transparent' => false,
                    ),

                    array (
                        'id' => 'site_background',
                        'type' => 'background',
                        'title' => esc_html__('Site Background', 'homesweet'),
                        'output' => 'body'
                    ),
                    array (
                        'id' => 'forms_inputs_bg',
                        'type' => 'color_rgba',
                        'title' => esc_html__('Forms inputs Color', 'homesweet'),
                        'output' => array(
                            'background-color' =>'.form-control, select, input[type="text"], input[type="email"], input[type="password"], input[type="tel"], textarea, textarea.form-control'
                        )
                    ),
                )
            );
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Typography', 'homesweet'),
                'fields' => array(
                    
                    array (
                        'id' => 'main_font_info',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;"> '.esc_html__('Body Font', 'homesweet').'</h3>',
                    ),
                    // Standard + Google Webfonts
                    array (
                        'title' => esc_html__('Font Face', 'homesweet'),
                        'subtitle' => '<em>'.esc_html__('Pick the Main Font for your site.', 'homesweet').'</em>',
                        'id' => 'main_font',
                        'type' => 'typography',
                        'line-height' => true,
                        'text-align' => false,
                        'font-style' => false,
                        'font-weight' => true,
                        'all_styles'=> true,
                        'font-size' => true,
                        'color' => true
                    ),
                    array (
                        'title' => esc_html__('Font Face Second', 'homesweet'),
                        'subtitle' => '<em>'.esc_html__('Pick the Second Font for your site( Heading).', 'homesweet').'</em>',
                        'id' => 'second_font',
                        'type' => 'typography',
                        'line-height' => true,
                        'text-align' => false,
                        'font-style' => false,
                        'font-weight' => true,
                        'all_styles'=> true,
                        'font-size' => true,
                        'color' => true
                    ),
                    
                    // Header
                    array (
                        'id' => 'secondary_font_info',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;"> '.esc_html__('Heading', 'homesweet').'</h3>',
                    ),
                    array (
                        'title' => esc_html__('H1 Font', 'homesweet'),
                        'subtitle' => '<em>'.esc_html__('Pick the H1 Font for your site.', 'homesweet').'</em>',
                        'id' => 'h1_font',
                        'type' => 'typography',
                        'line-height' => true,
                        'text-align' => false,
                        'font-style' => false,
                        'font-weight' => true,
                        'all_styles'=> true,
                        'font-size' => true,
                        'color' => true,
                        'output' => 'h1'
                    ),
                    array (
                        'title' => esc_html__('H2 Font', 'homesweet'),
                        'subtitle' => '<em>'.esc_html__('Pick the H2 Font for your site.', 'homesweet').'</em>',
                        'id' => 'h2_font',
                        'type' => 'typography',
                        'line-height' => true,
                        'text-align' => false,
                        'font-style' => false,
                        'font-weight' => true,
                        'all_styles'=> true,
                        'font-size' => true,
                        'color' => true,
                        'output' => 'h2'
                    ),
                    array (
                        'title' => esc_html__('H3 Font', 'homesweet'),
                        'subtitle' => '<em>'.esc_html__('Pick the H3 Font for your site.', 'homesweet').'</em>',
                        'id' => 'h3_font',
                        'type' => 'typography',
                        'line-height' => true,
                        'text-align' => false,
                        'font-style' => false,
                        'font-weight' => true,
                        'all_styles'=> true,
                        'font-size' => true,
                        'color' => true,
                        'output' => 'h3, .widgettitle, .widget-title'
                    ),
                    array (
                        'title' => esc_html__('H4 Font', 'homesweet'),
                        'subtitle' => '<em>'.esc_html__('Pick the H4 Font for your site.', 'homesweet').'</em>',
                        'id' => 'h4_font',
                        'type' => 'typography',
                        'line-height' => true,
                        'text-align' => false,
                        'font-style' => false,
                        'font-weight' => true,
                        'all_styles'=> true,
                        'font-size' => true,
                        'color' => true,
                        'output' => 'h4'
                    ),
                    array (
                        'title' => esc_html__('H5 Font', 'homesweet'),
                        'subtitle' => '<em>'.esc_html__('Pick the H5 Font for your site.', 'homesweet').'</em>',
                        'id' => 'h5_font',
                        'type' => 'typography',
                        'line-height' => true,
                        'text-align' => false,
                        'font-style' => false,
                        'font-weight' => true,
                        'all_styles'=> true,
                        'font-size' => true,
                        'color' => true,
                        'output' => 'h5'
                    ),
                    array (
                        'title' => esc_html__('H6 Font', 'homesweet'),
                        'subtitle' => '<em>'.esc_html__('Pick the H6 Font for your site.', 'homesweet').'</em>',
                        'id' => 'h6_font',
                        'type' => 'typography',
                        'line-height' => true,
                        'text-align' => false,
                        'font-style' => false,
                        'font-weight' => true,
                        'all_styles'=> true,
                        'font-size' => true,
                        'color' => true,
                        'output' => 'h6'
                    ),
                )
            );
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Top Bar', 'homesweet'),
                'fields' => array(
                    array(
                        'id'=>'topbar_bg',
                        'type' => 'background',
                        'title' => esc_html__('Background', 'homesweet'),
                        'output' => '.apus-topbar'
                    ),
                    array(
                        'title' => esc_html__('Text Color', 'homesweet'),
                        'id' => 'topbar_text_color',
                        'type' => 'color_rgba',
                        'output' => array(
                            'color' =>'.apus-topbar'
                        )
                    ),
                    array(
                        'title' => esc_html__('Link Color', 'homesweet'),
                        'id' => 'topbar_link_color',
                        'type' => 'color_rgba',
                        'output' => array(
                            'color' =>'.apus-topbar a'
                        )
                    ),
                    array(
                        'title' => esc_html__('Link Color When Hover', 'homesweet'),
                        'id' => 'topbar_link_color_hover',
                        'type' => 'color_rgba',
                        'output' => array(
                            'color' =>'.apus-topbar a:hover,.apus-topbar a:active'
                        )
                    ),
                )
            );
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Header', 'homesweet'),
                'fields' => array(
                    array(
                        'id'=>'header_bg',
                        'type' => 'background',
                        'title' => esc_html__('Background', 'homesweet'),
                        'output' => '#apus-header,.header-middle,.header-v2 .sticky-header .header-middle,.header-v6 .header-middle',
                    ),
                    array(
                        'title' => esc_html__('Text Color', 'homesweet'),
                        'id' => 'header_text_color',
                        'type' => 'color',
                        'output' => array(
                            'color' =>'#apus-header'
                        )
                    ),
                    array(
                        'title' => esc_html__('Link Color', 'homesweet'),
                        'id' => 'header_link_color',
                        'type' => 'color',
                        'output' => array(
                            'color' =>'#apus-header a'
                        )
                    ),
                    array(
                        'title' => esc_html__('Link Color Active', 'homesweet'),
                        'id' => 'header_link_color_active',
                        'type' => 'color',
                        'output' => array(
                            'color' =>'#apus-header .active > a, #apus-header a:active, #apus-header a:hover'
                        )
                    ),
                )
            );
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Main Menu', 'homesweet'),
                'fields' => array(
                    array(
                        'title' => esc_html__('Link Color', 'homesweet'),
                        'id' => 'main_menu_link_color',
                        'type' => 'color',
                        'output' => array(
                            'color' =>'#apus-header .navbar-nav.megamenu > li > a'
                        )
                    ),
                    array(
                        'title' => esc_html__('Link Color Active', 'homesweet'),
                        'id' => 'main_menu_link_color_active',
                        'type' => 'color',
                        'output' => array(
                            'color' =>'.navbar-nav.megamenu .dropdown-menu > li > a:hover, .navbar-nav.megamenu .dropdown-menu > li > a:active,.navbar-nav.megamenu .dropdown-menu > li.open > a, .navbar-nav.megamenu .dropdown-menu > li.active > a,#apus-header .navbar-nav.megamenu > li.active > a,#apus-header .navbar-nav.megamenu > li:hover > a,#apus-header .navbar-nav.megamenu > li:active > a'
                        )
                    ),
                )
            );
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Footer', 'homesweet'),
                'fields' => array(
                    array(
                        'id'=>'footer_bg',
                        'type' => 'background',
                        'title' => esc_html__('Background', 'homesweet'),
                        'output' => '.apus-footer,.apus-footer .dark'
                    ),
                    array(
                        'title' => esc_html__('Heading Color', 'homesweet'),
                        'id' => 'footer_heading_color',
                        'type' => 'color',
                        'output' => array(
                            'color' => '#apus-footer .widgettitle ,#apus-footer .widget-title,#apus-footer .widgettitle span,#apus-footer .widget-title span,
                            #apus-footer .dark .widgettitle ,#apus-footer .dark .widget-title,#apus-footer .dark .widgettitle span,#apus-footer .dark .widget-title span
                            '
                        )
                    ),
                    array(
                        'title' => esc_html__('Text Color', 'homesweet'),
                        'id' => 'footer_text_color',
                        'type' => 'color',
                        'output' => array(
                            'color' => '#apus-footer, #apus-footer .dark'
                        )
                    ),
                    array(
                        'title' => esc_html__('Link Color', 'homesweet'),
                        'id' => 'footer_link_color',
                        'type' => 'color',
                        'output' => array(
                            'color' => '#apus-footer a, #apus-footer .dark a'
                        )
                    ),
                    array(
                        'title' => esc_html__('Link Color Hover', 'homesweet'),
                        'id' => 'footer_link_color_hover',
                        'type' => 'color',
                        'output' => array(
                            'color' => '#apus-footer a:hover ,#apus-footer a:active, #apus-footer .dark a:hover, #apus-footer .dark:active'
                        )
                    ),
                )
            );
            
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Copyright', 'homesweet'),
                'fields' => array(
                    array(
                        'id'=>'copyright_bg',
                        'type' => 'background',
                        'title' => esc_html__('Background', 'homesweet'),
                        'output' => '.apus-copyright'
                    ),
                    array(
                        'title' => esc_html__('Text Color', 'homesweet'),
                        'id' => 'copyright_text_color',
                        'type' => 'color',
                        'output' => array(
                            'color' => '.apus-copyright'
                        )
                    ),
                    array(
                        'title' => esc_html__('Link Color', 'homesweet'),
                        'id' => 'copyright_link_color',
                        'type' => 'color',
                        'output' => array(
                            'color' => '.apus-copyright a'
                        )
                    ),
                    array(
                        'title' => esc_html__('Link Color Hover', 'homesweet'),
                        'id' => 'copyright_link_color_hover',
                        'type' => 'color',
                        'output' => array(
                            'color' => '.apus-copyright a:hover .apus-copyright a:active'
                        )
                    ),
                )
            );

            // Social Media
            $this->sections[] = array(
                'icon' => 'el el-file',
                'title' => esc_html__('Social Media', 'homesweet'),
                'fields' => array(
                    array(
                        'id' => 'facebook_share',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Facebook Share', 'homesweet'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'twitter_share',
                        'type' => 'switch',
                        'title' => esc_html__('Enable twitter Share', 'homesweet'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'linkedin_share',
                        'type' => 'switch',
                        'title' => esc_html__('Enable linkedin Share', 'homesweet'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'tumblr_share',
                        'type' => 'switch',
                        'title' => esc_html__('Enable tumblr Share', 'homesweet'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'google_share',
                        'type' => 'switch',
                        'title' => esc_html__('Enable google plus Share', 'homesweet'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'pinterest_share',
                        'type' => 'switch',
                        'title' => esc_html__('Enable pinterest Share', 'homesweet'),
                        'default' => 1
                    )
                )
            );
            // Custom Code
            $this->sections[] = array(
                'icon' => 'el-icon-css',
                'title' => esc_html__('Custom CSS/JS', 'homesweet'),
                'fields' => array(
                    array (
                        'title' => esc_html__('Custom CSS', 'homesweet'),
                        'subtitle' => esc_html__('Paste your custom CSS code here.', 'homesweet'),
                        'id' => 'custom_css',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array (
                        'title' => esc_html__('Custom JavaScript Code', 'homesweet'),
                        'subtitle' => esc_html__('Here is the place to paste your Google Analytics code or any other JS code you might want to add to be loaded in the footer of your website.', 'homesweet'),
                        'id' => 'custom_js',
                        'type' => 'ace_editor',
                        'mode' => 'javascript',
                    ),
                )
            );
            $this->sections[] = array(
                'title' => esc_html__('Import / Export', 'homesweet'),
                'desc' => esc_html__('Import and Export your Redux Framework settings from file, text or URL.', 'homesweet'),
                'icon' => 'el-icon-refresh',
                'fields' => array(
                    array(
                        'id' => 'opt-import-export',
                        'type' => 'import_export',
                        'title' => 'Import Export',
                        'subtitle' => 'Save and restore your Redux options',
                        'full_width' => false,
                    ),
                ),
            );

            $this->sections[] = array(
                'type' => 'divide',
            );


        }
        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments()
        {
            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            
            $preset = homesweet_get_demo_preset();
            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'homesweet_theme_options'.$preset,
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'),
                // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'),
                // Version that appears at the top of your panel
                'menu_type' => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true,
                // Show the sections below the admin menu item or not
                'menu_title' => esc_html__('Theme Options', 'homesweet'),
                'page_title' => esc_html__('Theme Options', 'homesweet'),

                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '',
                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'google_update_weekly' => false,
                // Must be defined to add google fonts to the typography module
                'async_typography' => true,
                // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar' => true,
                // Show the panel pages on the admin bar
                'admin_bar_icon' => 'dashicons-portfolio',
                // Choose an icon for the admin bar menu
                'admin_bar_priority' => 50,
                // Choose an priority for the admin bar menu
                'global_variable' => 'apus_options',
                // Set a different name for your global variable other than the opt_name
                'dev_mode' => false,
                // Show the time the page took to load, etc
                'update_notice' => true,
                // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                'customizer' => true,
                // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority' => null,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon' => '',
                // Specify a custom URL to an icon
                'last_tab' => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options',
                // Page slug used to denote the panel
                'save_defaults' => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show' => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info' => false,
                // REMOVE
                'use_cdn' => true
            );

            $this->args['intro_text'] = '';

            // Add content after the form.
            $this->args['footer_text'] = '';
            return $this->args;
        }

    }

    global $reduxConfig;
    $reduxConfig = new Homesweet_Redux_Framework_Config();
}

if ( function_exists('apus_framework_redux_register_custom_extension_loader') ) {
    $preset = homesweet_get_demo_preset();
    $opt_name = 'homesweet_theme_options'.$preset;
    add_action("redux/extensions/{$opt_name}/before", 'apus_framework_redux_register_custom_extension_loader', 0);
}