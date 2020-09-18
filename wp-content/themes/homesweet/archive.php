<?php
get_header();
$sidebar_configs = homesweet_get_blog_layout_configs();

$columns = homesweet_get_config('blog_columns', 1);
$bscol = floor( 12 / $columns );
$_count  = 0;
homesweet_render_breadcrumbs();
?>
<section id="main-container" class="<?php echo apply_filters('homesweet_blog_content_class', 'container');?> inner">
	<div class="row">
		<?php
            $class = '';
            if ( isset($sidebar_configs['left']) ) {
                $class = 'pull-right';
            }
        ?>

		<div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class'].' '.$class); ?>">
			<main id="main" class="site-main layout-blog" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header hidden">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<?php
				$layout = homesweet_get_blogs_layout_type();
				get_template_part( 'post-formats/layouts/'.$layout );

				// Previous/next page navigation.
				homesweet_paging_nav();

			// If no content, include the "No posts found" template.
			else :
				get_template_part( 'post-formats/content', 'none' );

			endif;
			?>

			</main><!-- .site-main -->
		</div><!-- .content-area -->

		<?php if ( isset($sidebar_configs['left']) ) : ?>
			<div class="<?php echo esc_attr($sidebar_configs['left']['class']) ;?>">
			  	<aside class="sidebar sidebar-left" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
			  		<?php if ( is_active_sidebar( $sidebar_configs['left']['sidebar'] ) ): ?>
			   			<?php dynamic_sidebar( $sidebar_configs['left']['sidebar'] ); ?>
			   		<?php endif; ?>
			  	</aside>
			</div>
		<?php endif; ?>

		<?php if ( isset($sidebar_configs['right']) ) : ?>
			<div class="<?php echo esc_attr($sidebar_configs['right']['class']) ;?>">
			  	<aside class="sidebar sidebar-right" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
			   		<?php if ( is_active_sidebar( $sidebar_configs['right']['sidebar'] ) ): ?>
				   		<?php dynamic_sidebar( $sidebar_configs['right']['sidebar'] ); ?>
				   	<?php endif; ?>
			  	</aside>
			</div>
		<?php endif; ?>
		
	</div>
</section>
<?php get_footer(); ?>