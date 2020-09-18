<?php

if ($walkscore_api_key != '') {
	$address = get_post_meta( $property_id, REALIA_PROPERTY_PREFIX.'address', true );

	$datas = wp_remote_get('http://api.walkscore.com/score?format=json&transit=1&bike=1&address='.urlencode($address).'&lat='.urlencode($map_location['latitude']).'&lon='.urlencode($map_location['longitude']).'&wsapikey='.urlencode($walkscore_api_key));

	if (is_array($datas)) {
        $datas = json_decode($datas['body'], true);
        ?>
        <ul class="walks-core-list">
            <?php if (isset($datas['status']) && $datas['status'] == 1) : ?>
                <?php if (isset($datas['walkscore'])) : ?>
                    <li>
                    	<div class="media">
                    		<div class="media-left media-middle"><span class="walkscore-score"><?php echo trim($datas['walkscore']); ?></span></div>
                    		<div class="media-body media-middle">
                    			<a href="<?php echo esc_url($datas['ws_link']); ?>" target="_blank"><strong><?php esc_html_e('Walk Scores', 'homesweet'); ?></strong></a>
	                            <address><?php echo trim($datas['description']); ?></address>
                    		</div>
                    		<div class="media-right  media-middle">
                    			<a href="<?php echo esc_url($datas['ws_link']); ?>" class="more-detail" target="_blank"><?php esc_html_e('View more', 'homesweet'); ?></a>
                    		</div>
                    	</div>
                    </li>
                <?php endif; ?>
                <?php if (isset($datas['transit']) && !empty($datas['transit']['score'])) : ?>
                    <li class="walkscore-transit">
                    	<div class="media">
                    		<div class="media-left media-middle"><span class="walkscore-score"><?php echo trim($datas['transit']['score']); ?></span></div>
                    		<div class="media-body media-middle">
                    			<a href="<?php echo trim($datas['ws_link']); ?>" target="_blank"><strong><?php esc_html_e('Transit Score', 'homesweet'); ?></strong></a>
	                            <address><?php echo trim($datas['transit']['description']); ?></address>
                    		</div>
                    		<div class="media-right  media-middle">
                    			<a href="<?php echo esc_url($datas['ws_link']); ?>" class="more-detail" target="_blank"><?php esc_html_e('View more', 'homesweet'); ?></a>
                    		</div>
                    	</div>
                    </li>
                <?php endif; ?>
                <?php if (isset($datas['bike']) && !empty($datas['bike']['score'])) : ?>
                    <li class="walkscore-bike">
                    	<div class="media">
                    		<div class="media-left media-middle"><span class="walkscore-score"><?php echo trim($datas['bike']['score']); ?></span></div>
                    		<div class="media-body media-middle">
                    			<a href="<?php echo esc_url($datas['ws_link']); ?>" target="_blank"><strong><?php esc_html_e('Bike Score', 'homesweet'); ?></strong></a>
	                            <address><?php echo trim($datas['bike']['description']); ?></address>
                    		</div>
                    		<div class="media-right  media-middle">
                    			<a href="<?php echo esc_url($datas['ws_link']); ?>" class="more-detail" target="_blank"><?php esc_html_e('View more', 'homesweet'); ?></a>
                    		</div>
                    	</div>
                    </li>
                <?php endif; ?>

            <?php else: ?>
                <li>
                    <?php  esc_html_e('An error occurred while fetching walk scores.', 'homesweet'); ?>
                </li>
            <?php endif; ?>
        </ul>
        <?php
    }
}