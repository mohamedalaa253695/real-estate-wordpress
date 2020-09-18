jQuery(document).ready(function($){

	var homesweet_upload;
	var homesweet_selector;

	function homesweet_add_file(event, selector) {

		var upload = $(".uploaded-file"), frame;
		var $el = $(this);
		homesweet_selector = selector;

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( homesweet_upload ) {
			homesweet_upload.open();
		} else {
			// Create the media frame.
			homesweet_upload = wp.media.frames.homesweet_upload =  wp.media({
				// Set the title of the modal.
				title: "Select Image",

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: "Selected",
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					close: false
				}
			});

			// When an image is selected, run a callback.
			homesweet_upload.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = homesweet_upload.state().get('selection').first();
				homesweet_upload.close();
				homesweet_selector.find('.upload_image').val(attachment.attributes.id).change();
				if ( attachment.attributes.type == 'image' ) {
					homesweet_selector.find('.screenshot').empty().hide().prepend('<img src="' + attachment.attributes.url + '">').slideDown('fast');
				}
			});

		}
		// Finally, open the modal.
		homesweet_upload.open();
	}

	function homesweet_remove_file(selector) {
		selector.find('.screenshot').slideUp('fast').next().val('').trigger('change');
	}
	
	$('body').delegate('.upload_image_action .remove-image', 'click', function(event) {
		homesweet_remove_file( $(this).parent().parent() );
	});

	$('body').delegate('.upload_image_action .add-image', 'click', function(event) {
		homesweet_add_file(event, $(this).parent().parent());
	});

});