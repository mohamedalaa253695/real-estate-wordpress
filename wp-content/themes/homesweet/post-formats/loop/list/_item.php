<?php $thumbsize = !isset($thumbsize) ? homesweet_get_blog_thumbsize() : $thumbsize;?>
<article <?php post_class('post list-default'); ?>>
    <div class="row list-inner">
        <?php
            $thumb = homesweet_display_post_thumb($thumbsize);
            if ( !empty($thumb) ) {
                ?>
                <div class="col-sm-5 image">
                    <?php echo trim($thumb); ?>
                </div>
                <?php
            }
        ?>
        <div class="col-sm-<?php echo esc_attr(!empty($thumb) ? '7' : '12'); ?> info">
          <div class="info-content">
            <?php
                if (get_the_title()) {
                ?>
                    <h4 class="entry-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h4>
                <?php
            }
            ?>
            <div class="date">
                <i class="text-theme icon-ap_clock"></i><?php the_time( get_option('date_format', 'M d, Y') ); ?>
            </div>
            <?php if ( has_excerpt() ) { ?>
                <div class="description"><?php echo homesweet_substring( get_the_excerpt(), 50, '...' ); ?></div>
            <?php } ?>
          </div>
        </div>
    </div>
</article>