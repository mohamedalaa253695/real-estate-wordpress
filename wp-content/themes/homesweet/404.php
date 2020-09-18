<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Homesweet
 * @since Homesweet 1.0
 */
/*

*Template Name: 404 Page
*/
get_header();

?>
<section class="page-404">
	<div id="main-container" class="inner">
		
		<div id="main-content" class="main-page clearfix">

			<section class="error-404 not-found text-center clearfix">
				<h4 class="title-big"><?php echo trim(homesweet_get_config('404_title', '404')); ?></h4>
				<h1 class="page-title"><?php echo trim(homesweet_get_config('404_subtitle', 'Oop, that link is broken.')); ?></h1>
				<div class="page-content">
					<p class="sub-title">
						<?php echo trim(homesweet_get_config('404_description', 'We are sorry, but something went wrong')); ?>
					</p>
					<?php get_search_form(); ?>
					<a class="btn btn-blue btn-lg" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Back to Home', 'homesweet'); ?></a>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</div><!-- .content-area -->
			
	</div>
</section>
<?php get_footer(); ?>