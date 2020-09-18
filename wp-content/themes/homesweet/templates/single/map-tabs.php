<!-- MAP LOCATION -->
<?php
    $map_location = get_post_meta( get_the_ID(), REALIA_PROPERTY_PREFIX . 'map_location', true );
    
    $places = homesweet_get_config('nearby_place_category');
    $places_title = homesweet_get_config('nearby_place_title');
    $places_icon_font = homesweet_get_config('nearby_place_icon_font');
    $places_icon_image = homesweet_get_config('nearby_place_image_icon');
    $places_marker_icon = homesweet_get_config('nearby_place_marker');
?>

<?php if ( ! empty( $map_location ) && 2 == count( $map_location ) ) : ?>
    <!-- MAP -->
    <div class="property-map-position property-section">
        <div class="heading clearfix">
            <h3 class="title pull-left"><?php echo esc_html__('Location', 'homesweet'); ?></h3>
            <ul class="nav nav-tabs pull-right fill-map" role="tablist">
                <li class="active" data-toggle="tooltip" data-placement="top" title="<?php echo esc_html__('Map View', 'homesweet'); ?>">
                    <a class="tab-google-map" aria-expanded="false" href="#tab-google-map" role="tab" data-toggle="tab"><i class="fa fa-map"></i></a>
                </li>
                <li data-toggle="tooltip" data-placement="top" title="<?php echo esc_html__('Street View', 'homesweet'); ?>">
                    <a class="tab-google-street-view-map" aria-expanded="false" href="#tab-google-street-view-map" role="tab" data-toggle="tab"><i class="fa fa-street-view"></i></a>
                </li>
            </ul>
        </div>
        <div class="tab-content" >
            <?php
            $marker_icon = homesweet_get_config('map_marker_icon');
            ?>
            <div id="tab-google-map" class="tab-pane fade out active in single-property-map-wrap">
                <div id="single-property-map"
                    data-latitude="<?php echo esc_attr( $map_location['latitude'] ); ?>"
                    data-longitude="<?php echo esc_attr( $map_location['longitude'] ); ?>"
                    data-zoom="<?php echo esc_attr(homesweet_get_config('map_zoom', 15)); ?>"
                    <?php echo (homesweet_get_config('map_custom_style') ? 'data-style="'.esc_attr(homesweet_get_config('map_custom_style')).'"' : ''); ?>
                    <?php echo (isset($marker_icon['url']) ? 'data-icon_image="'.esc_attr($marker_icon['url']).'"' : ''); ?>>
                </div><!-- /.map -->
                <?php if ( $places ) { ?>
                    <div class="property-search-places">
                        <div class="places-wrap">
                            
                            <?php
                                foreach ($places as $key => $value) {
                                    $icon_url = '';
                                    if ( !empty($places_marker_icon[$key]) && !empty($places_marker_icon[$key]['url']) ) {
                                        $icon_url = $places_marker_icon[$key]['url'];
                                    }
                                    $label = '';
                                    if ( !empty($places_title[$key]) ) {
                                        $label = $places_title[$key];
                                    }
                                ?>
                                        <div class="place-btn" data-type="<?php echo esc_attr($value); ?>" data-icon_image="<?php echo esc_url($icon_url); ?>"  data-toggle="tooltip" title="<?php echo esc_attr($label); ?>">
                                            <?php
                                            if ( !empty($places_icon_image[$key]) && !empty($places_icon_image[$key]['url']) ) {
                                                ?>
                                                <img src="<?php echo esc_url($places_icon_image[$key]['url']); ?>" alt="<?php echo esc_attr($label); ?>">
                                                <?php
                                            } elseif ( !empty($places_icon_font[$key]) ) {
                                                ?>
                                                <i class="<?php echo esc_attr($places_icon_font[$key]); ?>"></i>
                                                <?php
                                            } else {
                                                echo esc_attr($label);
                                            }
                                            ?>
                                        </div>
                                <?php
                                }
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div id="tab-google-street-view-map" class="tab-pane fade out">
                <div id="single-property-street-view-map" style="height: 400px"></div>
            </div>
        </div>
    </div><!-- /.map-position -->
<?php endif; ?>