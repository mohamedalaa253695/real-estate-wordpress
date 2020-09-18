<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <div class="entry-content">
                <div class="agent-box-inner clearfix">
                    <div class="agent-header">
                        <div class="agent-thumbnail">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'large' ); ?>
                            <?php endif; ?>
                        </div>
                        <div class="content-info">
                            <?php
                                if ( is_single() ) :
                                    the_title( '<h1 class="agent-row-title">', '</h1>' );
                                else :
                                    the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
                                endif;
                            ?>
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
                            <div class="clearfix">
                                <ul class="agent-metas">
                                    <?php $email = get_post_meta( get_the_ID(), REALIA_AGENT_PREFIX . 'email', true ); ?>
                                    <?php if ( ! empty( $email ) ) : ?>
                                        <li><i class="ion-ios-email-outline" aria-hidden="true"></i><?php echo esc_attr( $email ); ?></li>
                                    <?php endif; ?>

                                    <?php $phone = get_post_meta( get_the_ID(), REALIA_AGENT_PREFIX . 'phone', true ); ?>
                                    <?php if ( ! empty( $phone ) ) : ?>
                                        <li><i class="ion-ios-telephone-outline" aria-hidden="true"></i><?php echo esc_attr( $phone ); ?></li>
                                    <?php endif; ?>

                                    <?php $web = get_post_meta( get_the_ID(), REALIA_AGENT_PREFIX . 'web', true ); ?>
                                    <?php if ( ! empty( $web ) ) : ?>
                                        <li><i class="ion-ios-world-outline" aria-hidden="true"></i><?php echo esc_attr( $web ); ?></li>
                                    <?php endif; ?>

                                    <?php $address = get_post_meta( get_the_ID(), REALIA_AGENT_PREFIX . 'address', true ); ?>
                                    <?php if ( ! empty( $address ) ) : ?>
                                       <li><i class="ion-location" aria-hidden="true"></i><?php echo wp_kses( nl2br( $address ), wp_kses_allowed_html( 'post' ) ); ?></li>
                                    <?php endif; ?>
                                </ul>
                            </div><!-- /.agent-overview -->
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
                        </div>
                    </div><!-- /.agent-header -->
                </div>
                
                <div class="description">
                    <!-- Description -->
                    <h3 class="title"><?php esc_html_e('Biography', 'homesweet'); ?></h3>
                    <?php the_content(); ?>
                </div>

                <?php
                    $properties = Realia_Query::get_agent_properties();
                    
                    if ( $properties->have_posts() ) {
                        $key_rand = homesweet_random_key();
                ?>
                    <div id="widget-properties<?php echo esc_attr($key_rand); ?>" class="widget-properties">
                        <div class="clearfix fillter-single-agent">
                            <div class="contract-filter">
                                <ul class="isotope-filter" data-related-grid="isotope-items-<?php echo esc_attr($key_rand); ?>">
                                    <li><a href="#" data-filter=".all"><?php esc_html_e('All', 'homesweet'); ?></a></li>
                                    <li><a href="#" data-filter=".SALE"><?php esc_html_e('For Rent', 'homesweet'); ?></a></li>
                                    <li><a href="#" data-filter=".RENT"><?php esc_html_e('For Sale', 'homesweet'); ?></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="widget-content">
                            <?php
                                wp_enqueue_script( 'homesweet-isotope', get_template_directory_uri().'/js/isotope.pkgd.min.js', array( 'jquery' ) );
                                
                                $class = 'col-sm-12';
                            ?>
                                <div class="agent-properties properties-grid type-box">
                                    <div id="isotope-items-<?php echo esc_attr($key_rand); ?>" class="isotope-items row" data-isotope-duration="400">
                                        <?php
                                            $count = 0;
                                            while ( $properties->have_posts() ) : $properties->the_post(); 
                                                $contract = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'contract', true );
                                        ?>
                                                <div class="isotope-item all <?php echo esc_attr($contract); ?> <?php echo esc_attr($class); ?>" data-category="<?php echo esc_attr($contract); ?>">
                                                    <?php echo Realia_Template_Loader::load( 'properties/row' ); ?>
                                                </div><!-- /.property-container -->
                                        <?php $count++; ?>
                                        <?php endwhile; ?>
                                    </div><!-- /.properties-row -->
                                </div><!-- /.agent-properties -->
                            <?php wp_reset_postdata(); ?>
                        </div>
                    </div>
                <?php } ?>
                

                
                <?php wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'homesweet' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                    'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'homesweet' ) . ' </span>%',
                    'separator'   => '<span class="screen-reader-text">, </span>',
                ) ); ?>
                <?php if ( comments_open() || get_comments_number() ) : ?>
                    <div class="box"><?php comments_template( '', true ); ?></div>
                <?php endif; ?>

            </div><!-- .entry-content -->
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="sidebar">
                <?php echo Realia_Template_Loader::load('agents/contact-form'); ?>
            </div>
        </div>
    </div>
</article><!-- #post-## -->