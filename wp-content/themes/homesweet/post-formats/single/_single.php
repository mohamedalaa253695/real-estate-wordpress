<?php
$post_format = get_post_format();
global $post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
	<div class="entry-content-detail">
        <?php if ( $post_format == 'gallery' ) {
            $gallery = homesweet_post_gallery( get_the_content(), array( 'size' => 'full' ) );
        ?>
            <div class="entry-thumb <?php echo  (empty($gallery) ? 'no-thumb' : ''); ?>">
                <?php echo trim($gallery); ?>
            </div>
        <?php } elseif( $post_format == 'link' ) {
                $format = homesweet_post_format_link_helper( get_the_content(), get_the_title() );
                $title = $format['title'];
                $link = homesweet_get_link_attributes( $title );
                $thumb = homesweet_post_thumbnail('', $link);
                echo trim($thumb);
            } else { ?>
            <div class="entry-thumb <?php echo  (!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
                <?php
                    $thumb = homesweet_post_thumbnail();
                    echo trim($thumb);
                ?>
            </div>
        <?php } ?>
        <div class="box-white">
            <div class="entry-meta">
                <div class="info">
                    <?php if (get_the_title()) { ?>
                        <h4 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                    <?php } ?>
                    <div class="meta">
                        <span class="author"><?php the_author_posts_link(); ?></span>
                        <span class="date"><?php the_time( get_option('date_format', 'd M, Y') ); ?></span>
                        <span class="comment"><?php comments_number( '0 Comment', '1 Comments', '% Comments' ); ?></span>
                    </div>
                </div>
            </div>
        	<div class="single-info info-bottom">
                <div class="entry-description">
                    <?php
                        if ( $post_format == 'gallery' ) {
                            $gallery_filter = homesweet_gallery_from_content( get_the_content() );
                            echo trim($gallery_filter['filtered_content']);
                        } else {
                            the_content();
                        }
                    ?>
                </div><!-- /entry-content -->
        		<?php
        		wp_link_pages( array(
        			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'homesweet' ) . '</span>',
        			'after'       => '</div>',
        			'link_before' => '<span>',
        			'link_after'  => '</span>',
        			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'homesweet' ) . ' </span>%',
        			'separator'   => '',
        		) );
        		?>
        	</div>
        </div>
        <?php homesweet_post_tags(); ?>
        <?php if( homesweet_get_config('show_blog_social_share', false) ) {
            get_template_part( 'page-templates/parts/sharebox' );
        } ?>
    </div>
</article>