<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('detail-agency'); ?>>

    <div class="entry-content">
        <div class="info-top">
            <div class="agency-header">
                <div class="agency-thumbnail">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'full' ); ?>
                    <?php endif; ?>
                </div>
                <div class="agency-overview">
                    <?php the_title( '<h1 class="agency-title">', '</h1>' ) ?>
                    <?php $address = get_post_meta( get_the_ID(), REALIA_AGENCY_PREFIX . 'address', true ); ?>
                    <?php if ( ! empty( $address ) ) : ?>
                        <div class="address"><i class="icon-ap_pin" aria-hidden="true"></i><?php echo wp_kses( nl2br( $address ), wp_kses_allowed_html( 'post' ) ); ?></div>
                    <?php endif; ?>
                    <?php
                    $agents = Realia_Query::get_agency_agents();
                    $agents_count = $agents->post_count;
                    ?>
                    <?php if ( $agents_count > 0 ) : ?>
                        <div class="agency-row-sub">
                            <div class="agency-agents-count">
                                <?php echo sprintf(_n('<span class="text-theme">%s</span> Agent', '<span class="text-theme">%s</span> Agents', $agents_count, 'homesweet'), $agents_count); ?>
                            </div><!-- /.agency-row-agents -->
                            <?php
                            $properties_count = 0;
                            while ( $agents->have_posts() ) { $agents->the_post();
                                $properties_count += Realia_Query::get_agent_properties()->post_count;
                            }
                            wp_reset_postdata();
                            if ( $properties_count > 0 ) { ?>
                                <div class="agency-properties-count">
                                    <?php echo sprintf(_n('<span class="text-theme">%s</span> Property', '<span class="text-theme">%s</span> Properties', $properties_count, 'homesweet'), $properties_count); ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                    <ul class="agent-metas">
                        <?php $email = get_post_meta( get_the_ID(), REALIA_AGENCY_PREFIX . 'email', true ); ?>
                        <?php if ( ! empty( $email ) ) : ?>
                            <li><i class="ion-ios-email-outline" aria-hidden="true"></i><?php echo esc_attr( $email ); ?></li>
                        <?php endif; ?>

                        <?php $web = get_post_meta( get_the_ID(), REALIA_AGENCY_PREFIX . 'web', true ); ?>
                        <?php if ( ! empty( $web ) ) : ?>
                            <li><i class="ion-ios-world-outline" aria-hidden="true"></i><?php echo esc_attr( $web ); ?></li>
                        <?php endif; ?>

                        <?php $phone = get_post_meta( get_the_ID(), REALIA_AGENCY_PREFIX . 'phone', true ); ?>
                        <?php if ( ! empty( $phone ) ) : ?>
                            <li><i class="ion-ios-telephone-outline" aria-hidden="true"></i><?php echo esc_attr( $phone ); ?></li>
                        <?php endif; ?>
                    </ul>
                    <div class="agent-social">
                        <?php $social_icons = homesweet_realia_agent_social_icons(); ?>
                        <?php $social_networks = apply_filters( 'realia_social_networks', array() ); ?>
                        <?php foreach( $social_networks as $key => $title ): ?>
                            <?php $network = get_post_meta( get_the_ID(), REALIA_AGENCY_PREFIX . 'social_' . $key, true ); ?>
                            <?php if ( ! empty( $network ) ) : ?>
                                <a href="<?php echo esc_attr( $network ); ?>" class="agency-social-network <?php echo esc_attr(isset($social_icons[$key]) ? $social_icons[$key] : 'icon-ap_facebook-outline'); ?>" target="_blank"></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div><!-- /.agent-social-networks -->
                </div><!-- /.agency-overview -->
            </div><!-- /.agency-header -->
        </div>
        <div class="tabs-content-agent">
            <ul class="nav nav-tabs nav-agencies">
                <li class="active">
                    <a href="#tab-content-description" data-toggle="tab">
                        <?php echo esc_html__( 'Overview', 'homesweet' ); ?>
                    </a>
                </li>
                <li>
                    <a href="#tab-content-location" data-toggle="tab" class="tab-google-map">
                        <?php echo esc_html__( 'Find on Map', 'homesweet' ); ?>
                    </a>
                </li>
                <?php if ( homesweet_get_config('show_agency_agents', true) ) { ?>
                    <li>
                        <a href="#tab-content-agents" data-toggle="tab">
                            <?php echo esc_html__( 'Agents', 'homesweet' ); ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <div class="tab-content tab-content-descrip">
                <div id="tab-content-description" class="tab-pane active">
                    <!-- Description -->
                    <?php the_content(); ?>
                </div>
                <?php if ( homesweet_get_config('show_agency_agents', true) ) { ?>
                    <div id="tab-content-agents" class="tab-pane">
                        <?php Realia_Query::loop_agency_agents( null, homesweet_get_config('number_agency_agents', 4) );
                        $columns = homesweet_get_config('agent_agency_columns', 3);
                        $bcol = 4;
                        ?>

                        <?php if ( have_posts() ) : ?>
                            
                            <div class="agency-agents type-box item-per-row-3">
                                <div class="agents-row row">
                                    <?php while ( have_posts() ) : the_post(); ?>
                                        <div class="agent-container col-md-<?php echo esc_attr($bcol); ?> col-xs-12">
                                            <?php echo Realia_Template_Loader::load('agents/box'); ?>
                                        </div>
                                    <?php endwhile; ?>
                                </div><!-- /.agents-row -->
                            </div><!-- /.agency-agents -->
                        <?php endif;?>

                        <?php wp_reset_query(); ?>
                    </div>
                <?php } ?>
                <div id="tab-content-location" class="tab-pane">
                    <?php $location = get_post_meta( get_the_ID(), REALIA_AGENCY_PREFIX . 'location', true );
                    $marker_icon = homesweet_get_config('map_marker_icon');
                    ?>
                    <?php if ( ! empty( $location ) && 2 == count( $location ) ) : ?>
                       
                        <!-- MAP -->
                        <div class="map-position">
                            <div id="tab-single-property-map"
                                 data-latitude="<?php echo esc_attr( $location['latitude'] ); ?>"
                                 data-longitude="<?php echo esc_attr( $location['longitude'] ); ?>"
                                 data-zoom="<?php echo esc_attr(homesweet_get_config('map_zoom', 15)); ?>"
                                 <?php echo (homesweet_get_config('map_custom_style') ? 'data-style="'.esc_attr(homesweet_get_config('map_custom_style')).'"' : ''); ?>
                                 <?php echo (isset($marker_icon['url']) ? 'data-icon_image="'.esc_attr($marker_icon['url']).'"' : ''); ?> style="height: 380px">
                            </div><!-- /#map-property -->
                        </div><!-- /.map-property -->
                    <?php endif; ?>
                </div>
            </div>
        </div>

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
</article><!-- #post-## -->