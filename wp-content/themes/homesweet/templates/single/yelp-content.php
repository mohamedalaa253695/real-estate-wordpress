<?php

foreach ($terms as $key => $term) {
    $cate_title = '';
    $cate_icon = '';
    $cate_term = '';

    if (array_key_exists($term, $all_cats)) {
        $cate_title = !empty($terms_title[$key]) ? $terms_title[$key] : (isset($all_cats[$term]) ? $all_cats[$term] : '');
        if ( !empty($terms_icon[$key]) && !empty($terms_icon[$key]['url']) ) {
        	$cate_icon = $terms_icon[$key]['url'];
        }
        $cate_term = str_replace('-', '+', $term);
    }
    $options = array( 'http' => array(
        'method' => "GET",
        'header' => "Authorization: Bearer " . $access_token . "\r\n"
    ) );
    $context = stream_context_create($options);

    $data = homesweet_realia_get_file_contents('https://api.yelp.com/v3/businesses/search?term=' . $cate_term . '&latitude=' . $map_location['latitude'] . '&longitude=' . $map_location['longitude'] . '&limit=' . $limit, false, $context);

    if ($data) {
        $data = json_decode($data, true);

        if (is_array($data) && isset($data['businesses']) && !empty($data['businesses'])) {
        	?>
    		<div class="yelp-list">
	            <div class="yelp-list-cat">
					<div class="yelp-cat-title">
						<?php if ( !empty($cate_icon) ) { ?>
							<img src="<?php echo esc_url($cate_icon); ?>" alt="">
						<?php } ?>
						<h5><?php echo esc_html($cate_title); ?></h5>
					</div>
					<div class="yelp-cat-content">
						<ul class="yelp-list-sub">
							<?php
				            foreach ($data['businesses'] as $data_business) {
				                $business_url = isset($data_business['url']) ? $data_business['url'] : '';
				                $business_name = isset($data_business['name']) ? $data_business['name'] : '';
				                $business_total_reviews = isset($data_business['review_count']) ? $data_business['review_count'] : '';
				                $business_rating = isset($data_business['rating']) ? $data_business['rating'] : '';
				                $business_distance = isset($data_business['distance']) ? $data_business['distance'] : '';
				                if ( $business_distance ) {
				                	$business_distance = round(($business_distance * 0.001), 2);
				                }
				                ?>
				                <li>
				                	<div class="media">
					                    <div class="media-left media-middle">
											<div class="media-title">
					                            <a href="<?php echo esc_url_raw($business_url); ?>" target="_blank"><?php echo esc_html($business_name); ?></a>
					                            <?php if ( !empty($business_distance) ) { ?>
					                            	<span><?php echo sprintf(__('(%s km)', 'homesweet'), $business_distance); ?></span>
					                            <?php } ?>
						                    </div>
										</div>
						                <div class="media-body text-right media-middle">
						                    <div class="apus-ratings">
						                    	<?php $star_img = homesweet_get_yelp_star_img($business_rating); ?>
						                        <div class="rating">
						                            <img src="<?php echo esc_url( get_template_directory_uri() . '/images/stars/'.$star_img ); ?>" alt="">
						                        </div>
						                        <span class="rating-count"><?php echo sprintf(_n('%d Review', '%d Reviews', absint($business_total_reviews), 'homesweet'), absint($business_total_reviews)); ?></span>
						                    </div>
						                </div>
					                </div>
				                </li>
				            <?php
				            }
				            ?>
	            		</ul>
	            	</div>
	            </div>
            </div>
        <?php
        }
    }
    ?>
    
<?php
}