<?php

get_header();

$sidebar_configs = homesweet_get_blog_layout_configs();

homesweet_render_breadcrumbs();
?>


<section id="main-container" class="main-content <?php echo apply_filters( 'homesweet_blog_content_class', 'container' ); ?> inner">
	<div class="row">
		<?php
            $class = '';
            if ( isset($sidebar_configs['left']) ) {
                $class = 'pull-right';
            }
        ?>

		<div id="main-content" class="col-xs-12 <?php echo esc_attr($sidebar_configs['main']['class'].' '.$class); ?>">
			<div id="primary" class="content-area">
				<div id="content" class="site-content detail-post" role="main">
					<?php
						// Start the Loop.
						while ( have_posts() ) : the_post();

							/*
							 * Include the post format-specific template for the content. If you want to
							 * use this in a child theme, then include a file called called content-___.php
							 * (where ___ is the post format) and that will be used instead.
							 */
							?>
							<div class="box-shadow">
							<?php
							get_template_part( 'post-formats/content', get_post_format() );

							//Previous/next post navigation.
							the_post_navigation( array(
								'next_text' => '<span class="navi-content"><span class="meta-nav" aria-hidden="true">' . esc_html__( 'Next', 'homesweet' ) . '</span> ' .
									'<span class="pull-right navi">' . esc_html__( 'Next post:', 'homesweet' ) . '</span> ' .
									'<span class="post-title">%title</span></span><i class="icon-ap_arrow-right"></i>',
								'prev_text' => '<i class="icon-ap_arrow-left"></i><span class="navi-content"><span class="meta-nav" aria-hidden="true">' . esc_html__( 'Previous', 'homesweet' ) . '</span> ' .
									'<span class="pull-left navi">' . esc_html__( 'Previous post:', 'homesweet' ) . '</span> ' .
									'<span class="post-title">%title</span></span>',
							) );
							get_template_part( 'page-templates/author-bio' );
							?>
							</div>
							<?php 

							if ( homesweet_get_config('show_blog_releated', true) ): ?>
								<?php get_template_part( 'page-templates/parts/posts-releated' ); ?>
			                <?php

			                endif;
			                // If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
						// End the loop.
						endwhile;
					?>
				</div><!-- #content -->
			</div><!-- #primary -->
		</div>
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