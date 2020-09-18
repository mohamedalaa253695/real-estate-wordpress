<?php $thumbsize = !isset($thumbsize) ? homesweet_get_blog_thumbsize() : $thumbsize;?>

<article <?php post_class('post post-grid'); ?>>
    <?php
        $thumb = homesweet_display_post_thumb($thumbsize);
        echo trim($thumb);
    ?>
    <div class="entry-content <?php echo !empty($thumb) ? '' : 'no-thumb'; ?>">
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
        <div class="more clearfix">
            <div class="pull-left">
                <a class="btn-readmore" href="<?php the_permalink(); ?>"> <span><?php echo esc_html__('Read Article','homesweet'); ?></span></a>
            </div>
            <div class="pull-right">
                <a class="btn-readmore" href="<?php the_permalink(); ?>"> <i class="icon-ap_arrow-right"></i></a>
            </div>
        </div>
    </div>
</article>
