<?php
$agents = Realia_Query::get_property_agents();

$args = array(
	'post_type'         => 'agent',
	'post__in'          => count( $agents ) > 0 ? $agents : array( null ),
	'posts_per_page'    => -1,
);
$loop = new WP_Query($args);

if ( $loop->have_posts() ) :?>
	<div id="property-section-agents" class="property-agents-wrapper property-section">
		<h3><?php echo esc_html__('Contact Information', 'homesweet'); ?></h3>
		<div class="type-small item-per-row-1">
			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
				<div class="agents-container clearfix">
					<?php include Realia_Template_Loader::locate( 'agents/row-small' ); ?>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>

		<h4><?php echo esc_html__('Contact Agent', 'homesweet'); ?></h4>
		<form method="post" action="<?php the_permalink(); ?>" class="contact-agent">
		    <input type="hidden" name="post_id" value="<?php the_ID(); ?>">

	        <input type="hidden" name="receive_agent" value="1">

		    <div class="form-group">
		        <input class="form-control" name="name" type="text" placeholder="<?php echo esc_html__( 'Name', 'homesweet' ); ?>" value="<?php echo empty( $_POST['name'] ) ? '' : esc_attr( $_POST['name'] ); ?>" required="required">
		    </div><!-- /.form-group -->

		    <div class="form-group">
		        <input class="form-control" name="email" type="email" placeholder="<?php echo esc_html__( 'E-mail', 'homesweet' ); ?>" value="<?php echo empty( $_POST['email'] ) ? '' : esc_attr( $_POST['email'] ); ?>" required="required">
		    </div><!-- /.form-group -->

		    <div class="form-group">
		        <input class="form-control" name="phone" type="text" placeholder="<?php echo esc_html__( 'Phone', 'homesweet' ); ?>" value="<?php echo empty( $_POST['phone'] ) ? '' : esc_attr( $_POST['phone'] ); ?>" required="required">
		    </div><!-- /.form-group -->

		    <div class="form-group">
		        <textarea class="form-control" name="message" required="required" placeholder="<?php echo esc_html__( 'Message', 'homesweet' ); ?>" rows="4"><?php echo empty( $_POST['message'] ) ? '' : esc_attr( $_POST['message'] ); ?></textarea>
		    </div><!-- /.form-group -->

	        <?php if ( Realia_Recaptcha::is_recaptcha_enabled() ) : ?>
	            <div id="recaptcha-<?php echo esc_attr( $this->id ); ?>" class="g-recaptcha" data-sitekey="<?php echo get_theme_mod( 'realia_recaptcha_site_key' ); ?>"></div>
	        <?php endif; ?>

		    <div class="button-wrapper">
		        <button type="submit" class="button btn btn-theme-second" name="enquire_form"><?php echo esc_html__( 'Send Message', 'homesweet' ); ?></button>
		    </div><!-- /.button-wrapper -->
		</form>
	</div>
<?php endif; ?>

