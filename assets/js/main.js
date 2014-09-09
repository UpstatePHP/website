(function($, window, document, undefined){

    if ($('#venue-map').length > 0) {
        var map = new GMaps({
            div: '#venue-map',
            lat: 34.850611,
            lng: -82.399124,
            disableDefaultUI: true
        });
        map.addMarker({
            lat: 34.850611,
            lng: -82.399124,
            title: 'OpenWorks',
            click: function(e) {

            },
            infoWindow: {
                content: '<h5>UpstatePHP @ OpenWorks</h5><p>2 N Main St<br>Greenville, SC 29601<br>(enter on Washington St.)</p>'
            }
        });
    }

})(jQuery, window, document);