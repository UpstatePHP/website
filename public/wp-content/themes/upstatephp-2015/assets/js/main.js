(function($, window, document, undefined){

    // Event Map
    if ($('#event-location-map').length > 0) {
        $('#event-location-map').height($('#event-location-map').parents('.card').outerHeight());
        var eventLocation = $('#event-location-info').data('location');

        var map = new GMaps({
            div: '#event-location-map',
            lat: eventLocation.latitude,
            lng: eventLocation.longitude,
            disableDefaultUI: true
        });
        var marker = map.addMarker({
            lat: eventLocation.latitude,
            lng: eventLocation.longitude,
            title: eventLocation.name,
            click: function(e) {

            },
            infoWindow: {
                content: eventLocation.popup
            }
        });

        $(window).load(function(){
            google.maps.event.trigger(marker, 'click');
        });
    }

    // Contact Modal
    var $contactForm = $('#contact-form');

    $('#contact-modal-submit').on('click', function(){
        var $submitter = $(this);
        $contactForm.validate();

        if ($contactForm.valid()
            && grecaptcha.getResponse() !== ''
        ) {
            $submitter.button('loading');
            $.ajax({
                url: '/contact',
                type: 'POST',
                data: $contactForm.serialize(),
                success: function(response) {
                    $submitter.html($submitter.attr('data-sent-text'));
                    setTimeout(function(){
                        $contactForm[0].reset();
                        grecaptcha.reset();
                        $submitter.button('reset');
                        $('#contact-modal').modal('hide');
                    }, 750);
                }
            });
        }
    });

})(jQuery, window, document);
