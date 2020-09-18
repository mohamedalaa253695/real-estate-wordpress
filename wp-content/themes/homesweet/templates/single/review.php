<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$rating = intval( get_comment_meta( $comment->comment_ID, '_apus_rating', true ) );

?>
<li itemprop="review" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="the-comment media">
		<div class="avatar media-left">
			<?php echo get_avatar( $comment, '60', '' ); ?>
		</div>
		<div class="comment-box media-body">
			<div class="clearfix">
				<div class="pull-right date-rating">
					<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( esc_html__( 'Rated %d out of 5', 'homesweet' ), $rating ) ?>">
						<?php homesweet_print_review($rating); ?>
					</div>
					<div class="date">
						<?php if ( $comment->comment_approved == '0' ) : ?>
							<span class="meta"><em><?php esc_html_e( 'Your comment is awaiting approval', 'homesweet' ); ?></em></span>
						<?php else : ?>
							<span class="meta">
								<time itemprop="datePublished" datetime="<?php echo get_comment_date( 'c' ); ?>"><?php echo get_comment_date( 'd/m/Y' ); ?></time>
							</span>
						<?php endif; ?>
					</div>
				</div>
				<div class="comment-author pull-left">
					<?php comment_author(); ?>
				</div>
			</div>
			<div itemprop="description" class="comment-text"><?php comment_text(); ?></div>
		</div>
	</div>
</li>