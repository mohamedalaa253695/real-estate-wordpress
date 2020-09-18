<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article <?php post_class( 'agency-row' ); ?>>
    <div class="agency-row-content">
        <div class="agency-row-content-inner">
            <div class="agency-row-main clearfix">
                <?php if ( has_post_thumbnail() ) : ?>
		            <div class="agency-row-thumbnail">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'thumbnail' ); ?>
                        </a>
		            </div><!-- /.agency-row-thumbnail -->
                <?php endif; ?>

                <div class="agency-row-body">
                	<h2 class="agency-row-title">
		                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	                </h2>
	                <?php $address = get_post_meta( get_the_ID(), REALIA_AGENCY_PREFIX . 'address', true ); ?>
		            <?php if ( ! empty( $address ) ) : ?>
	                    <div class="address"><i class="ion-location" aria-hidden="true"></i><?php echo wp_kses( nl2br( $address ), wp_kses_allowed_html( 'post' ) ); ?></div>
	                <?php endif; ?>
	                <?php $phone = get_post_meta( get_the_ID(), REALIA_AGENCY_PREFIX . 'phone', true ); ?>
                 	<?php if ( ! empty( $phone ) ) : ?>
                            <div class="phone"><i class="ion-ios-telephone-outline" aria-hidden="true"></i><?php echo esc_attr( $phone ); ?></div>
                        <?php endif; ?>
	                <?php
	                $agents = Realia_Query::get_agency_agents();
	                $agents_count = $agents->post_count;
	                ?>

	                <?php if ( $agents_count > 0 ) : ?>
	                	<div class="agency-row-sub">
			                <div class="agency-agents-count">
				                <?php echo sprintf(_n('<span>%s</span> Agent', '<span>%s</span> Agents', $agents_count, 'homesweet'), $agents_count); ?>
			                </div><!-- /.agency-row-agents -->
			                <?php
			                $properties_count = 0;
			                while ( $agents->have_posts() ) { $agents->the_post();
			                	$properties_count += Realia_Query::get_agent_properties()->post_count;
			                }
			                wp_reset_postdata();
			                if ( $properties_count > 0 ) { ?>
			                	<div class="agency-properties-count">
					                <?php echo sprintf(_n('<span>%s</span> Property', '<span>%s</span> Properties', $properties_count, 'homesweet'), $properties_count); ?>
				                </div>
			                <?php } ?>
		                </div>
	                <?php endif; ?>
                </div><!-- /.agency-row-body -->
            </div><!-- /.agency-row-main -->
        </div><!-- /.agency-row-content-inner -->
    </div><!-- /.agency-row-content -->
</article>