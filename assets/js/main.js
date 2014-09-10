(function($, window, document, undefined){

    if ($('#venue-map').length > 0) {
        var venue = $('#venue-info').data('venue');

        var map = new GMaps({
            div: '#venue-map',
            lat: venue.latitude,
            lng: venue.longitude,
            disableDefaultUI: true
        });
        map.addMarker({
            lat: venue.latitude,
            lng: venue.longitude,
            title: venue.name,
            click: function(e) {

            },
            infoWindow: {
                content: venue.popup
            }
        });
    }

})(jQuery, window, document);