(function($, window, document, undefined){

    if ($('#event-location-map').length > 0) {
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

})(jQuery, window, document);