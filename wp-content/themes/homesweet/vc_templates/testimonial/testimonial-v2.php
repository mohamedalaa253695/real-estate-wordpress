<?php
   $job = get_post_meta( get_the_ID(), 'apus_testimonial_job', true );
   $link = get_post_meta( get_the_ID(), 'apus_testimonial_link', true );
?>
<div class="testimonial-v2">
    <?php if ( !empty($img) && isset($img[0]) ): ?>
        <div class="test-icon">
            <img src="<?php echo esc_url_raw($img[0]); ?>" alt="">
        </div>
    <?php endif; ?>
    <div class="left-content">
      <div class="description">
         <?php the_content(); ?>
      </div>
      <div class="testimonial-meta clearfix">
        <div class="info">
            <?php if (!empty($link)) { ?>
              <h3 class="name-client"><a href="<?php echo esc_url_raw($link); ?>"><?php the_title(); ?></a></h3>
            <?php } else { ?>
              <h3 class="name-client"><?php the_title(); ?></h3>
            <?php } ?>
            <span class="job"> - <?php echo sprintf(__('%s', 'homesweet'), $job); ?></span>
        </div>
      </div>
    </div>
</div>