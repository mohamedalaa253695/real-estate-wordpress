<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Homesweet
 * @since Homesweet 1.0
 */

$footer = apply_filters( 'homesweet_get_footer_layout', 'default' );
$logo_copyright = homesweet_get_config('logo_copyright');
?>

	</div><!-- .site-content -->

	<footer id="apus-footer" class="apus-footer" role="contentinfo">
		<?php if ( !empty($footer) ): ?>
			<div class="container">
				<?php homesweet_display_footer_builder($footer); ?>
			</div>
		<?php else: ?>
			<div class="apus-copyright">
				<div class="container">
					<div class="copyright-content clearfix">
						<div class="text-copyright">
							<?php
								$allowed_html_array = array( 'a' => array('href' => array()) );
								echo wp_kses(__('&copy; 2017 - Homesweet. All Rights Reserved. <br/> Powered by <a href="//apusthemes.com">ApusThemes</a>', 'homesweet'), $allowed_html_array);
							?>
						</div>
					</div>
				</div>
			</div>
		
		<?php endif; ?>
		
	</footer><!-- .site-footer -->

	<?php
	if ( homesweet_get_config('enable_compare_property') && class_exists('Homesweet_Realia_Compare') ) {
		$compare_ids = Homesweet_Realia_Compare::get_compare_items(); ?>
		<div id="compare-sidebar" class="<?php echo esc_attr(count($compare_ids) > 0 ? 'active' : ''); ?>">
			<div class="compare-sidebar-wrapper">
				<h3 class="title"><?php echo esc_html__('Compare Properties','homesweet'); ?></h3>
				<?php
					if ( count($compare_ids) > 0 ) {
						echo Realia_Template_Loader::load( 'compares', array('compare_ids' => $compare_ids) );
					}
				?>
			</div>
			<div class="compare-sidebar-btn">
				<div class="open-text">
					<?php esc_html_e( 'Compare', 'homesweet' ); ?> (<span class="count"><?php echo count($compare_ids); ?></span>)
				</div>
			</div>
		</div><!-- .widget-area -->
	<?php
	}
	?>

	<?php
	if ( homesweet_get_config('back_to_top') ) { ?>
		<a href="#" id="back-to-top" class="add-fix-top">
			<i class="fa fa-angle-up"></i>
		</a>
	<?php
	}
	?>

</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>