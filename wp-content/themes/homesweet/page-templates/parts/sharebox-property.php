<?php

global $post;
$args = array( 'position' => 'top', 'animation' => 'true' );
?>
<div class="apus-social-share">
	<div class="bo-social-icons bo-sicolor social-radius-rounded">
		<?php if ( homesweet_get_config('facebook_share', 1) ): ?>
			<a class="bo-social-facebook" href="" onclick="javascript: window.open('http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>'); return false;" target="_blank" title="<?php echo esc_html__('Share on facebook', 'homesweet'); ?>">
				<i class="fa fa-facebook"></i>
			</a>
 
		<?php endif; ?>
		<?php if ( homesweet_get_config('twitter_share', 1) ): ?>
 
			<a class="bo-social-twitter" href="" onclick="javascript: window.open('http://twitter.com/home?status=<?php echo urlencode(get_the_title()); ?> <?php the_permalink(); ?>'); return false;" target="_blank" title="<?php echo esc_html__('Share on Twitter', 'homesweet'); ?>">
				<i class="fa fa-twitter"></i>
			</a>
 
		<?php endif; ?>
		<?php if ( homesweet_get_config('linkedin_share', 1) ): ?>
 
			<a class="bo-social-linkedin" href="" onclick="javascript: window.open('http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php echo urlencode(get_the_title()); ?>'); return false;" target="_blank" title="<?php echo esc_html__('Share on LinkedIn', 'homesweet'); ?>">
				<i class="fa fa-linkedin"></i>
			</a>
 
		<?php endif; ?>
		<?php if ( homesweet_get_config('tumblr_share', 1) ): ?>
 
			<a class="bo-social-tumblr" href="" onclick="javascript: window.open('http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink()); ?>&amp;name=<?php echo urlencode($post->post_title); ?>&amp;description=<?php echo urlencode(get_the_excerpt()); ?>'); return false;" target="_blank" title="<?php echo esc_html__('Share on Tumblr', 'homesweet'); ?>">
				<i class="fa fa-tumblr"></i>
			</a>
 
		<?php endif; ?>
		<?php if ( homesweet_get_config('google_share', 1) ): ?>
 
			<a class="bo-social-google" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
	'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" title="<?php echo esc_html__('Share on Google plus', 'homesweet'); ?>">
				<i class="fa fa-google-plus"></i>
			</a>
 
		<?php endif; ?>
		<?php if ( homesweet_get_config('pinterest_share', 1) ): ?>
			<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			$media = '';
			if ( isset($full_image[0]) ) {
				$media = '&amp;media='.urlencode($full_image[0]);
			}
			?>
			<a class="bo-social-pinterest" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&amp;description=<?php echo urlencode($post->post_title); ?><?php echo trim($media); ?>" target="_blank" title="<?php echo esc_html__('Share on Pinterest', 'homesweet'); ?>">
				<i class="fa fa-pinterest"></i>
			</a>
 
		<?php endif; ?>
	</div>
</div>	