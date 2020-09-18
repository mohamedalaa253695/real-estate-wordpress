(function () {
	jQuery(document).ready(function($) {
		$('body').delegate(".input_datetime", 'hover', function(e){
            e.preventDefault();
            $(this).datepicker({
	               defaultDate: "",
	               dateFormat: "yy-mm-dd",
	               numberOfMonths: 1,
	               showButtonPanel: true,
            });
        });

        $('body').on('click', '.apus-get-token-btn', function(e) {
        	e.preventDefault();
        	var self = $(this);
        	self.addClass('loading');
        	var yelp_id = $('#api_settings_yelp_id').val();
        	var yelp_secret = $('#api_settings_yelp_app_secret').val();
        	if ( yelp_id == '' || yelp_secret == '' ) {
        		alert('Please add add Yelp App ID and Yelp App Secret');
        		return false;
        	}
        	$.ajax({
                url: ajaxurl,
                data: 'action=homesweet_get_yelp_access_token&yelp_id=' + yelp_id + '&yelp_secret=' + yelp_secret,
                dataType: 'json',
                cache: false,
                headers: {'cache-control': 'no-cache'},
                method: 'POST',
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log('Apus: AJAX error - propertyNearbyYelp() - ' + errorThrown);
                    self.removeClass('loading');
                },
                success: function(res) {
                    $('#api_settings_yelp_access_token').val(res.token);
                    self.removeClass('loading');
                }
            });
        });
	});	
} )( jQuery );