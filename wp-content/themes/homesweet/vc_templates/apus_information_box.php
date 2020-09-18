<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$socials = array('facebook' => esc_html__('Facebook', 'homesweet'), 'twitter' => esc_html__('Twitter', 'homesweet'),
    'youtube' => esc_html__('Youtube', 'homesweet'), 'pinterest' => esc_html__('Pinterest', 'homesweet'),
    'google-plus' => esc_html__('Google Plus', 'homesweet'), 'instagram' => esc_html__('Instagram', 'homesweet'));
?>
<div class="widget-information-box <?php echo esc_attr($el_class); ?>">
	<?php if($title!=''): ?>
        <h3 class="title" >
           <span><?php echo esc_attr( $title ); ?></span>
        </h3>
    <?php endif; ?>
    <?php if(wpb_js_remove_wpautop( $content, true )){ ?>
        <div class="description">
            <?php echo wpb_js_remove_wpautop( $content, true ); ?>
        </div>
    <?php } ?>
    <ul class="social">
        <?php foreach( $socials as $key=>$social):
                if( isset($atts[$key.'_url']) && !empty($atts[$key.'_url']) ): ?>
                    <li>
                        <a href="<?php echo esc_url($atts[$key.'_url']);?>" class="<?php echo esc_attr($key); ?>">
                            <i class="fa fa-<?php echo esc_attr($key); ?> "></i>
                        </a>
                    </li>
        <?php
                endif;
            endforeach;
        ?>
    </ul>
</div>