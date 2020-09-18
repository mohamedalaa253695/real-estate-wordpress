<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article <?php post_class( 'agent-row' ); ?>>
    <div class="agent-row-content agent-grid2">
        <div class="agent-row-content-inner">
            <div class="agent-row-main">
            	<div class="agent-top">
		            <?php if ( has_post_thumbnail() ) :   ?>
			            <div class="agent-thumbnail">
				            <?php if ( has_post_thumbnail() ) : ?>
					            <a href="<?php the_permalink() ?>">
						            <?php the_post_thumbnail( 'full' ); ?>
					            </a>
				            <?php endif; ?>
			            </div>
		            <?php endif; ?>
                    <a href="<?php the_permalink() ?>" class="viewprofile">
                        <?php echo esc_html__('View Profile','homesweet') ?>
                    </a>
				</div>
	            <div class="agent-row-body">
		            <h2 class="entry-title">
			            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		            </h2>
		            <div class="agencies">
		            	<?php
                        $agent_agencies = get_post_meta( get_the_ID(), REALIA_AGENT_PREFIX . 'agencies', true );
                        if ($agent_agencies) {
                            $count = 1;
                            foreach ($agent_agencies as $id) {
                                $post = get_post($id);
                                ?>
                                <a href="<?php echo esc_url(get_permalink($post)); ?>" title="<?php echo esc_attr($post->post_title); ?>"><?php echo trim($post->post_title); ?></a><?php echo (count($agent_agencies) > $count ? ', ' : ''); ?>
                                <?php
                                $count++;
                            }
                        }
                        ?>
		            </div>
		            <div class="agent-social">
                        <?php
                            $social_icons = homesweet_realia_agent_social_icons();
                            $social_networks = apply_filters( 'realia_social_networks', array() );
                            foreach( $social_networks as $key => $title ) {
                                $social_url = get_post_meta( get_the_ID(), REALIA_AGENT_PREFIX . 'social_' . $key, true );
                                if ( !empty($social_url) ) {
                                    ?>
                                    <a href="<?php echo esc_url($social_url); ?>" title="<?php echo esc_attr($title); ?>">
                                        <i class="<?php echo esc_attr(isset($social_icons[$key]) ? $social_icons[$key] : 'icon-ap_facebook-outline'); ?>"></i>
                                    </a>
                                    <?php
                                }
                            }
                        ?>
                    </div><!-- /.agent-social-networks -->
	            </div><!-- /.agent-row-body -->

            </div><!-- /.agent-row-main -->
        </div><!-- /.agent-row-content-inner -->
    </div><!-- /.agent-row-content -->
</article>