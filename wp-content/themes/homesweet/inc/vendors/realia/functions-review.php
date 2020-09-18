<?php

// comment template
function homesweet_realia_comments_template_loader($template) {
    if ( get_post_type() !== 'property' ) {
        return $template;
    }
    return get_template_directory() . '/templates/single/reviews.php';
}
add_filter( 'comments_template', 'homesweet_realia_comments_template_loader' );

// comment list
function homesweet_realia_comments( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    set_query_var( 'comment', $comment );
    set_query_var( 'args', $args );
    set_query_var( 'depth', $depth );
    get_template_part( 'templates/single/review' );
}
// add comment meta
function homesweet_add_custom_comment_field( $comment_id, $comment_approved, $commentdata ) {
    $post_id = $commentdata['comment_post_ID'];
    $post = get_post($post_id);
    if ( $post->post_type == 'property' ) {
        add_comment_meta( $comment_id, '_apus_rating', $_POST['rating'] );
    }
}
add_action( 'comment_post', 'homesweet_add_custom_comment_field', 10, 3 );

function homesweet_get_total_reviews( $post_id ) {
    $comments = get_comments( array('post_id' => $post_id, 'status' => 'approve') );
    if (empty($comments)) {
        return 0;
    }
    
    return count($comments);
}

function homesweet_get_total_rating( $post_id ) {
    $comments = get_comments( array('post_id' => $post_id, 'status' => 'approve') );
    if (empty($comments)) {
        return 0;
    }
    $total_review = 0;
    foreach ($comments as $comment) {
        $rating = intval( get_comment_meta( $comment->comment_ID, '_apus_rating', true ) );
        if ($rating) {
            $total_review += (int)$rating;
        }
    }
    return $total_review/count($comments);
}

function homesweet_print_review( $rate, $type = '', $nb = 0 ) {
    ?>
    <div class="review-stars-rated-wrapper">
        <div class="review-stars-rated">
            <ul class="review-stars">
                <li><span class="fa fa-star"></span></li>
                <li><span class="fa fa-star"></span></li>
                <li><span class="fa fa-star"></span></li>
                <li><span class="fa fa-star"></span></li>
                <li><span class="fa fa-star"></span></li>
            </ul>
            
            <ul class="review-stars filled"  style="<?php echo esc_attr( 'width: ' . ( $rate * 20 ) . '%' ) ?>" >
                <li><span class="fa fa-star"></span></li>
                <li><span class="fa fa-star"></span></li>
                <li><span class="fa fa-star"></span></li>
                <li><span class="fa fa-star"></span></li>
                <li><span class="fa fa-star"></span></li>
            </ul>
        </div>
        <?php if ($type == 'detail') { ?>
            <span class="nb-review"><?php echo sprintf(_n('%d Review', '%d Reviews', $nb, 'homesweet'), $nb); ?></span>
        <?php } elseif ($type == 'list') { ?>
            <span class="nb-review"><?php echo sprintf('(%d)', $nb); ?></span>
        <?php } ?>
    </div>
    <?php
}


function homesweet_get_detail_ratings( $post_id ) {
    global $wpdb;
    $comment_ratings = $wpdb->get_results( $wpdb->prepare(
        "
            SELECT cm2.meta_value AS rating, COUNT(*) AS quantity FROM $wpdb->posts AS p
            INNER JOIN $wpdb->comments AS c ON p.ID = c.comment_post_ID
            INNER JOIN $wpdb->commentmeta AS cm2 ON cm2.comment_id = c.comment_ID AND cm2.meta_key=%s
            WHERE p.ID=%d
            GROUP BY cm2.meta_value",
            '_apus_rating',
            $post_id
        ), OBJECT_K
    );
    return $comment_ratings;
}
