<?php

global $post;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}
$total_rating = homesweet_get_total_rating( get_the_ID() );
$comment_ratings = homesweet_get_detail_ratings( get_the_ID() );
$total = homesweet_get_total_reviews( get_the_ID() );
?>
<div id="property-section-comments" class="course-rating property-section clearfix">
	<h3 class="title-rating"><?php esc_html_e( 'Reviews', 'homesweet' ); ?></h3>
	<div class="box-inner clearfix">
		<div class="detailed-rating pull-left">
			<div class="rating-box">
				<div class="detailed-rating-inner">
					<?php for ( $i = 5; $i >= 1; $i -- ) : ?>
						<div class="skill">
							<div class="key" title="<?php printf( esc_html__( '%s stars', 'homesweet' ), $i ); ?>"><?php homesweet_print_review( $i ); ?></div>
							<div class="value"><?php echo empty( $comment_ratings[$i]->quantity ) ? '0' : esc_html( $comment_ratings[$i]->quantity ); ?></div>
							<div class="wrapper-progress">
								<div class="progress">
									<div class="progress-bar progress-bar-info" style="<?php echo ( $total && !empty( $comment_ratings[$i]->quantity ) ) ? esc_attr( 'width: ' . ( $comment_ratings[$i]->quantity / $total * 100 ) . '%' ) : 'width: 0%'; ?>">
									</div>
								</div>
							</div>
						</div>
					<?php endfor; ?>
				</div>
			</div>
		</div>

		<div class="average-rating pull-right">
			<div class="rating-box">
				<div class="review-star">
					<?php homesweet_print_review( $total_rating ); ?>
				</div>
				<div class="average-value"><?php echo ( $total_rating ) ? esc_html( round( $total_rating, 1 ) ) : 0; ?></div>
				<div class="review-text">
					<?php esc_html_e('Overall rating', 'homesweet'); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="comments" class="property-section">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title"><?php comments_number( esc_html__('0 Comment', 'homesweet'), esc_html__('1 Comment', 'homesweet'), esc_html__('% Comments', 'homesweet') ); ?></h3>
		<ol class="comment-list">
			<?php wp_list_comments( array( 'callback' => 'homesweet_realia_comments' ) ); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
			echo '<nav class="apus-pagination">';
			paginate_comments_links( apply_filters( 'apus_comment_pagination_args', array(
				'prev_text' => '&larr;',
				'next_text' => '&rarr;',
				'type'      => 'list',
			) ) );
			echo '</nav>';
		endif; ?>

	<?php else : ?>

		<p class="apus-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'homesweet' ); ?></p>

	<?php endif; ?>
</div>
<div id="reviews">
		<div id="review_form_wrapper" class="commentform">
			<div id="review_form">
				<?php
					$commenter = wp_get_current_commenter();

					$comment_form = array(
						'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'homesweet' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'homesweet' ), get_the_title() ),
						'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'homesweet' ),
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'fields'               => array(
							'author' => '<div class="row"><div class="col-xs-12 col-sm-6"><div class="form-group">'.
							            '<input id="author" placeholder="'.esc_html__( 'Name', 'homesweet' ).'" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></div></div>',
							'email'  => '<div class="col-xs-12 col-sm-6"><div class="form-group">' .
							            '<input id="email" class="form-control" placeholder="'.esc_html__( 'Email', 'homesweet' ).'" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></div></div></div>',
							            'url' => '<div class="form-group hidden">
	                                            <input id="url" placeholder="'.esc_html__('Website', 'homesweet').'" name="url" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '"  />
	                                       	</div>',
						),
						'label_submit'  => esc_html__( 'REVIEW', 'homesweet' ),
						'logged_in_as'  => '',
						'comment_field' => ''
					);

					$comment_form['must_log_in'] = '<div class="must-log-in">' .  esc_html__( 'You must be logged in to post a review.', 'homesweet' ) . '</div>';

					
					
					$comment_form['comment_field'] = '<div class="form-group"><textarea id="comment" placeholder="'.esc_html__('Comment', 'homesweet').'" class="form-control" name="comment" cols="45" rows="5" aria-required="true"></textarea></div>';

					$comment_form['comment_field'] .= '<div class="form-group yourview"><span>' . esc_html__( 'Your Rating', 'homesweet' ) . '</span><div class="comment-form-rating">
						<ul class="review-stars">
							<li><span class="fa fa-star-o"></span></li>
							<li><span class="fa fa-star-o"></span></li>
							<li><span class="fa fa-star-o"></span></li>
							<li><span class="fa fa-star-o"></span></li>
							<li><span class="fa fa-star-o"></span></li>
						</ul>
						<ul class="review-stars filled" style="width: 100%">
							<li><span class="fa fa-star"></span></li>
							<li><span class="fa fa-star"></span></li>
							<li><span class="fa fa-star"></span></li>
							<li><span class="fa fa-star"></span></li>
							<li><span class="fa fa-star"></span></li>
						</ul>
						<input type="hidden" value="5" name="rating" id="apus_input_rating"></div></div>';

					homesweet_comment_form($comment_form);
				?>
			</div>
		</div>
	<div class="clear"></div>
</div>