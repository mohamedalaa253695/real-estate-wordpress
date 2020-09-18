<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="agent-small">
	<div class="agent-small-inner">
		<div class="agent-small-image">
			<a href="<?php the_permalink() ?>" class="agent-small-image-inner">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'property-thumbnail' ); ?>
				<?php endif; ?>
			</a><!-- /.agent-small-image-inner -->
		</div><!-- /.agent-small-image -->

		<div class="agent-small-content">
			<h3 class="agent-small-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
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
			<div class="agent-meta">
				<?php $email = get_post_meta( get_the_ID(), REALIA_AGENT_PREFIX . 'email', true ); ?>
				<?php if ( ! empty( $email ) ) : ?>
					<div class="agent-small-email">
						<i class="icon-ap_email"></i>
						<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_attr( $email ); ?></a>
					</div><!-- /.agent-small-email -->
				<?php endif; ?>
			</div>
		</div><!-- /.agent-small-content -->
		<div class="clearfix"></div>
		<?php $phone = get_post_meta( get_the_ID(), REALIA_AGENT_PREFIX . 'phone', true ); ?>
		<?php if ( ! empty( $phone ) ) : ?>
			<div class="agent-small-phone">
				<i class="icon-ap_phone"></i>
				<?php echo esc_attr( $phone ); ?>
			</div><!-- /.agent-small-phone -->
		<?php endif; ?>
	</div><!-- /.agent-small-inner -->
</div><!-- /.agent-small -->
