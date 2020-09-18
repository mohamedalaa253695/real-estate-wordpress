var placesIDs = Array(),
        nearbyMarkers = Array(),
        markers = Array();
jQuery( document ).ready(function($) {

    var infobox = new InfoBox({
        disableAutoPan: true, //false
        maxWidth: 275,
        alignBottom: true,
        pixelOffset: new google.maps.Size(-122, -48),
        zIndex: null,
        closeBoxMargin: "0 0 -16px -16px",
        closeBoxURL: '#',
        infoBoxClearance: new google.maps.Size(1, 1),
        isHidden: false,
        pane: "floatPane",
        enableEventPropagation: false
    });
    var propertyInfo = new InfoBox({
        disableAutoPan: false,
        maxWidth: 250,
        pixelOffset: new google.maps.Size(-72, -70),
        zIndex: null,
        boxStyle: {
            'background' : '#ffffff',
            'opacity'    : 1,
            'padding'    : '6px',
            'box-shadow' : '0 1px 2px 0 rgba(0, 0, 0, 0.12)',
            'width'      : '145px',
            'text-align' : 'center',
            'border-radius' : '4px'
        },
        closeBoxMargin: "28px 26px 0px 0px",
        closeBoxURL: "",
        infoBoxClearance: new google.maps.Size(1, 1),
        pane: "floatPane",
        enableEventPropagation: false
    });

	// map
	var ApusThemeMap = {

		init: function() {
            // google map element
            
            if ($('#widget-properties-map-wrapper').length > 0) {
                var map = $('#widget-properties-map-wrapper');
                map.mapescape();
                map.addClass('loading');
                $.ajax({
                    url: homesweet_ajax.ajaxurl,
                    type:'POST',
                    dataType: 'json',
                    data:  'action=homesweet_properties_map&number=' + map.data('number') + '&types=' + map.data('types') + '&contract=' + map.data('contract')
                        + '&orderby=' + map.data('statuses') + '&statuses=' + map.data('statuses') + '&locations=' + map.data('locations')
                }).done(function(markers) {
                    map.google_map({
                        geolocation: false,
                        infowindow: {
                            borderBottomSpacing: 0,
                            height: 120,
                            width: 424,
                            offsetX: 48,
                            offsetY: -87
                        },
                        zoom: 15,
                        marker: {
                            height: 56,
                            width: 56
                        },
                        cluster: {
                            height: 56,
                            width: 56,
                            gridSize: 60
                        },
                        styles: map.data('style'),
                        transparentMarkerImage: homesweet_ajax.transparent_marker,
                        transparentClusterImage: homesweet_ajax.transparent_marker,
                        markers: markers
                    });
                    setTimeout(function(){
                        map.removeClass('loading');
                    }, 200);
                });
            }
			
			// single property Tab Gallery map
			ApusThemeMap.initSingleTabMap();

            // single property map
            ApusThemeMap.initSingleMap();
		},
        initSingleTabMap: function() {
            if ( $('#tab-single-property-map').length > 0 ) {
                var $item = $('#tab-single-property-map');
                var lat = $item.data('latitude');
                var lng = $item.data('longitude');
                var propertyMap = null;
                var panorama = null;
                var fenway = new google.maps.LatLng(lat, lng);
                var mapOptions = {
                    center: fenway,
                    zoom: $item.data('zoom'),
                    scrollwheel: false
                };
                var panoramaOptions = {
                    position: fenway,
                    pov: {
                        heading: 34,
                        pitch: 10
                    }
                };

                $('.tabs-gallery-map .tab-google-street-view-map').click(function(){
                    if ( panorama == null ) {
                        setTimeout( function(){
                            panorama = new google.maps.StreetViewPanorama(document.getElementById('single-tab-property-street-view-map'), panoramaOptions);
                        } , 50);
                    }
                });
                if ($('.tabs-gallery-map .tab-google-map').parent().hasClass('active')) {
                    if ( propertyMap == null ) {
                        setTimeout( function(){
                            propertyMap = new google.maps.Map(document.getElementById('tab-single-property-map'), mapOptions);
                            propertyMap.setOptions({styles: $item.data('style')});
                            ApusThemeMap.addMarkers($item, propertyMap);
                            var propertyControl = new ApusThemeMap.propertyControls( propertyMap, propertyMap.getCenter() );
                        } , 50);
                    }
                }
                $('.tabs-gallery-map .tab-google-map, .tabs-content-agent .tab-google-map').click(function(){
                    if ( propertyMap == null ) {
                        setTimeout( function(){
                            propertyMap = new google.maps.Map(document.getElementById('tab-single-property-map'), mapOptions);
                            propertyMap.setOptions({styles: $item.data('style')});
                            ApusThemeMap.addMarkers($item, propertyMap);
                            var propertyControl = new ApusThemeMap.propertyControls( propertyMap, propertyMap.getCenter() );
                        } , 50);
                    }
                });
            }
        },
        initSingleMap: function() {
            if ( $('#single-property-map').length > 0 ) {
                var $item = $('#single-property-map');
                var lat = $item.data('latitude');
                var lng = $item.data('longitude');
                var propertyMap = null;
                var panorama = null;
                var fenway = new google.maps.LatLng(lat, lng);
                var mapOptions = {
                    center: fenway,
                    zoom: $item.data('zoom'),
                    scrollwheel: false
                };
                var panoramaOptions = {
                    position: fenway,
                    pov: {
                        heading: 34,
                        pitch: 10
                    }
                };

                $('.property-map-position .tab-google-street-view-map').click(function(){
                    if ( panorama == null ) {
                        setTimeout( function(){
                            panorama = new google.maps.StreetViewPanorama(document.getElementById('single-property-street-view-map'), panoramaOptions);
                        } , 50);
                    }
                });
                if ( $('.tabs-content-layout #tab-content-map-tabs').length > 0 ) {
                    $( '[href="#tab-content-map-tabs"]' ).click(function(){
                        if ( propertyMap == null ) {
                            propertyMap = new google.maps.Map(document.getElementById('single-property-map'), mapOptions);
                            propertyMap.setOptions({styles: $item.data('style')});
                            ApusThemeMap.addMarkers($item, propertyMap);
                            var propertyControl = new ApusThemeMap.propertyControls( propertyMap, propertyMap.getCenter() );
                        }
                    });
                } else {
                    propertyMap = new google.maps.Map(document.getElementById('single-property-map'), mapOptions);
                    propertyMap.setOptions({styles: $item.data('style')});
                    ApusThemeMap.addMarkers($item, propertyMap);
                    var propertyControl = new ApusThemeMap.propertyControls( propertyMap, propertyMap.getCenter() );
                }
            }
        },
        // add makers
		addMarkers: function( $item, propertyMap ) {
			var lat = $item.data('latitude');
			var lng = $item.data('longitude');
            var latlng = new google.maps.LatLng(lat, lng);
            
            var marker = new google.maps.Marker({
                position: latlng,
                map: propertyMap,
                draggable: false,
                animation: google.maps.Animation.DROP,
                icon: $item.data('icon_image')
            });

            markers.push(marker);
        },

		tooglePoints: function( place_item, position, propertyMap, propertyType, status) {
            var service = new google.maps.places.PlacesService( propertyMap );
            var bounds = propertyMap.getBounds();
            var types = new Array();
            
            types = [propertyType];

            if ( status == false ) {
                if ( nearbyMarkers[propertyType] && nearbyMarkers[propertyType].length > 0 ){
                    for ( var i=0 ; i < nearbyMarkers[propertyType].length; i++ ) {
                        nearbyMarkers[propertyType][i].setMap( null  ); 
                    }
                    nearbyMarkers[propertyType] = [];
                }
            } else {
                var placemarkers = [];
                service.nearbySearch({
                    location: position,
                    bounds: bounds,
                    radius: 2000,
                    types: types
                }, function propertyCallback( results, status ) {
                    if ( status === google.maps.places.PlacesServiceStatus.OK ) {
                        for ( var i = 0; i < results.length; i++ ) {
                            var amarker = ApusThemeMap.propertyNearby(place_item, results[i], propertyMap);
                            placemarkers.push( amarker );
                        }
                        $('.title-icon', place_item).append('<span class="count">'+placemarkers.length+'</span>');
                        nearbyMarkers[propertyType] = placemarkers;
                    }
                });
            }
        },
        propertyNearby: function(place_item, place, propertyMap) {
            var amarker = new google.maps.Marker({
                map: propertyMap,
                position: place.geometry.location,
                icon: place_item.data('icon_image')
            });
            amarker.setMap( propertyMap  );
            google.maps.event.addListener(amarker, 'mouseover', function() {
                propertyInfo.setContent(place.name);
                propertyInfo.open(propertyMap, this);
            });
            google.maps.event.addListener(amarker, 'mouseout', function() {
                propertyInfo.open(null,null);
            });

            return amarker;
        },
        propertyControls: function( propertyMap, center) {
            $('.property-search-places').each(function(){
                var self_root = $(this);
                
                $('.place-btn', self_root).click(function() {
                    var self = $(this);
                    var type = $(this).data('type');

                    if ( !$(this).hasClass('active') ) {
                        $('.place-btn', self_root).each(function(){
                            $(this).removeClass('active');
                            ApusThemeMap.tooglePoints($(this), center, propertyMap, $(this).data('type'), false);
                        });
                        $(this).addClass('active');
                        ApusThemeMap.tooglePoints(self, center, propertyMap, type, true);
                    }
                    google.maps.event.addListener(propertyMap, 'bounds_changed', function() {
                        if( self.hasClass('active') ) {
                            var newCenter = propertyMap.getCenter();
                            ApusThemeMap.tooglePoints(self, newCenter, propertyMap, type, true);
                        }
                    });
                });
            });
        }

	}

	ApusThemeMap.init();
});