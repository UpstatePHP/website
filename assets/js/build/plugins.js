/*!
 * GMaps.js v0.4.7.1
 * http://hpneo.github.com/gmaps/
 *
 * Copyright 2013, Gustavo Leon
 * Released under the MIT License.
 */

if (!(typeof window.google === 'object' && window.google.maps)) {
    throw 'Google Maps API is required. Please register the following JavaScript library http://maps.google.com/maps/api/js?sensor=true.'
}

var extend_object = function(obj, new_obj) {
    var name;

    if (obj === new_obj) {
        return obj;
    }

    for (name in new_obj) {
        obj[name] = new_obj[name];
    }

    return obj;
};

var replace_object = function(obj, replace) {
    var name;

    if (obj === replace) {
        return obj;
    }

    for (name in replace) {
        if (obj[name] != undefined) {
            obj[name] = replace[name];
        }
    }

    return obj;
};

var array_map = function(array, callback) {
    var original_callback_params = Array.prototype.slice.call(arguments, 2),
        array_return = [],
        array_length = array.length,
        i;

    if (Array.prototype.map && array.map === Array.prototype.map) {
        array_return = Array.prototype.map.call(array, function(item) {
            callback_params = original_callback_params;
            callback_params.splice(0, 0, item);

            return callback.apply(this, callback_params);
        });
    }
    else {
        for (i = 0; i < array_length; i++) {
            callback_params = original_callback_params;
            callback_params.splice(0, 0, array[i]);
            array_return.push(callback.apply(this, callback_params));
        }
    }

    return array_return;
};

var array_flat = function(array) {
    var new_array = [],
        i;

    for (i = 0; i < array.length; i++) {
        new_array = new_array.concat(array[i]);
    }

    return new_array;
};

var coordsToLatLngs = function(coords, useGeoJSON) {
    var first_coord = coords[0],
        second_coord = coords[1];

    if (useGeoJSON) {
        first_coord = coords[1];
        second_coord = coords[0];
    }

    return new google.maps.LatLng(first_coord, second_coord);
};

var arrayToLatLng = function(coords, useGeoJSON) {
    var i;

    for (i = 0; i < coords.length; i++) {
        if (coords[i].length > 0 && typeof(coords[i][0]) == "object") {
            coords[i] = arrayToLatLng(coords[i], useGeoJSON);
        }
        else {
            coords[i] = coordsToLatLngs(coords[i], useGeoJSON);
        }
    }

    return coords;
};

var getElementById = function(id, context) {
    var element,
        id = id.replace('#', '');

    if ('jQuery' in this && context) {
        element = $("#" + id, context)[0];
    } else {
        element = document.getElementById(id);
    };

    return element;
};

var findAbsolutePosition = function(obj)  {
    var curleft = 0,
        curtop = 0;

    if (obj.offsetParent) {
        do {
            curleft += obj.offsetLeft;
            curtop += obj.offsetTop;
        } while (obj = obj.offsetParent);
    }

    return [curleft, curtop];
};

var GMaps = (function(global) {
    "use strict";

    var doc = document;

    var GMaps = function(options) {
        if (!this) return new GMaps(options);

        options.zoom = options.zoom || 15;
        options.mapType = options.mapType || 'roadmap';

        var self = this,
            i,
            events_that_hide_context_menu = ['bounds_changed', 'center_changed', 'click', 'dblclick', 'drag', 'dragend', 'dragstart', 'idle', 'maptypeid_changed', 'projection_changed', 'resize', 'tilesloaded', 'zoom_changed'],
            events_that_doesnt_hide_context_menu = ['mousemove', 'mouseout', 'mouseover'],
            options_to_be_deleted = ['el', 'lat', 'lng', 'mapType', 'width', 'height', 'markerClusterer', 'enableNewStyle'],
            container_id = options.el || options.div,
            markerClustererFunction = options.markerClusterer,
            mapType = google.maps.MapTypeId[options.mapType.toUpperCase()],
            map_center = new google.maps.LatLng(options.lat, options.lng),
            zoomControl = options.zoomControl || true,
            zoomControlOpt = options.zoomControlOpt || {
                style: 'DEFAULT',
                position: 'TOP_LEFT'
            },
            zoomControlStyle = zoomControlOpt.style || 'DEFAULT',
            zoomControlPosition = zoomControlOpt.position || 'TOP_LEFT',
            panControl = options.panControl || true,
            mapTypeControl = options.mapTypeControl || true,
            scaleControl = options.scaleControl || true,
            streetViewControl = options.streetViewControl || true,
            overviewMapControl = overviewMapControl || true,
            map_options = {},
            map_base_options = {
                zoom: this.zoom,
                center: map_center,
                mapTypeId: mapType
            },
            map_controls_options = {
                panControl: panControl,
                zoomControl: zoomControl,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle[zoomControlStyle],
                    position: google.maps.ControlPosition[zoomControlPosition]
                },
                mapTypeControl: mapTypeControl,
                scaleControl: scaleControl,
                streetViewControl: streetViewControl,
                overviewMapControl: overviewMapControl
            };

        if (typeof(options.el) === 'string' || typeof(options.div) === 'string') {
            this.el = getElementById(container_id, options.context);
        } else {
            this.el = container_id;
        }

        if (typeof(this.el) === 'undefined' || this.el === null) {
            throw 'No element defined.';
        }

        window.context_menu = window.context_menu || {};
        window.context_menu[self.el.id] = {};

        this.controls = [];
        this.overlays = [];
        this.layers = []; // array with kml/georss and fusiontables layers, can be as many
        this.singleLayers = {}; // object with the other layers, only one per layer
        this.markers = [];
        this.polylines = [];
        this.routes = [];
        this.polygons = [];
        this.infoWindow = null;
        this.overlay_el = null;
        this.zoom = options.zoom;
        this.registered_events = {};

        this.el.style.width = options.width || this.el.scrollWidth || this.el.offsetWidth;
        this.el.style.height = options.height || this.el.scrollHeight || this.el.offsetHeight;

        google.maps.visualRefresh = options.enableNewStyle;

        for (i = 0; i < options_to_be_deleted.length; i++) {
            delete options[options_to_be_deleted[i]];
        }

        if(options.disableDefaultUI != true) {
            map_base_options = extend_object(map_base_options, map_controls_options);
        }

        map_options = extend_object(map_base_options, options);

        for (i = 0; i < events_that_hide_context_menu.length; i++) {
            delete map_options[events_that_hide_context_menu[i]];
        }

        for (i = 0; i < events_that_doesnt_hide_context_menu.length; i++) {
            delete map_options[events_that_doesnt_hide_context_menu[i]];
        }

        this.map = new google.maps.Map(this.el, map_options);

        if (markerClustererFunction) {
            this.markerClusterer = markerClustererFunction.apply(this, [this.map]);
        }

        var buildContextMenuHTML = function(control, e) {
            var html = '',
                options = window.context_menu[self.el.id][control];

            for (var i in options){
                if (options.hasOwnProperty(i)) {
                    var option = options[i];

                    html += '<li><a id="' + control + '_' + i + '" href="#">' + option.title + '</a></li>';
                }
            }

            if (!getElementById('gmaps_context_menu')) return;

            var context_menu_element = getElementById('gmaps_context_menu');

            context_menu_element.innerHTML = html;

            var context_menu_items = context_menu_element.getElementsByTagName('a'),
                context_menu_items_count = context_menu_items.length
            i;

            for (i = 0; i < context_menu_items_count; i++) {
                var context_menu_item = context_menu_items[i];

                var assign_menu_item_action = function(ev){
                    ev.preventDefault();

                    options[this.id.replace(control + '_', '')].action.apply(self, [e]);
                    self.hideContextMenu();
                };

                google.maps.event.clearListeners(context_menu_item, 'click');
                google.maps.event.addDomListenerOnce(context_menu_item, 'click', assign_menu_item_action, false);
            }

            var position = findAbsolutePosition.apply(this, [self.el]),
                left = position[0] + e.pixel.x - 15,
                top = position[1] + e.pixel.y- 15;

            context_menu_element.style.left = left + "px";
            context_menu_element.style.top = top + "px";

            context_menu_element.style.display = 'block';
        };

        this.buildContextMenu = function(control, e) {
            if (control === 'marker') {
                e.pixel = {};

                var overlay = new google.maps.OverlayView();
                overlay.setMap(self.map);

                overlay.draw = function() {
                    var projection = overlay.getProjection(),
                        position = e.marker.getPosition();

                    e.pixel = projection.fromLatLngToContainerPixel(position);

                    buildContextMenuHTML(control, e);
                };
            }
            else {
                buildContextMenuHTML(control, e);
            }
        };

        this.setContextMenu = function(options) {
            window.context_menu[self.el.id][options.control] = {};

            var i,
                ul = doc.createElement('ul');

            for (i in options.options) {
                if (options.options.hasOwnProperty(i)) {
                    var option = options.options[i];

                    window.context_menu[self.el.id][options.control][option.name] = {
                        title: option.title,
                        action: option.action
                    };
                }
            }

            ul.id = 'gmaps_context_menu';
            ul.style.display = 'none';
            ul.style.position = 'absolute';
            ul.style.minWidth = '100px';
            ul.style.background = 'white';
            ul.style.listStyle = 'none';
            ul.style.padding = '8px';
            ul.style.boxShadow = '2px 2px 6px #ccc';

            doc.body.appendChild(ul);

            var context_menu_element = getElementById('gmaps_context_menu')

            google.maps.event.addDomListener(context_menu_element, 'mouseout', function(ev) {
                if (!ev.relatedTarget || !this.contains(ev.relatedTarget)) {
                    window.setTimeout(function(){
                        context_menu_element.style.display = 'none';
                    }, 400);
                }
            }, false);
        };

        this.hideContextMenu = function() {
            var context_menu_element = getElementById('gmaps_context_menu');

            if (context_menu_element) {
                context_menu_element.style.display = 'none';
            }
        };

        var setupListener = function(object, name) {
            google.maps.event.addListener(object, name, function(e){
                if (e == undefined) {
                    e = this;
                }

                options[name].apply(this, [e]);

                self.hideContextMenu();
            });
        };

        for (var ev = 0; ev < events_that_hide_context_menu.length; ev++) {
            var name = events_that_hide_context_menu[ev];

            if (name in options) {
                setupListener(this.map, name);
            }
        }

        for (var ev = 0; ev < events_that_doesnt_hide_context_menu.length; ev++) {
            var name = events_that_doesnt_hide_context_menu[ev];

            if (name in options) {
                setupListener(this.map, name);
            }
        }

        google.maps.event.addListener(this.map, 'rightclick', function(e) {
            if (options.rightclick) {
                options.rightclick.apply(this, [e]);
            }

            if(window.context_menu[self.el.id]['map'] != undefined) {
                self.buildContextMenu('map', e);
            }
        });

        this.refresh = function() {
            google.maps.event.trigger(this.map, 'resize');
        };

        this.fitZoom = function() {
            var latLngs = [],
                markers_length = this.markers.length,
                i;

            for (i = 0; i < markers_length; i++) {
                latLngs.push(this.markers[i].getPosition());
            }

            this.fitLatLngBounds(latLngs);
        };

        this.fitLatLngBounds = function(latLngs) {
            var total = latLngs.length;
            var bounds = new google.maps.LatLngBounds();

            for(var i=0; i < total; i++) {
                bounds.extend(latLngs[i]);
            }

            this.map.fitBounds(bounds);
        };

        this.setCenter = function(lat, lng, callback) {
            this.map.panTo(new google.maps.LatLng(lat, lng));

            if (callback) {
                callback();
            }
        };

        this.getElement = function() {
            return this.el;
        };

        this.zoomIn = function(value) {
            value = value || 1;

            this.zoom = this.map.getZoom() + value;
            this.map.setZoom(this.zoom);
        };

        this.zoomOut = function(value) {
            value = value || 1;

            this.zoom = this.map.getZoom() - value;
            this.map.setZoom(this.zoom);
        };

        var native_methods = [],
            method;

        for (method in this.map) {
            if (typeof(this.map[method]) == 'function' && !this[method]) {
                native_methods.push(method);
            }
        }

        for (i=0; i < native_methods.length; i++) {
            (function(gmaps, scope, method_name) {
                gmaps[method_name] = function(){
                    return scope[method_name].apply(scope, arguments);
                };
            })(this, this.map, native_methods[i]);
        }
    };

    return GMaps;
})(this);

GMaps.prototype.createControl = function(options) {
    var control = document.createElement('div');

    control.style.cursor = 'pointer';
    control.style.fontFamily = 'Arial, sans-serif';
    control.style.fontSize = '13px';
    control.style.boxShadow = 'rgba(0, 0, 0, 0.398438) 0px 2px 4px';

    for (var option in options.style) {
        control.style[option] = options.style[option];
    }

    if (options.id) {
        control.id = options.id;
    }

    if (options.classes) {
        control.className = options.classes;
    }

    if (options.content) {
        control.innerHTML = options.content;
    }

    for (var ev in options.events) {
        (function(object, name) {
            google.maps.event.addDomListener(object, name, function(){
                options.events[name].apply(this, [this]);
            });
        })(control, ev);
    }

    control.index = 1;

    return control;
};

GMaps.prototype.addControl = function(options) {
    var position = google.maps.ControlPosition[options.position.toUpperCase()];

    delete options.position;

    var control = this.createControl(options);
    this.controls.push(control);

    this.map.controls[position].push(control);

    return control;
};

GMaps.prototype.createMarker = function(options) {
    if (options.lat == undefined && options.lng == undefined && options.position == undefined) {
        throw 'No latitude or longitude defined.';
    }

    var self = this,
        details = options.details,
        fences = options.fences,
        outside = options.outside,
        base_options = {
            position: new google.maps.LatLng(options.lat, options.lng),
            map: null
        };

    delete options.lat;
    delete options.lng;
    delete options.fences;
    delete options.outside;

    var marker_options = extend_object(base_options, options),
        marker = new google.maps.Marker(marker_options);

    marker.fences = fences;

    if (options.infoWindow) {
        marker.infoWindow = new google.maps.InfoWindow(options.infoWindow);

        var info_window_events = ['closeclick', 'content_changed', 'domready', 'position_changed', 'zindex_changed'];

        for (var ev = 0; ev < info_window_events.length; ev++) {
            (function(object, name) {
                if (options.infoWindow[name]) {
                    google.maps.event.addListener(object, name, function(e){
                        options.infoWindow[name].apply(this, [e]);
                    });
                }
            })(marker.infoWindow, info_window_events[ev]);
        }
    }

    var marker_events = ['animation_changed', 'clickable_changed', 'cursor_changed', 'draggable_changed', 'flat_changed', 'icon_changed', 'position_changed', 'shadow_changed', 'shape_changed', 'title_changed', 'visible_changed', 'zindex_changed'];

    var marker_events_with_mouse = ['dblclick', 'drag', 'dragend', 'dragstart', 'mousedown', 'mouseout', 'mouseover', 'mouseup'];

    for (var ev = 0; ev < marker_events.length; ev++) {
        (function(object, name) {
            if (options[name]) {
                google.maps.event.addListener(object, name, function(){
                    options[name].apply(this, [this]);
                });
            }
        })(marker, marker_events[ev]);
    }

    for (var ev = 0; ev < marker_events_with_mouse.length; ev++) {
        (function(map, object, name) {
            if (options[name]) {
                google.maps.event.addListener(object, name, function(me){
                    if(!me.pixel){
                        me.pixel = map.getProjection().fromLatLngToPoint(me.latLng)
                    }

                    options[name].apply(this, [me]);
                });
            }
        })(this.map, marker, marker_events_with_mouse[ev]);
    }

    google.maps.event.addListener(marker, 'click', function() {
        this.details = details;

        if (options.click) {
            options.click.apply(this, [this]);
        }

        if (marker.infoWindow) {
            self.hideInfoWindows();
            marker.infoWindow.open(self.map, marker);
        }
    });

    google.maps.event.addListener(marker, 'rightclick', function(e) {
        e.marker = this;

        if (options.rightclick) {
            options.rightclick.apply(this, [e]);
        }

        if (window.context_menu[self.el.id]['marker'] != undefined) {
            self.buildContextMenu('marker', e);
        }
    });

    if (marker.fences) {
        google.maps.event.addListener(marker, 'dragend', function() {
            self.checkMarkerGeofence(marker, function(m, f) {
                outside(m, f);
            });
        });
    }

    return marker;
};

GMaps.prototype.addMarker = function(options) {
    var marker;
    if(options.hasOwnProperty('gm_accessors_')) {
        // Native google.maps.Marker object
        marker = options;
    }
    else {
        if ((options.hasOwnProperty('lat') && options.hasOwnProperty('lng')) || options.position) {
            marker = this.createMarker(options);
        }
        else {
            throw 'No latitude or longitude defined.';
        }
    }

    marker.setMap(this.map);

    if(this.markerClusterer) {
        this.markerClusterer.addMarker(marker);
    }

    this.markers.push(marker);

    GMaps.fire('marker_added', marker, this);

    return marker;
};

GMaps.prototype.addMarkers = function(array) {
    for (var i = 0, marker; marker=array[i]; i++) {
        this.addMarker(marker);
    }

    return this.markers;
};

GMaps.prototype.hideInfoWindows = function() {
    for (var i = 0, marker; marker = this.markers[i]; i++){
        if (marker.infoWindow){
            marker.infoWindow.close();
        }
    }
};

GMaps.prototype.removeMarker = function(marker) {
    for (var i = 0; i < this.markers.length; i++) {
        if (this.markers[i] === marker) {
            this.markers[i].setMap(null);
            this.markers.splice(i, 1);

            if(this.markerClusterer) {
                this.markerClusterer.removeMarker(marker);
            }

            GMaps.fire('marker_removed', marker, this);

            break;
        }
    }

    return marker;
};

GMaps.prototype.removeMarkers = function(collection) {
    var collection = (collection || this.markers);

    for (var i = 0;i < this.markers.length; i++) {
        if(this.markers[i] === collection[i]) {
            this.markers[i].setMap(null);
        }
    }

    var new_markers = [];

    for (var i = 0;i < this.markers.length; i++) {
        if(this.markers[i].getMap() != null) {
            new_markers.push(this.markers[i]);
        }
    }

    this.markers = new_markers;
};

GMaps.prototype.drawOverlay = function(options) {
    var overlay = new google.maps.OverlayView(),
        auto_show = true;

    overlay.setMap(this.map);

    if (options.auto_show != null) {
        auto_show = options.auto_show;
    }

    overlay.onAdd = function() {
        var el = document.createElement('div');

        el.style.borderStyle = "none";
        el.style.borderWidth = "0px";
        el.style.position = "absolute";
        el.style.zIndex = 100;
        el.innerHTML = options.content;

        overlay.el = el;

        if (!options.layer) {
            options.layer = 'overlayLayer';
        }

        var panes = this.getPanes(),
            overlayLayer = panes[options.layer],
            stop_overlay_events = ['contextmenu', 'DOMMouseScroll', 'dblclick', 'mousedown'];

        overlayLayer.appendChild(el);

        for (var ev = 0; ev < stop_overlay_events.length; ev++) {
            (function(object, name) {
                google.maps.event.addDomListener(object, name, function(e){
                    if (navigator.userAgent.toLowerCase().indexOf('msie') != -1 && document.all) {
                        e.cancelBubble = true;
                        e.returnValue = false;
                    }
                    else {
                        e.stopPropagation();
                    }
                });
            })(el, stop_overlay_events[ev]);
        }

        google.maps.event.trigger(this, 'ready');
    };

    overlay.draw = function() {
        var projection = this.getProjection(),
            pixel = projection.fromLatLngToDivPixel(new google.maps.LatLng(options.lat, options.lng));

        options.horizontalOffset = options.horizontalOffset || 0;
        options.verticalOffset = options.verticalOffset || 0;

        var el = overlay.el,
            content = el.children[0],
            content_height = content.clientHeight,
            content_width = content.clientWidth;

        switch (options.verticalAlign) {
            case 'top':
                el.style.top = (pixel.y - content_height + options.verticalOffset) + 'px';
                break;
            default:
            case 'middle':
                el.style.top = (pixel.y - (content_height / 2) + options.verticalOffset) + 'px';
                break;
            case 'bottom':
                el.style.top = (pixel.y + options.verticalOffset) + 'px';
                break;
        }

        switch (options.horizontalAlign) {
            case 'left':
                el.style.left = (pixel.x - content_width + options.horizontalOffset) + 'px';
                break;
            default:
            case 'center':
                el.style.left = (pixel.x - (content_width / 2) + options.horizontalOffset) + 'px';
                break;
            case 'right':
                el.style.left = (pixel.x + options.horizontalOffset) + 'px';
                break;
        }

        el.style.display = auto_show ? 'block' : 'none';

        if (!auto_show) {
            options.show.apply(this, [el]);
        }
    };

    overlay.onRemove = function() {
        var el = overlay.el;

        if (options.remove) {
            options.remove.apply(this, [el]);
        }
        else {
            overlay.el.parentNode.removeChild(overlay.el);
            overlay.el = null;
        }
    };

    this.overlays.push(overlay);
    return overlay;
};

GMaps.prototype.removeOverlay = function(overlay) {
    for (var i = 0; i < this.overlays.length; i++) {
        if (this.overlays[i] === overlay) {
            this.overlays[i].setMap(null);
            this.overlays.splice(i, 1);

            break;
        }
    }
};

GMaps.prototype.removeOverlays = function() {
    for (var i = 0, item; item = this.overlays[i]; i++) {
        item.setMap(null);
    }

    this.overlays = [];
};

GMaps.prototype.drawPolyline = function(options) {
    var path = [],
        points = options.path;

    if (points.length) {
        if (points[0][0] === undefined) {
            path = points;
        }
        else {
            for (var i=0, latlng; latlng=points[i]; i++) {
                path.push(new google.maps.LatLng(latlng[0], latlng[1]));
            }
        }
    }

    var polyline_options = {
        map: this.map,
        path: path,
        strokeColor: options.strokeColor,
        strokeOpacity: options.strokeOpacity,
        strokeWeight: options.strokeWeight,
        geodesic: options.geodesic,
        clickable: true,
        editable: false,
        visible: true
    };

    if (options.hasOwnProperty("clickable")) {
        polyline_options.clickable = options.clickable;
    }

    if (options.hasOwnProperty("editable")) {
        polyline_options.editable = options.editable;
    }

    if (options.hasOwnProperty("icons")) {
        polyline_options.icons = options.icons;
    }

    if (options.hasOwnProperty("zIndex")) {
        polyline_options.zIndex = options.zIndex;
    }

    var polyline = new google.maps.Polyline(polyline_options);

    var polyline_events = ['click', 'dblclick', 'mousedown', 'mousemove', 'mouseout', 'mouseover', 'mouseup', 'rightclick'];

    for (var ev = 0; ev < polyline_events.length; ev++) {
        (function(object, name) {
            if (options[name]) {
                google.maps.event.addListener(object, name, function(e){
                    options[name].apply(this, [e]);
                });
            }
        })(polyline, polyline_events[ev]);
    }

    this.polylines.push(polyline);

    GMaps.fire('polyline_added', polyline, this);

    return polyline;
};

GMaps.prototype.removePolyline = function(polyline) {
    for (var i = 0; i < this.polylines.length; i++) {
        if (this.polylines[i] === polyline) {
            this.polylines[i].setMap(null);
            this.polylines.splice(i, 1);

            GMaps.fire('polyline_removed', polyline, this);

            break;
        }
    }
};

GMaps.prototype.removePolylines = function() {
    for (var i = 0, item; item = this.polylines[i]; i++) {
        item.setMap(null);
    }

    this.polylines = [];
};

GMaps.prototype.drawCircle = function(options) {
    options =  extend_object({
        map: this.map,
        center: new google.maps.LatLng(options.lat, options.lng)
    }, options);

    delete options.lat;
    delete options.lng;

    var polygon = new google.maps.Circle(options),
        polygon_events = ['click', 'dblclick', 'mousedown', 'mousemove', 'mouseout', 'mouseover', 'mouseup', 'rightclick'];

    for (var ev = 0; ev < polygon_events.length; ev++) {
        (function(object, name) {
            if (options[name]) {
                google.maps.event.addListener(object, name, function(e){
                    options[name].apply(this, [e]);
                });
            }
        })(polygon, polygon_events[ev]);
    }

    this.polygons.push(polygon);

    return polygon;
};

GMaps.prototype.drawRectangle = function(options) {
    options = extend_object({
        map: this.map
    }, options);

    var latLngBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(options.bounds[0][0], options.bounds[0][1]),
        new google.maps.LatLng(options.bounds[1][0], options.bounds[1][1])
    );

    options.bounds = latLngBounds;

    var polygon = new google.maps.Rectangle(options),
        polygon_events = ['click', 'dblclick', 'mousedown', 'mousemove', 'mouseout', 'mouseover', 'mouseup', 'rightclick'];

    for (var ev = 0; ev < polygon_events.length; ev++) {
        (function(object, name) {
            if (options[name]) {
                google.maps.event.addListener(object, name, function(e){
                    options[name].apply(this, [e]);
                });
            }
        })(polygon, polygon_events[ev]);
    }

    this.polygons.push(polygon);

    return polygon;
};

GMaps.prototype.drawPolygon = function(options) {
    var useGeoJSON = false;

    if(options.hasOwnProperty("useGeoJSON")) {
        useGeoJSON = options.useGeoJSON;
    }

    delete options.useGeoJSON;

    options = extend_object({
        map: this.map
    }, options);

    if (useGeoJSON == false) {
        options.paths = [options.paths.slice(0)];
    }

    if (options.paths.length > 0) {
        if (options.paths[0].length > 0) {
            options.paths = array_flat(array_map(options.paths, arrayToLatLng, useGeoJSON));
        }
    }

    var polygon = new google.maps.Polygon(options),
        polygon_events = ['click', 'dblclick', 'mousedown', 'mousemove', 'mouseout', 'mouseover', 'mouseup', 'rightclick'];

    for (var ev = 0; ev < polygon_events.length; ev++) {
        (function(object, name) {
            if (options[name]) {
                google.maps.event.addListener(object, name, function(e){
                    options[name].apply(this, [e]);
                });
            }
        })(polygon, polygon_events[ev]);
    }

    this.polygons.push(polygon);

    GMaps.fire('polygon_added', polygon, this);

    return polygon;
};

GMaps.prototype.removePolygon = function(polygon) {
    for (var i = 0; i < this.polygons.length; i++) {
        if (this.polygons[i] === polygon) {
            this.polygons[i].setMap(null);
            this.polygons.splice(i, 1);

            GMaps.fire('polygon_removed', polygon, this);

            break;
        }
    }
};

GMaps.prototype.removePolygons = function() {
    for (var i = 0, item; item = this.polygons[i]; i++) {
        item.setMap(null);
    }

    this.polygons = [];
};

GMaps.prototype.getFromFusionTables = function(options) {
    var events = options.events;

    delete options.events;

    var fusion_tables_options = options,
        layer = new google.maps.FusionTablesLayer(fusion_tables_options);

    for (var ev in events) {
        (function(object, name) {
            google.maps.event.addListener(object, name, function(e) {
                events[name].apply(this, [e]);
            });
        })(layer, ev);
    }

    this.layers.push(layer);

    return layer;
};

GMaps.prototype.loadFromFusionTables = function(options) {
    var layer = this.getFromFusionTables(options);
    layer.setMap(this.map);

    return layer;
};

GMaps.prototype.getFromKML = function(options) {
    var url = options.url,
        events = options.events;

    delete options.url;
    delete options.events;

    var kml_options = options,
        layer = new google.maps.KmlLayer(url, kml_options);

    for (var ev in events) {
        (function(object, name) {
            google.maps.event.addListener(object, name, function(e) {
                events[name].apply(this, [e]);
            });
        })(layer, ev);
    }

    this.layers.push(layer);

    return layer;
};

GMaps.prototype.loadFromKML = function(options) {
    var layer = this.getFromKML(options);
    layer.setMap(this.map);

    return layer;
};

GMaps.prototype.addLayer = function(layerName, options) {
    //var default_layers = ['weather', 'clouds', 'traffic', 'transit', 'bicycling', 'panoramio', 'places'];
    options = options || {};
    var layer;

    switch(layerName) {
        case 'weather': this.singleLayers.weather = layer = new google.maps.weather.WeatherLayer();
            break;
        case 'clouds': this.singleLayers.clouds = layer = new google.maps.weather.CloudLayer();
            break;
        case 'traffic': this.singleLayers.traffic = layer = new google.maps.TrafficLayer();
            break;
        case 'transit': this.singleLayers.transit = layer = new google.maps.TransitLayer();
            break;
        case 'bicycling': this.singleLayers.bicycling = layer = new google.maps.BicyclingLayer();
            break;
        case 'panoramio':
            this.singleLayers.panoramio = layer = new google.maps.panoramio.PanoramioLayer();
            layer.setTag(options.filter);
            delete options.filter;

            //click event
            if (options.click) {
                google.maps.event.addListener(layer, 'click', function(event) {
                    options.click(event);
                    delete options.click;
                });
            }
            break;
        case 'places':
            this.singleLayers.places = layer = new google.maps.places.PlacesService(this.map);

            //search and  nearbySearch callback, Both are the same
            if (options.search || options.nearbySearch) {
                var placeSearchRequest  = {
                    bounds : options.bounds || null,
                    keyword : options.keyword || null,
                    location : options.location || null,
                    name : options.name || null,
                    radius : options.radius || null,
                    rankBy : options.rankBy || null,
                    types : options.types || null
                };

                if (options.search) {
                    layer.search(placeSearchRequest, options.search);
                }

                if (options.nearbySearch) {
                    layer.nearbySearch(placeSearchRequest, options.nearbySearch);
                }
            }

            //textSearch callback
            if (options.textSearch) {
                var textSearchRequest  = {
                    bounds : options.bounds || null,
                    location : options.location || null,
                    query : options.query || null,
                    radius : options.radius || null
                };

                layer.textSearch(textSearchRequest, options.textSearch);
            }
            break;
    }

    if (layer !== undefined) {
        if (typeof layer.setOptions == 'function') {
            layer.setOptions(options);
        }
        if (typeof layer.setMap == 'function') {
            layer.setMap(this.map);
        }

        return layer;
    }
};

GMaps.prototype.removeLayer = function(layer) {
    if (typeof(layer) == "string" && this.singleLayers[layer] !== undefined) {
        this.singleLayers[layer].setMap(null);

        delete this.singleLayers[layer];
    }
    else {
        for (var i = 0; i < this.layers.length; i++) {
            if (this.layers[i] === layer) {
                this.layers[i].setMap(null);
                this.layers.splice(i, 1);

                break;
            }
        }
    }
};

var travelMode, unitSystem;

GMaps.prototype.getRoutes = function(options) {
    switch (options.travelMode) {
        case 'bicycling':
            travelMode = google.maps.TravelMode.BICYCLING;
            break;
        case 'transit':
            travelMode = google.maps.TravelMode.TRANSIT;
            break;
        case 'driving':
            travelMode = google.maps.TravelMode.DRIVING;
            break;
        default:
            travelMode = google.maps.TravelMode.WALKING;
            break;
    }

    if (options.unitSystem === 'imperial') {
        unitSystem = google.maps.UnitSystem.IMPERIAL;
    }
    else {
        unitSystem = google.maps.UnitSystem.METRIC;
    }

    var base_options = {
            avoidHighways: false,
            avoidTolls: false,
            optimizeWaypoints: false,
            waypoints: []
        },
        request_options =  extend_object(base_options, options);

    request_options.origin = /string/.test(typeof options.origin) ? options.origin : new google.maps.LatLng(options.origin[0], options.origin[1]);
    request_options.destination = /string/.test(typeof options.destination) ? options.destination : new google.maps.LatLng(options.destination[0], options.destination[1]);
    request_options.travelMode = travelMode;
    request_options.unitSystem = unitSystem;

    delete request_options.callback;
    delete request_options.error;

    var self = this,
        service = new google.maps.DirectionsService();

    service.route(request_options, function(result, status) {
        if (status === google.maps.DirectionsStatus.OK) {
            for (var r in result.routes) {
                if (result.routes.hasOwnProperty(r)) {
                    self.routes.push(result.routes[r]);
                }
            }

            if (options.callback) {
                options.callback(self.routes);
            }
        }
        else {
            if (options.error) {
                options.error(result, status);
            }
        }
    });
};

GMaps.prototype.removeRoutes = function() {
    this.routes = [];
};

GMaps.prototype.getElevations = function(options) {
    options = extend_object({
        locations: [],
        path : false,
        samples : 256
    }, options);

    if (options.locations.length > 0) {
        if (options.locations[0].length > 0) {
            options.locations = array_flat(array_map([options.locations], arrayToLatLng,  false));
        }
    }

    var callback = options.callback;
    delete options.callback;

    var service = new google.maps.ElevationService();

    //location request
    if (!options.path) {
        delete options.path;
        delete options.samples;

        service.getElevationForLocations(options, function(result, status) {
            if (callback && typeof(callback) === "function") {
                callback(result, status);
            }
        });
        //path request
    } else {
        var pathRequest = {
            path : options.locations,
            samples : options.samples
        };

        service.getElevationAlongPath(pathRequest, function(result, status) {
            if (callback && typeof(callback) === "function") {
                callback(result, status);
            }
        });
    }
};

GMaps.prototype.cleanRoute = GMaps.prototype.removePolylines;

GMaps.prototype.drawRoute = function(options) {
    var self = this;

    this.getRoutes({
        origin: options.origin,
        destination: options.destination,
        travelMode: options.travelMode,
        waypoints: options.waypoints,
        unitSystem: options.unitSystem,
        error: options.error,
        callback: function(e) {
            if (e.length > 0) {
                self.drawPolyline({
                    path: e[e.length - 1].overview_path,
                    strokeColor: options.strokeColor,
                    strokeOpacity: options.strokeOpacity,
                    strokeWeight: options.strokeWeight
                });

                if (options.callback) {
                    options.callback(e[e.length - 1]);
                }
            }
        }
    });
};

GMaps.prototype.travelRoute = function(options) {
    if (options.origin && options.destination) {
        this.getRoutes({
            origin: options.origin,
            destination: options.destination,
            travelMode: options.travelMode,
            waypoints : options.waypoints,
            error: options.error,
            callback: function(e) {
                //start callback
                if (e.length > 0 && options.start) {
                    options.start(e[e.length - 1]);
                }

                //step callback
                if (e.length > 0 && options.step) {
                    var route = e[e.length - 1];
                    if (route.legs.length > 0) {
                        var steps = route.legs[0].steps;
                        for (var i=0, step; step=steps[i]; i++) {
                            step.step_number = i;
                            options.step(step, (route.legs[0].steps.length - 1));
                        }
                    }
                }

                //end callback
                if (e.length > 0 && options.end) {
                    options.end(e[e.length - 1]);
                }
            }
        });
    }
    else if (options.route) {
        if (options.route.legs.length > 0) {
            var steps = options.route.legs[0].steps;
            for (var i=0, step; step=steps[i]; i++) {
                step.step_number = i;
                options.step(step);
            }
        }
    }
};

GMaps.prototype.drawSteppedRoute = function(options) {
    var self = this;

    if (options.origin && options.destination) {
        this.getRoutes({
            origin: options.origin,
            destination: options.destination,
            travelMode: options.travelMode,
            waypoints : options.waypoints,
            error: options.error,
            callback: function(e) {
                //start callback
                if (e.length > 0 && options.start) {
                    options.start(e[e.length - 1]);
                }

                //step callback
                if (e.length > 0 && options.step) {
                    var route = e[e.length - 1];
                    if (route.legs.length > 0) {
                        var steps = route.legs[0].steps;
                        for (var i=0, step; step=steps[i]; i++) {
                            step.step_number = i;
                            self.drawPolyline({
                                path: step.path,
                                strokeColor: options.strokeColor,
                                strokeOpacity: options.strokeOpacity,
                                strokeWeight: options.strokeWeight
                            });
                            options.step(step, (route.legs[0].steps.length - 1));
                        }
                    }
                }

                //end callback
                if (e.length > 0 && options.end) {
                    options.end(e[e.length - 1]);
                }
            }
        });
    }
    else if (options.route) {
        if (options.route.legs.length > 0) {
            var steps = options.route.legs[0].steps;
            for (var i=0, step; step=steps[i]; i++) {
                step.step_number = i;
                self.drawPolyline({
                    path: step.path,
                    strokeColor: options.strokeColor,
                    strokeOpacity: options.strokeOpacity,
                    strokeWeight: options.strokeWeight
                });
                options.step(step);
            }
        }
    }
};

GMaps.Route = function(options) {
    this.origin = options.origin;
    this.destination = options.destination;
    this.waypoints = options.waypoints;

    this.map = options.map;
    this.route = options.route;
    this.step_count = 0;
    this.steps = this.route.legs[0].steps;
    this.steps_length = this.steps.length;

    this.polyline = this.map.drawPolyline({
        path: new google.maps.MVCArray(),
        strokeColor: options.strokeColor,
        strokeOpacity: options.strokeOpacity,
        strokeWeight: options.strokeWeight
    }).getPath();
};

GMaps.Route.prototype.getRoute = function(options) {
    var self = this;

    this.map.getRoutes({
        origin : this.origin,
        destination : this.destination,
        travelMode : options.travelMode,
        waypoints : this.waypoints || [],
        error: options.error,
        callback : function() {
            self.route = e[0];

            if (options.callback) {
                options.callback.call(self);
            }
        }
    });
};

GMaps.Route.prototype.back = function() {
    if (this.step_count > 0) {
        this.step_count--;
        var path = this.route.legs[0].steps[this.step_count].path;

        for (var p in path){
            if (path.hasOwnProperty(p)){
                this.polyline.pop();
            }
        }
    }
};

GMaps.Route.prototype.forward = function() {
    if (this.step_count < this.steps_length) {
        var path = this.route.legs[0].steps[this.step_count].path;

        for (var p in path){
            if (path.hasOwnProperty(p)){
                this.polyline.push(path[p]);
            }
        }
        this.step_count++;
    }
};

GMaps.prototype.checkGeofence = function(lat, lng, fence) {
    return fence.containsLatLng(new google.maps.LatLng(lat, lng));
};

GMaps.prototype.checkMarkerGeofence = function(marker, outside_callback) {
    if (marker.fences) {
        for (var i = 0, fence; fence = marker.fences[i]; i++) {
            var pos = marker.getPosition();
            if (!this.checkGeofence(pos.lat(), pos.lng(), fence)) {
                outside_callback(marker, fence);
            }
        }
    }
};

GMaps.prototype.toImage = function(options) {
    var options = options || {},
        static_map_options = {};

    static_map_options['size'] = options['size'] || [this.el.clientWidth, this.el.clientHeight];
    static_map_options['lat'] = this.getCenter().lat();
    static_map_options['lng'] = this.getCenter().lng();

    if (this.markers.length > 0) {
        static_map_options['markers'] = [];

        for (var i = 0; i < this.markers.length; i++) {
            static_map_options['markers'].push({
                lat: this.markers[i].getPosition().lat(),
                lng: this.markers[i].getPosition().lng()
            });
        }
    }

    if (this.polylines.length > 0) {
        var polyline = this.polylines[0];

        static_map_options['polyline'] = {};
        static_map_options['polyline']['path'] = google.maps.geometry.encoding.encodePath(polyline.getPath());
        static_map_options['polyline']['strokeColor'] = polyline.strokeColor
        static_map_options['polyline']['strokeOpacity'] = polyline.strokeOpacity
        static_map_options['polyline']['strokeWeight'] = polyline.strokeWeight
    }

    return GMaps.staticMapURL(static_map_options);
};

GMaps.staticMapURL = function(options){
    var parameters = [],
        data,
        static_root = 'http://maps.googleapis.com/maps/api/staticmap';

    if (options.url) {
        static_root = options.url;
        delete options.url;
    }

    static_root += '?';

    var markers = options.markers;

    delete options.markers;

    if (!markers && options.marker) {
        markers = [options.marker];
        delete options.marker;
    }

    var styles = options.styles;

    delete options.styles;

    var polyline = options.polyline;
    delete options.polyline;

    /** Map options **/
    if (options.center) {
        parameters.push('center=' + options.center);
        delete options.center;
    }
    else if (options.address) {
        parameters.push('center=' + options.address);
        delete options.address;
    }
    else if (options.lat) {
        parameters.push(['center=', options.lat, ',', options.lng].join(''));
        delete options.lat;
        delete options.lng;
    }
    else if (options.visible) {
        var visible = encodeURI(options.visible.join('|'));
        parameters.push('visible=' + visible);
    }

    var size = options.size;
    if (size) {
        if (size.join) {
            size = size.join('x');
        }
        delete options.size;
    }
    else {
        size = '630x300';
    }
    parameters.push('size=' + size);

    if (!options.zoom && options.zoom !== false) {
        options.zoom = 15;
    }

    var sensor = options.hasOwnProperty('sensor') ? !!options.sensor : true;
    delete options.sensor;
    parameters.push('sensor=' + sensor);

    for (var param in options) {
        if (options.hasOwnProperty(param)) {
            parameters.push(param + '=' + options[param]);
        }
    }

    /** Markers **/
    if (markers) {
        var marker, loc;

        for (var i=0; data=markers[i]; i++) {
            marker = [];

            if (data.size && data.size !== 'normal') {
                marker.push('size:' + data.size);
                delete data.size;
            }
            else if (data.icon) {
                marker.push('icon:' + encodeURI(data.icon));
                delete data.icon;
            }

            if (data.color) {
                marker.push('color:' + data.color.replace('#', '0x'));
                delete data.color;
            }

            if (data.label) {
                marker.push('label:' + data.label[0].toUpperCase());
                delete data.label;
            }

            loc = (data.address ? data.address : data.lat + ',' + data.lng);
            delete data.address;
            delete data.lat;
            delete data.lng;

            for(var param in data){
                if (data.hasOwnProperty(param)) {
                    marker.push(param + ':' + data[param]);
                }
            }

            if (marker.length || i === 0) {
                marker.push(loc);
                marker = marker.join('|');
                parameters.push('markers=' + encodeURI(marker));
            }
            // New marker without styles
            else {
                marker = parameters.pop() + encodeURI('|' + loc);
                parameters.push(marker);
            }
        }
    }

    /** Map Styles **/
    if (styles) {
        for (var i = 0; i < styles.length; i++) {
            var styleRule = [];
            if (styles[i].featureType && styles[i].featureType != 'all' ) {
                styleRule.push('feature:' + styles[i].featureType);
            }

            if (styles[i].elementType && styles[i].elementType != 'all') {
                styleRule.push('element:' + styles[i].elementType);
            }

            for (var j = 0; j < styles[i].stylers.length; j++) {
                for (var p in styles[i].stylers[j]) {
                    var ruleArg = styles[i].stylers[j][p];
                    if (p == 'hue' || p == 'color') {
                        ruleArg = '0x' + ruleArg.substring(1);
                    }
                    styleRule.push(p + ':' + ruleArg);
                }
            }

            var rule = styleRule.join('|');
            if (rule != '') {
                parameters.push('style=' + rule);
            }
        }
    }

    /** Polylines **/
    function parseColor(color, opacity) {
        if (color[0] === '#'){
            color = color.replace('#', '0x');

            if (opacity) {
                opacity = parseFloat(opacity);
                opacity = Math.min(1, Math.max(opacity, 0));
                if (opacity === 0) {
                    return '0x00000000';
                }
                opacity = (opacity * 255).toString(16);
                if (opacity.length === 1) {
                    opacity += opacity;
                }

                color = color.slice(0,8) + opacity;
            }
        }
        return color;
    }

    if (polyline) {
        data = polyline;
        polyline = [];

        if (data.strokeWeight) {
            polyline.push('weight:' + parseInt(data.strokeWeight, 10));
        }

        if (data.strokeColor) {
            var color = parseColor(data.strokeColor, data.strokeOpacity);
            polyline.push('color:' + color);
        }

        if (data.fillColor) {
            var fillcolor = parseColor(data.fillColor, data.fillOpacity);
            polyline.push('fillcolor:' + fillcolor);
        }

        var path = data.path;
        if (path.join) {
            for (var j=0, pos; pos=path[j]; j++) {
                polyline.push(pos.join(','));
            }
        }
        else {
            polyline.push('enc:' + path);
        }

        polyline = polyline.join('|');
        parameters.push('path=' + encodeURI(polyline));
    }

    parameters = parameters.join('&');
    return static_root + parameters;
};

GMaps.prototype.addMapType = function(mapTypeId, options) {
    if (options.hasOwnProperty("getTileUrl") && typeof(options["getTileUrl"]) == "function") {
        options.tileSize = options.tileSize || new google.maps.Size(256, 256);

        var mapType = new google.maps.ImageMapType(options);

        this.map.mapTypes.set(mapTypeId, mapType);
    }
    else {
        throw "'getTileUrl' function required.";
    }
};

GMaps.prototype.addOverlayMapType = function(options) {
    if (options.hasOwnProperty("getTile") && typeof(options["getTile"]) == "function") {
        var overlayMapTypeIndex = options.index;

        delete options.index;

        this.map.overlayMapTypes.insertAt(overlayMapTypeIndex, options);
    }
    else {
        throw "'getTile' function required.";
    }
};

GMaps.prototype.removeOverlayMapType = function(overlayMapTypeIndex) {
    this.map.overlayMapTypes.removeAt(overlayMapTypeIndex);
};

GMaps.prototype.addStyle = function(options) {
    var styledMapType = new google.maps.StyledMapType(options.styles, { name: options.styledMapName });

    this.map.mapTypes.set(options.mapTypeId, styledMapType);
};

GMaps.prototype.setStyle = function(mapTypeId) {
    this.map.setMapTypeId(mapTypeId);
};

GMaps.prototype.createPanorama = function(streetview_options) {
    if (!streetview_options.hasOwnProperty('lat') || !streetview_options.hasOwnProperty('lng')) {
        streetview_options.lat = this.getCenter().lat();
        streetview_options.lng = this.getCenter().lng();
    }

    this.panorama = GMaps.createPanorama(streetview_options);

    this.map.setStreetView(this.panorama);

    return this.panorama;
};

GMaps.createPanorama = function(options) {
    var el = getElementById(options.el, options.context);

    options.position = new google.maps.LatLng(options.lat, options.lng);

    delete options.el;
    delete options.context;
    delete options.lat;
    delete options.lng;

    var streetview_events = ['closeclick', 'links_changed', 'pano_changed', 'position_changed', 'pov_changed', 'resize', 'visible_changed'],
        streetview_options = extend_object({visible : true}, options);

    for (var i = 0; i < streetview_events.length; i++) {
        delete streetview_options[streetview_events[i]];
    }

    var panorama = new google.maps.StreetViewPanorama(el, streetview_options);

    for (var i = 0; i < streetview_events.length; i++) {
        (function(object, name) {
            if (options[name]) {
                google.maps.event.addListener(object, name, function(){
                    options[name].apply(this);
                });
            }
        })(panorama, streetview_events[i]);
    }

    return panorama;
};

GMaps.prototype.on = function(event_name, handler) {
    return GMaps.on(event_name, this, handler);
};

GMaps.prototype.off = function(event_name) {
    GMaps.off(event_name, this);
};

GMaps.custom_events = ['marker_added', 'marker_removed', 'polyline_added', 'polyline_removed', 'polygon_added', 'polygon_removed', 'geolocated', 'geolocation_failed'];

GMaps.on = function(event_name, object, handler) {
    if (GMaps.custom_events.indexOf(event_name) == -1) {
        return google.maps.event.addListener(object, event_name, handler);
    }
    else {
        var registered_event = {
            handler : handler,
            eventName : event_name
        };

        object.registered_events[event_name] = object.registered_events[event_name] || [];
        object.registered_events[event_name].push(registered_event);

        return registered_event;
    }
};

GMaps.off = function(event_name, object) {
    if (GMaps.custom_events.indexOf(event_name) == -1) {
        google.maps.event.clearListeners(object, event_name);
    }
    else {
        object.registered_events[event_name] = [];
    }
};

GMaps.fire = function(event_name, object, scope) {
    if (GMaps.custom_events.indexOf(event_name) == -1) {
        google.maps.event.trigger(object, event_name, Array.prototype.slice.apply(arguments).slice(2));
    }
    else {
        if(event_name in scope.registered_events) {
            var firing_events = scope.registered_events[event_name];

            for(var i = 0; i < firing_events.length; i++) {
                (function(handler, scope, object) {
                    handler.apply(scope, [object]);
                })(firing_events[i]['handler'], scope, object);
            }
        }
    }
};

GMaps.geolocate = function(options) {
    var complete_callback = options.always || options.complete;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            options.success(position);

            if (complete_callback) {
                complete_callback();
            }
        }, function(error) {
            options.error(error);

            if (complete_callback) {
                complete_callback();
            }
        }, options.options);
    }
    else {
        options.not_supported();

        if (complete_callback) {
            complete_callback();
        }
    }
};

GMaps.geocode = function(options) {
    this.geocoder = new google.maps.Geocoder();
    var callback = options.callback;
    if (options.hasOwnProperty('lat') && options.hasOwnProperty('lng')) {
        options.latLng = new google.maps.LatLng(options.lat, options.lng);
    }

    delete options.lat;
    delete options.lng;
    delete options.callback;

    this.geocoder.geocode(options, function(results, status) {
        callback(results, status);
    });
};

//==========================
// Polygon containsLatLng
// https://github.com/tparkin/Google-Maps-Point-in-Polygon
// Poygon getBounds extension - google-maps-extensions
// http://code.google.com/p/google-maps-extensions/source/browse/google.maps.Polygon.getBounds.js
if (!google.maps.Polygon.prototype.getBounds) {
    google.maps.Polygon.prototype.getBounds = function(latLng) {
        var bounds = new google.maps.LatLngBounds();
        var paths = this.getPaths();
        var path;

        for (var p = 0; p < paths.getLength(); p++) {
            path = paths.getAt(p);
            for (var i = 0; i < path.getLength(); i++) {
                bounds.extend(path.getAt(i));
            }
        }

        return bounds;
    };
}

if (!google.maps.Polygon.prototype.containsLatLng) {
    // Polygon containsLatLng - method to determine if a latLng is within a polygon
    google.maps.Polygon.prototype.containsLatLng = function(latLng) {
        // Exclude points outside of bounds as there is no way they are in the poly
        var bounds = this.getBounds();

        if (bounds !== null && !bounds.contains(latLng)) {
            return false;
        }

        // Raycast point in polygon method
        var inPoly = false;

        var numPaths = this.getPaths().getLength();
        for (var p = 0; p < numPaths; p++) {
            var path = this.getPaths().getAt(p);
            var numPoints = path.getLength();
            var j = numPoints - 1;

            for (var i = 0; i < numPoints; i++) {
                var vertex1 = path.getAt(i);
                var vertex2 = path.getAt(j);

                if (vertex1.lng() < latLng.lng() && vertex2.lng() >= latLng.lng() || vertex2.lng() < latLng.lng() && vertex1.lng() >= latLng.lng()) {
                    if (vertex1.lat() + (latLng.lng() - vertex1.lng()) / (vertex2.lng() - vertex1.lng()) * (vertex2.lat() - vertex1.lat()) < latLng.lat()) {
                        inPoly = !inPoly;
                    }
                }

                j = i;
            }
        }

        return inPoly;
    };
}

google.maps.LatLngBounds.prototype.containsLatLng = function(latLng) {
    return this.contains(latLng);
};

google.maps.Marker.prototype.setFences = function(fences) {
    this.fences = fences;
};

google.maps.Marker.prototype.addFence = function(fence) {
    this.fences.push(fence);
};

google.maps.Marker.prototype.getId = function() {
    return this['__gm_id'];
};

//==========================
// Array indexOf
// https://developer.mozilla.org/en-US/docs/JavaScript/Reference/Global_Objects/Array/indexOf
if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function (searchElement /*, fromIndex */ ) {
        "use strict";
        if (this == null) {
            throw new TypeError();
        }
        var t = Object(this);
        var len = t.length >>> 0;
        if (len === 0) {
            return -1;
        }
        var n = 0;
        if (arguments.length > 1) {
            n = Number(arguments[1]);
            if (n != n) { // shortcut for verifying if it's NaN
                n = 0;
            } else if (n != 0 && n != Infinity && n != -Infinity) {
                n = (n > 0 || -1) * Math.floor(Math.abs(n));
            }
        }
        if (n >= len) {
            return -1;
        }
        var k = n >= 0 ? n : Math.max(len - Math.abs(n), 0);
        for (; k < len; k++) {
            if (k in t && t[k] === searchElement) {
                return k;
            }
        }
        return -1;
    }
}
/* ========================================================================
 * Bootstrap: transition.js v3.2.0
 * http://getbootstrap.com/javascript/#transitions
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // CSS TRANSITION SUPPORT (Shoutout: http://www.modernizr.com/)
  // ============================================================

  function transitionEnd() {
    var el = document.createElement('bootstrap')

    var transEndEventNames = {
      WebkitTransition : 'webkitTransitionEnd',
      MozTransition    : 'transitionend',
      OTransition      : 'oTransitionEnd otransitionend',
      transition       : 'transitionend'
    }

    for (var name in transEndEventNames) {
      if (el.style[name] !== undefined) {
        return { end: transEndEventNames[name] }
      }
    }

    return false // explicit for ie8 (  ._.)
  }

  // http://blog.alexmaccaw.com/css-transitions
  $.fn.emulateTransitionEnd = function (duration) {
    var called = false
    var $el = this
    $(this).one('bsTransitionEnd', function () { called = true })
    var callback = function () { if (!called) $($el).trigger($.support.transition.end) }
    setTimeout(callback, duration)
    return this
  }

  $(function () {
    $.support.transition = transitionEnd()

    if (!$.support.transition) return

    $.event.special.bsTransitionEnd = {
      bindType: $.support.transition.end,
      delegateType: $.support.transition.end,
      handle: function (e) {
        if ($(e.target).is(this)) return e.handleObj.handler.apply(this, arguments)
      }
    }
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: alert.js v3.2.0
 * http://getbootstrap.com/javascript/#alerts
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // ALERT CLASS DEFINITION
  // ======================

  var dismiss = '[data-dismiss="alert"]'
  var Alert   = function (el) {
    $(el).on('click', dismiss, this.close)
  }

  Alert.VERSION = '3.2.0'

  Alert.prototype.close = function (e) {
    var $this    = $(this)
    var selector = $this.attr('data-target')

    if (!selector) {
      selector = $this.attr('href')
      selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
    }

    var $parent = $(selector)

    if (e) e.preventDefault()

    if (!$parent.length) {
      $parent = $this.hasClass('alert') ? $this : $this.parent()
    }

    $parent.trigger(e = $.Event('close.bs.alert'))

    if (e.isDefaultPrevented()) return

    $parent.removeClass('in')

    function removeElement() {
      // detach from parent, fire event then clean up data
      $parent.detach().trigger('closed.bs.alert').remove()
    }

    $.support.transition && $parent.hasClass('fade') ?
      $parent
        .one('bsTransitionEnd', removeElement)
        .emulateTransitionEnd(150) :
      removeElement()
  }


  // ALERT PLUGIN DEFINITION
  // =======================

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data('bs.alert')

      if (!data) $this.data('bs.alert', (data = new Alert(this)))
      if (typeof option == 'string') data[option].call($this)
    })
  }

  var old = $.fn.alert

  $.fn.alert             = Plugin
  $.fn.alert.Constructor = Alert


  // ALERT NO CONFLICT
  // =================

  $.fn.alert.noConflict = function () {
    $.fn.alert = old
    return this
  }


  // ALERT DATA-API
  // ==============

  $(document).on('click.bs.alert.data-api', dismiss, Alert.prototype.close)

}(jQuery);

/* ========================================================================
 * Bootstrap: button.js v3.2.0
 * http://getbootstrap.com/javascript/#buttons
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // BUTTON PUBLIC CLASS DEFINITION
  // ==============================

  var Button = function (element, options) {
    this.$element  = $(element)
    this.options   = $.extend({}, Button.DEFAULTS, options)
    this.isLoading = false
  }

  Button.VERSION  = '3.2.0'

  Button.DEFAULTS = {
    loadingText: 'loading...'
  }

  Button.prototype.setState = function (state) {
    var d    = 'disabled'
    var $el  = this.$element
    var val  = $el.is('input') ? 'val' : 'html'
    var data = $el.data()

    state = state + 'Text'

    if (data.resetText == null) $el.data('resetText', $el[val]())

    $el[val](data[state] == null ? this.options[state] : data[state])

    // push to event loop to allow forms to submit
    setTimeout($.proxy(function () {
      if (state == 'loadingText') {
        this.isLoading = true
        $el.addClass(d).attr(d, d)
      } else if (this.isLoading) {
        this.isLoading = false
        $el.removeClass(d).removeAttr(d)
      }
    }, this), 0)
  }

  Button.prototype.toggle = function () {
    var changed = true
    var $parent = this.$element.closest('[data-toggle="buttons"]')

    if ($parent.length) {
      var $input = this.$element.find('input')
      if ($input.prop('type') == 'radio') {
        if ($input.prop('checked') && this.$element.hasClass('active')) changed = false
        else $parent.find('.active').removeClass('active')
      }
      if (changed) $input.prop('checked', !this.$element.hasClass('active')).trigger('change')
    }

    if (changed) this.$element.toggleClass('active')
  }


  // BUTTON PLUGIN DEFINITION
  // ========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.button')
      var options = typeof option == 'object' && option

      if (!data) $this.data('bs.button', (data = new Button(this, options)))

      if (option == 'toggle') data.toggle()
      else if (option) data.setState(option)
    })
  }

  var old = $.fn.button

  $.fn.button             = Plugin
  $.fn.button.Constructor = Button


  // BUTTON NO CONFLICT
  // ==================

  $.fn.button.noConflict = function () {
    $.fn.button = old
    return this
  }


  // BUTTON DATA-API
  // ===============

  $(document).on('click.bs.button.data-api', '[data-toggle^="button"]', function (e) {
    var $btn = $(e.target)
    if (!$btn.hasClass('btn')) $btn = $btn.closest('.btn')
    Plugin.call($btn, 'toggle')
    e.preventDefault()
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: carousel.js v3.2.0
 * http://getbootstrap.com/javascript/#carousel
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // CAROUSEL CLASS DEFINITION
  // =========================

  var Carousel = function (element, options) {
    this.$element    = $(element).on('keydown.bs.carousel', $.proxy(this.keydown, this))
    this.$indicators = this.$element.find('.carousel-indicators')
    this.options     = options
    this.paused      =
    this.sliding     =
    this.interval    =
    this.$active     =
    this.$items      = null

    this.options.pause == 'hover' && this.$element
      .on('mouseenter.bs.carousel', $.proxy(this.pause, this))
      .on('mouseleave.bs.carousel', $.proxy(this.cycle, this))
  }

  Carousel.VERSION  = '3.2.0'

  Carousel.DEFAULTS = {
    interval: 5000,
    pause: 'hover',
    wrap: true
  }

  Carousel.prototype.keydown = function (e) {
    switch (e.which) {
      case 37: this.prev(); break
      case 39: this.next(); break
      default: return
    }

    e.preventDefault()
  }

  Carousel.prototype.cycle = function (e) {
    e || (this.paused = false)

    this.interval && clearInterval(this.interval)

    this.options.interval
      && !this.paused
      && (this.interval = setInterval($.proxy(this.next, this), this.options.interval))

    return this
  }

  Carousel.prototype.getItemIndex = function (item) {
    this.$items = item.parent().children('.item')
    return this.$items.index(item || this.$active)
  }

  Carousel.prototype.to = function (pos) {
    var that        = this
    var activeIndex = this.getItemIndex(this.$active = this.$element.find('.item.active'))

    if (pos > (this.$items.length - 1) || pos < 0) return

    if (this.sliding)       return this.$element.one('slid.bs.carousel', function () { that.to(pos) }) // yes, "slid"
    if (activeIndex == pos) return this.pause().cycle()

    return this.slide(pos > activeIndex ? 'next' : 'prev', $(this.$items[pos]))
  }

  Carousel.prototype.pause = function (e) {
    e || (this.paused = true)

    if (this.$element.find('.next, .prev').length && $.support.transition) {
      this.$element.trigger($.support.transition.end)
      this.cycle(true)
    }

    this.interval = clearInterval(this.interval)

    return this
  }

  Carousel.prototype.next = function () {
    if (this.sliding) return
    return this.slide('next')
  }

  Carousel.prototype.prev = function () {
    if (this.sliding) return
    return this.slide('prev')
  }

  Carousel.prototype.slide = function (type, next) {
    var $active   = this.$element.find('.item.active')
    var $next     = next || $active[type]()
    var isCycling = this.interval
    var direction = type == 'next' ? 'left' : 'right'
    var fallback  = type == 'next' ? 'first' : 'last'
    var that      = this

    if (!$next.length) {
      if (!this.options.wrap) return
      $next = this.$element.find('.item')[fallback]()
    }

    if ($next.hasClass('active')) return (this.sliding = false)

    var relatedTarget = $next[0]
    var slideEvent = $.Event('slide.bs.carousel', {
      relatedTarget: relatedTarget,
      direction: direction
    })
    this.$element.trigger(slideEvent)
    if (slideEvent.isDefaultPrevented()) return

    this.sliding = true

    isCycling && this.pause()

    if (this.$indicators.length) {
      this.$indicators.find('.active').removeClass('active')
      var $nextIndicator = $(this.$indicators.children()[this.getItemIndex($next)])
      $nextIndicator && $nextIndicator.addClass('active')
    }

    var slidEvent = $.Event('slid.bs.carousel', { relatedTarget: relatedTarget, direction: direction }) // yes, "slid"
    if ($.support.transition && this.$element.hasClass('slide')) {
      $next.addClass(type)
      $next[0].offsetWidth // force reflow
      $active.addClass(direction)
      $next.addClass(direction)
      $active
        .one('bsTransitionEnd', function () {
          $next.removeClass([type, direction].join(' ')).addClass('active')
          $active.removeClass(['active', direction].join(' '))
          that.sliding = false
          setTimeout(function () {
            that.$element.trigger(slidEvent)
          }, 0)
        })
        .emulateTransitionEnd($active.css('transition-duration').slice(0, -1) * 1000)
    } else {
      $active.removeClass('active')
      $next.addClass('active')
      this.sliding = false
      this.$element.trigger(slidEvent)
    }

    isCycling && this.cycle()

    return this
  }


  // CAROUSEL PLUGIN DEFINITION
  // ==========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.carousel')
      var options = $.extend({}, Carousel.DEFAULTS, $this.data(), typeof option == 'object' && option)
      var action  = typeof option == 'string' ? option : options.slide

      if (!data) $this.data('bs.carousel', (data = new Carousel(this, options)))
      if (typeof option == 'number') data.to(option)
      else if (action) data[action]()
      else if (options.interval) data.pause().cycle()
    })
  }

  var old = $.fn.carousel

  $.fn.carousel             = Plugin
  $.fn.carousel.Constructor = Carousel


  // CAROUSEL NO CONFLICT
  // ====================

  $.fn.carousel.noConflict = function () {
    $.fn.carousel = old
    return this
  }


  // CAROUSEL DATA-API
  // =================

  $(document).on('click.bs.carousel.data-api', '[data-slide], [data-slide-to]', function (e) {
    var href
    var $this   = $(this)
    var $target = $($this.attr('data-target') || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '')) // strip for ie7
    if (!$target.hasClass('carousel')) return
    var options = $.extend({}, $target.data(), $this.data())
    var slideIndex = $this.attr('data-slide-to')
    if (slideIndex) options.interval = false

    Plugin.call($target, options)

    if (slideIndex) {
      $target.data('bs.carousel').to(slideIndex)
    }

    e.preventDefault()
  })

  $(window).on('load', function () {
    $('[data-ride="carousel"]').each(function () {
      var $carousel = $(this)
      Plugin.call($carousel, $carousel.data())
    })
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: collapse.js v3.2.0
 * http://getbootstrap.com/javascript/#collapse
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // COLLAPSE PUBLIC CLASS DEFINITION
  // ================================

  var Collapse = function (element, options) {
    this.$element      = $(element)
    this.options       = $.extend({}, Collapse.DEFAULTS, options)
    this.transitioning = null

    if (this.options.parent) this.$parent = $(this.options.parent)
    if (this.options.toggle) this.toggle()
  }

  Collapse.VERSION  = '3.2.0'

  Collapse.DEFAULTS = {
    toggle: true
  }

  Collapse.prototype.dimension = function () {
    var hasWidth = this.$element.hasClass('width')
    return hasWidth ? 'width' : 'height'
  }

  Collapse.prototype.show = function () {
    if (this.transitioning || this.$element.hasClass('in')) return

    var startEvent = $.Event('show.bs.collapse')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    var actives = this.$parent && this.$parent.find('> .panel > .in')

    if (actives && actives.length) {
      var hasData = actives.data('bs.collapse')
      if (hasData && hasData.transitioning) return
      Plugin.call(actives, 'hide')
      hasData || actives.data('bs.collapse', null)
    }

    var dimension = this.dimension()

    this.$element
      .removeClass('collapse')
      .addClass('collapsing')[dimension](0)

    this.transitioning = 1

    var complete = function () {
      this.$element
        .removeClass('collapsing')
        .addClass('collapse in')[dimension]('')
      this.transitioning = 0
      this.$element
        .trigger('shown.bs.collapse')
    }

    if (!$.support.transition) return complete.call(this)

    var scrollSize = $.camelCase(['scroll', dimension].join('-'))

    this.$element
      .one('bsTransitionEnd', $.proxy(complete, this))
      .emulateTransitionEnd(350)[dimension](this.$element[0][scrollSize])
  }

  Collapse.prototype.hide = function () {
    if (this.transitioning || !this.$element.hasClass('in')) return

    var startEvent = $.Event('hide.bs.collapse')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    var dimension = this.dimension()

    this.$element[dimension](this.$element[dimension]())[0].offsetHeight

    this.$element
      .addClass('collapsing')
      .removeClass('collapse')
      .removeClass('in')

    this.transitioning = 1

    var complete = function () {
      this.transitioning = 0
      this.$element
        .trigger('hidden.bs.collapse')
        .removeClass('collapsing')
        .addClass('collapse')
    }

    if (!$.support.transition) return complete.call(this)

    this.$element
      [dimension](0)
      .one('bsTransitionEnd', $.proxy(complete, this))
      .emulateTransitionEnd(350)
  }

  Collapse.prototype.toggle = function () {
    this[this.$element.hasClass('in') ? 'hide' : 'show']()
  }


  // COLLAPSE PLUGIN DEFINITION
  // ==========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.collapse')
      var options = $.extend({}, Collapse.DEFAULTS, $this.data(), typeof option == 'object' && option)

      if (!data && options.toggle && option == 'show') option = !option
      if (!data) $this.data('bs.collapse', (data = new Collapse(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.collapse

  $.fn.collapse             = Plugin
  $.fn.collapse.Constructor = Collapse


  // COLLAPSE NO CONFLICT
  // ====================

  $.fn.collapse.noConflict = function () {
    $.fn.collapse = old
    return this
  }


  // COLLAPSE DATA-API
  // =================

  $(document).on('click.bs.collapse.data-api', '[data-toggle="collapse"]', function (e) {
    var href
    var $this   = $(this)
    var target  = $this.attr('data-target')
        || e.preventDefault()
        || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '') // strip for ie7
    var $target = $(target)
    var data    = $target.data('bs.collapse')
    var option  = data ? 'toggle' : $this.data()
    var parent  = $this.attr('data-parent')
    var $parent = parent && $(parent)

    if (!data || !data.transitioning) {
      if ($parent) $parent.find('[data-toggle="collapse"][data-parent="' + parent + '"]').not($this).addClass('collapsed')
      $this[$target.hasClass('in') ? 'addClass' : 'removeClass']('collapsed')
    }

    Plugin.call($target, option)
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: dropdown.js v3.2.0
 * http://getbootstrap.com/javascript/#dropdowns
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // DROPDOWN CLASS DEFINITION
  // =========================

  var backdrop = '.dropdown-backdrop'
  var toggle   = '[data-toggle="dropdown"]'
  var Dropdown = function (element) {
    $(element).on('click.bs.dropdown', this.toggle)
  }

  Dropdown.VERSION = '3.2.0'

  Dropdown.prototype.toggle = function (e) {
    var $this = $(this)

    if ($this.is('.disabled, :disabled')) return

    var $parent  = getParent($this)
    var isActive = $parent.hasClass('open')

    clearMenus()

    if (!isActive) {
      if ('ontouchstart' in document.documentElement && !$parent.closest('.navbar-nav').length) {
        // if mobile we use a backdrop because click events don't delegate
        $('<div class="dropdown-backdrop"/>').insertAfter($(this)).on('click', clearMenus)
      }

      var relatedTarget = { relatedTarget: this }
      $parent.trigger(e = $.Event('show.bs.dropdown', relatedTarget))

      if (e.isDefaultPrevented()) return

      $this.trigger('focus')

      $parent
        .toggleClass('open')
        .trigger('shown.bs.dropdown', relatedTarget)
    }

    return false
  }

  Dropdown.prototype.keydown = function (e) {
    if (!/(38|40|27)/.test(e.keyCode)) return

    var $this = $(this)

    e.preventDefault()
    e.stopPropagation()

    if ($this.is('.disabled, :disabled')) return

    var $parent  = getParent($this)
    var isActive = $parent.hasClass('open')

    if (!isActive || (isActive && e.keyCode == 27)) {
      if (e.which == 27) $parent.find(toggle).trigger('focus')
      return $this.trigger('click')
    }

    var desc = ' li:not(.divider):visible a'
    var $items = $parent.find('[role="menu"]' + desc + ', [role="listbox"]' + desc)

    if (!$items.length) return

    var index = $items.index($items.filter(':focus'))

    if (e.keyCode == 38 && index > 0)                 index--                        // up
    if (e.keyCode == 40 && index < $items.length - 1) index++                        // down
    if (!~index)                                      index = 0

    $items.eq(index).trigger('focus')
  }

  function clearMenus(e) {
    if (e && e.which === 3) return
    $(backdrop).remove()
    $(toggle).each(function () {
      var $parent = getParent($(this))
      var relatedTarget = { relatedTarget: this }
      if (!$parent.hasClass('open')) return
      $parent.trigger(e = $.Event('hide.bs.dropdown', relatedTarget))
      if (e.isDefaultPrevented()) return
      $parent.removeClass('open').trigger('hidden.bs.dropdown', relatedTarget)
    })
  }

  function getParent($this) {
    var selector = $this.attr('data-target')

    if (!selector) {
      selector = $this.attr('href')
      selector = selector && /#[A-Za-z]/.test(selector) && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
    }

    var $parent = selector && $(selector)

    return $parent && $parent.length ? $parent : $this.parent()
  }


  // DROPDOWN PLUGIN DEFINITION
  // ==========================

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data('bs.dropdown')

      if (!data) $this.data('bs.dropdown', (data = new Dropdown(this)))
      if (typeof option == 'string') data[option].call($this)
    })
  }

  var old = $.fn.dropdown

  $.fn.dropdown             = Plugin
  $.fn.dropdown.Constructor = Dropdown


  // DROPDOWN NO CONFLICT
  // ====================

  $.fn.dropdown.noConflict = function () {
    $.fn.dropdown = old
    return this
  }


  // APPLY TO STANDARD DROPDOWN ELEMENTS
  // ===================================

  $(document)
    .on('click.bs.dropdown.data-api', clearMenus)
    .on('click.bs.dropdown.data-api', '.dropdown form', function (e) { e.stopPropagation() })
    .on('click.bs.dropdown.data-api', toggle, Dropdown.prototype.toggle)
    .on('keydown.bs.dropdown.data-api', toggle + ', [role="menu"], [role="listbox"]', Dropdown.prototype.keydown)

}(jQuery);

/* ========================================================================
 * Bootstrap: modal.js v3.2.0
 * http://getbootstrap.com/javascript/#modals
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // MODAL CLASS DEFINITION
  // ======================

  var Modal = function (element, options) {
    this.options        = options
    this.$body          = $(document.body)
    this.$element       = $(element)
    this.$backdrop      =
    this.isShown        = null
    this.scrollbarWidth = 0

    if (this.options.remote) {
      this.$element
        .find('.modal-content')
        .load(this.options.remote, $.proxy(function () {
          this.$element.trigger('loaded.bs.modal')
        }, this))
    }
  }

  Modal.VERSION  = '3.2.0'

  Modal.DEFAULTS = {
    backdrop: true,
    keyboard: true,
    show: true
  }

  Modal.prototype.toggle = function (_relatedTarget) {
    return this.isShown ? this.hide() : this.show(_relatedTarget)
  }

  Modal.prototype.show = function (_relatedTarget) {
    var that = this
    var e    = $.Event('show.bs.modal', { relatedTarget: _relatedTarget })

    this.$element.trigger(e)

    if (this.isShown || e.isDefaultPrevented()) return

    this.isShown = true

    this.checkScrollbar()
    this.$body.addClass('modal-open')

    this.setScrollbar()
    this.escape()

    this.$element.on('click.dismiss.bs.modal', '[data-dismiss="modal"]', $.proxy(this.hide, this))

    this.backdrop(function () {
      var transition = $.support.transition && that.$element.hasClass('fade')

      if (!that.$element.parent().length) {
        that.$element.appendTo(that.$body) // don't move modals dom position
      }

      that.$element
        .show()
        .scrollTop(0)

      if (transition) {
        that.$element[0].offsetWidth // force reflow
      }

      that.$element
        .addClass('in')
        .attr('aria-hidden', false)

      that.enforceFocus()

      var e = $.Event('shown.bs.modal', { relatedTarget: _relatedTarget })

      transition ?
        that.$element.find('.modal-dialog') // wait for modal to slide in
          .one('bsTransitionEnd', function () {
            that.$element.trigger('focus').trigger(e)
          })
          .emulateTransitionEnd(300) :
        that.$element.trigger('focus').trigger(e)
    })
  }

  Modal.prototype.hide = function (e) {
    if (e) e.preventDefault()

    e = $.Event('hide.bs.modal')

    this.$element.trigger(e)

    if (!this.isShown || e.isDefaultPrevented()) return

    this.isShown = false

    this.$body.removeClass('modal-open')

    this.resetScrollbar()
    this.escape()

    $(document).off('focusin.bs.modal')

    this.$element
      .removeClass('in')
      .attr('aria-hidden', true)
      .off('click.dismiss.bs.modal')

    $.support.transition && this.$element.hasClass('fade') ?
      this.$element
        .one('bsTransitionEnd', $.proxy(this.hideModal, this))
        .emulateTransitionEnd(300) :
      this.hideModal()
  }

  Modal.prototype.enforceFocus = function () {
    $(document)
      .off('focusin.bs.modal') // guard against infinite focus loop
      .on('focusin.bs.modal', $.proxy(function (e) {
        if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
          this.$element.trigger('focus')
        }
      }, this))
  }

  Modal.prototype.escape = function () {
    if (this.isShown && this.options.keyboard) {
      this.$element.on('keyup.dismiss.bs.modal', $.proxy(function (e) {
        e.which == 27 && this.hide()
      }, this))
    } else if (!this.isShown) {
      this.$element.off('keyup.dismiss.bs.modal')
    }
  }

  Modal.prototype.hideModal = function () {
    var that = this
    this.$element.hide()
    this.backdrop(function () {
      that.$element.trigger('hidden.bs.modal')
    })
  }

  Modal.prototype.removeBackdrop = function () {
    this.$backdrop && this.$backdrop.remove()
    this.$backdrop = null
  }

  Modal.prototype.backdrop = function (callback) {
    var that = this
    var animate = this.$element.hasClass('fade') ? 'fade' : ''

    if (this.isShown && this.options.backdrop) {
      var doAnimate = $.support.transition && animate

      this.$backdrop = $('<div class="modal-backdrop ' + animate + '" />')
        .appendTo(this.$body)

      this.$element.on('click.dismiss.bs.modal', $.proxy(function (e) {
        if (e.target !== e.currentTarget) return
        this.options.backdrop == 'static'
          ? this.$element[0].focus.call(this.$element[0])
          : this.hide.call(this)
      }, this))

      if (doAnimate) this.$backdrop[0].offsetWidth // force reflow

      this.$backdrop.addClass('in')

      if (!callback) return

      doAnimate ?
        this.$backdrop
          .one('bsTransitionEnd', callback)
          .emulateTransitionEnd(150) :
        callback()

    } else if (!this.isShown && this.$backdrop) {
      this.$backdrop.removeClass('in')

      var callbackRemove = function () {
        that.removeBackdrop()
        callback && callback()
      }
      $.support.transition && this.$element.hasClass('fade') ?
        this.$backdrop
          .one('bsTransitionEnd', callbackRemove)
          .emulateTransitionEnd(150) :
        callbackRemove()

    } else if (callback) {
      callback()
    }
  }

  Modal.prototype.checkScrollbar = function () {
    if (document.body.clientWidth >= window.innerWidth) return
    this.scrollbarWidth = this.scrollbarWidth || this.measureScrollbar()
  }

  Modal.prototype.setScrollbar = function () {
    var bodyPad = parseInt((this.$body.css('padding-right') || 0), 10)
    if (this.scrollbarWidth) this.$body.css('padding-right', bodyPad + this.scrollbarWidth)
  }

  Modal.prototype.resetScrollbar = function () {
    this.$body.css('padding-right', '')
  }

  Modal.prototype.measureScrollbar = function () { // thx walsh
    var scrollDiv = document.createElement('div')
    scrollDiv.className = 'modal-scrollbar-measure'
    this.$body.append(scrollDiv)
    var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth
    this.$body[0].removeChild(scrollDiv)
    return scrollbarWidth
  }


  // MODAL PLUGIN DEFINITION
  // =======================

  function Plugin(option, _relatedTarget) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.modal')
      var options = $.extend({}, Modal.DEFAULTS, $this.data(), typeof option == 'object' && option)

      if (!data) $this.data('bs.modal', (data = new Modal(this, options)))
      if (typeof option == 'string') data[option](_relatedTarget)
      else if (options.show) data.show(_relatedTarget)
    })
  }

  var old = $.fn.modal

  $.fn.modal             = Plugin
  $.fn.modal.Constructor = Modal


  // MODAL NO CONFLICT
  // =================

  $.fn.modal.noConflict = function () {
    $.fn.modal = old
    return this
  }


  // MODAL DATA-API
  // ==============

  $(document).on('click.bs.modal.data-api', '[data-toggle="modal"]', function (e) {
    var $this   = $(this)
    var href    = $this.attr('href')
    var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
    var option  = $target.data('bs.modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

    if ($this.is('a')) e.preventDefault()

    $target.one('show.bs.modal', function (showEvent) {
      if (showEvent.isDefaultPrevented()) return // only register focus restorer if modal will actually get shown
      $target.one('hidden.bs.modal', function () {
        $this.is(':visible') && $this.trigger('focus')
      })
    })
    Plugin.call($target, option, this)
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: tooltip.js v3.2.0
 * http://getbootstrap.com/javascript/#tooltip
 * Inspired by the original jQuery.tipsy by Jason Frame
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // TOOLTIP PUBLIC CLASS DEFINITION
  // ===============================

  var Tooltip = function (element, options) {
    this.type       =
    this.options    =
    this.enabled    =
    this.timeout    =
    this.hoverState =
    this.$element   = null

    this.init('tooltip', element, options)
  }

  Tooltip.VERSION  = '3.2.0'

  Tooltip.DEFAULTS = {
    animation: true,
    placement: 'top',
    selector: false,
    template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
    trigger: 'hover focus',
    title: '',
    delay: 0,
    html: false,
    container: false,
    viewport: {
      selector: 'body',
      padding: 0
    }
  }

  Tooltip.prototype.init = function (type, element, options) {
    this.enabled   = true
    this.type      = type
    this.$element  = $(element)
    this.options   = this.getOptions(options)
    this.$viewport = this.options.viewport && $(this.options.viewport.selector || this.options.viewport)

    var triggers = this.options.trigger.split(' ')

    for (var i = triggers.length; i--;) {
      var trigger = triggers[i]

      if (trigger == 'click') {
        this.$element.on('click.' + this.type, this.options.selector, $.proxy(this.toggle, this))
      } else if (trigger != 'manual') {
        var eventIn  = trigger == 'hover' ? 'mouseenter' : 'focusin'
        var eventOut = trigger == 'hover' ? 'mouseleave' : 'focusout'

        this.$element.on(eventIn  + '.' + this.type, this.options.selector, $.proxy(this.enter, this))
        this.$element.on(eventOut + '.' + this.type, this.options.selector, $.proxy(this.leave, this))
      }
    }

    this.options.selector ?
      (this._options = $.extend({}, this.options, { trigger: 'manual', selector: '' })) :
      this.fixTitle()
  }

  Tooltip.prototype.getDefaults = function () {
    return Tooltip.DEFAULTS
  }

  Tooltip.prototype.getOptions = function (options) {
    options = $.extend({}, this.getDefaults(), this.$element.data(), options)

    if (options.delay && typeof options.delay == 'number') {
      options.delay = {
        show: options.delay,
        hide: options.delay
      }
    }

    return options
  }

  Tooltip.prototype.getDelegateOptions = function () {
    var options  = {}
    var defaults = this.getDefaults()

    this._options && $.each(this._options, function (key, value) {
      if (defaults[key] != value) options[key] = value
    })

    return options
  }

  Tooltip.prototype.enter = function (obj) {
    var self = obj instanceof this.constructor ?
      obj : $(obj.currentTarget).data('bs.' + this.type)

    if (!self) {
      self = new this.constructor(obj.currentTarget, this.getDelegateOptions())
      $(obj.currentTarget).data('bs.' + this.type, self)
    }

    clearTimeout(self.timeout)

    self.hoverState = 'in'

    if (!self.options.delay || !self.options.delay.show) return self.show()

    self.timeout = setTimeout(function () {
      if (self.hoverState == 'in') self.show()
    }, self.options.delay.show)
  }

  Tooltip.prototype.leave = function (obj) {
    var self = obj instanceof this.constructor ?
      obj : $(obj.currentTarget).data('bs.' + this.type)

    if (!self) {
      self = new this.constructor(obj.currentTarget, this.getDelegateOptions())
      $(obj.currentTarget).data('bs.' + this.type, self)
    }

    clearTimeout(self.timeout)

    self.hoverState = 'out'

    if (!self.options.delay || !self.options.delay.hide) return self.hide()

    self.timeout = setTimeout(function () {
      if (self.hoverState == 'out') self.hide()
    }, self.options.delay.hide)
  }

  Tooltip.prototype.show = function () {
    var e = $.Event('show.bs.' + this.type)

    if (this.hasContent() && this.enabled) {
      this.$element.trigger(e)

      var inDom = $.contains(document.documentElement, this.$element[0])
      if (e.isDefaultPrevented() || !inDom) return
      var that = this

      var $tip = this.tip()

      var tipId = this.getUID(this.type)

      this.setContent()
      $tip.attr('id', tipId)
      this.$element.attr('aria-describedby', tipId)

      if (this.options.animation) $tip.addClass('fade')

      var placement = typeof this.options.placement == 'function' ?
        this.options.placement.call(this, $tip[0], this.$element[0]) :
        this.options.placement

      var autoToken = /\s?auto?\s?/i
      var autoPlace = autoToken.test(placement)
      if (autoPlace) placement = placement.replace(autoToken, '') || 'top'

      $tip
        .detach()
        .css({ top: 0, left: 0, display: 'block' })
        .addClass(placement)
        .data('bs.' + this.type, this)

      this.options.container ? $tip.appendTo(this.options.container) : $tip.insertAfter(this.$element)

      var pos          = this.getPosition()
      var actualWidth  = $tip[0].offsetWidth
      var actualHeight = $tip[0].offsetHeight

      if (autoPlace) {
        var orgPlacement = placement
        var $parent      = this.$element.parent()
        var parentDim    = this.getPosition($parent)

        placement = placement == 'bottom' && pos.top   + pos.height       + actualHeight - parentDim.scroll > parentDim.height ? 'top'    :
                    placement == 'top'    && pos.top   - parentDim.scroll - actualHeight < 0                                   ? 'bottom' :
                    placement == 'right'  && pos.right + actualWidth      > parentDim.width                                    ? 'left'   :
                    placement == 'left'   && pos.left  - actualWidth      < parentDim.left                                     ? 'right'  :
                    placement

        $tip
          .removeClass(orgPlacement)
          .addClass(placement)
      }

      var calculatedOffset = this.getCalculatedOffset(placement, pos, actualWidth, actualHeight)

      this.applyPlacement(calculatedOffset, placement)

      var complete = function () {
        that.$element.trigger('shown.bs.' + that.type)
        that.hoverState = null
      }

      $.support.transition && this.$tip.hasClass('fade') ?
        $tip
          .one('bsTransitionEnd', complete)
          .emulateTransitionEnd(150) :
        complete()
    }
  }

  Tooltip.prototype.applyPlacement = function (offset, placement) {
    var $tip   = this.tip()
    var width  = $tip[0].offsetWidth
    var height = $tip[0].offsetHeight

    // manually read margins because getBoundingClientRect includes difference
    var marginTop = parseInt($tip.css('margin-top'), 10)
    var marginLeft = parseInt($tip.css('margin-left'), 10)

    // we must check for NaN for ie 8/9
    if (isNaN(marginTop))  marginTop  = 0
    if (isNaN(marginLeft)) marginLeft = 0

    offset.top  = offset.top  + marginTop
    offset.left = offset.left + marginLeft

    // $.fn.offset doesn't round pixel values
    // so we use setOffset directly with our own function B-0
    $.offset.setOffset($tip[0], $.extend({
      using: function (props) {
        $tip.css({
          top: Math.round(props.top),
          left: Math.round(props.left)
        })
      }
    }, offset), 0)

    $tip.addClass('in')

    // check to see if placing tip in new offset caused the tip to resize itself
    var actualWidth  = $tip[0].offsetWidth
    var actualHeight = $tip[0].offsetHeight

    if (placement == 'top' && actualHeight != height) {
      offset.top = offset.top + height - actualHeight
    }

    var delta = this.getViewportAdjustedDelta(placement, offset, actualWidth, actualHeight)

    if (delta.left) offset.left += delta.left
    else offset.top += delta.top

    var arrowDelta          = delta.left ? delta.left * 2 - width + actualWidth : delta.top * 2 - height + actualHeight
    var arrowPosition       = delta.left ? 'left'        : 'top'
    var arrowOffsetPosition = delta.left ? 'offsetWidth' : 'offsetHeight'

    $tip.offset(offset)
    this.replaceArrow(arrowDelta, $tip[0][arrowOffsetPosition], arrowPosition)
  }

  Tooltip.prototype.replaceArrow = function (delta, dimension, position) {
    this.arrow().css(position, delta ? (50 * (1 - delta / dimension) + '%') : '')
  }

  Tooltip.prototype.setContent = function () {
    var $tip  = this.tip()
    var title = this.getTitle()

    $tip.find('.tooltip-inner')[this.options.html ? 'html' : 'text'](title)
    $tip.removeClass('fade in top bottom left right')
  }

  Tooltip.prototype.hide = function () {
    var that = this
    var $tip = this.tip()
    var e    = $.Event('hide.bs.' + this.type)

    this.$element.removeAttr('aria-describedby')

    function complete() {
      if (that.hoverState != 'in') $tip.detach()
      that.$element.trigger('hidden.bs.' + that.type)
    }

    this.$element.trigger(e)

    if (e.isDefaultPrevented()) return

    $tip.removeClass('in')

    $.support.transition && this.$tip.hasClass('fade') ?
      $tip
        .one('bsTransitionEnd', complete)
        .emulateTransitionEnd(150) :
      complete()

    this.hoverState = null

    return this
  }

  Tooltip.prototype.fixTitle = function () {
    var $e = this.$element
    if ($e.attr('title') || typeof ($e.attr('data-original-title')) != 'string') {
      $e.attr('data-original-title', $e.attr('title') || '').attr('title', '')
    }
  }

  Tooltip.prototype.hasContent = function () {
    return this.getTitle()
  }

  Tooltip.prototype.getPosition = function ($element) {
    $element   = $element || this.$element
    var el     = $element[0]
    var isBody = el.tagName == 'BODY'
    return $.extend({}, (typeof el.getBoundingClientRect == 'function') ? el.getBoundingClientRect() : null, {
      scroll: isBody ? document.documentElement.scrollTop || document.body.scrollTop : $element.scrollTop(),
      width:  isBody ? $(window).width()  : $element.outerWidth(),
      height: isBody ? $(window).height() : $element.outerHeight()
    }, isBody ? { top: 0, left: 0 } : $element.offset())
  }

  Tooltip.prototype.getCalculatedOffset = function (placement, pos, actualWidth, actualHeight) {
    return placement == 'bottom' ? { top: pos.top + pos.height,   left: pos.left + pos.width / 2 - actualWidth / 2  } :
           placement == 'top'    ? { top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2  } :
           placement == 'left'   ? { top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth } :
        /* placement == 'right' */ { top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width   }

  }

  Tooltip.prototype.getViewportAdjustedDelta = function (placement, pos, actualWidth, actualHeight) {
    var delta = { top: 0, left: 0 }
    if (!this.$viewport) return delta

    var viewportPadding = this.options.viewport && this.options.viewport.padding || 0
    var viewportDimensions = this.getPosition(this.$viewport)

    if (/right|left/.test(placement)) {
      var topEdgeOffset    = pos.top - viewportPadding - viewportDimensions.scroll
      var bottomEdgeOffset = pos.top + viewportPadding - viewportDimensions.scroll + actualHeight
      if (topEdgeOffset < viewportDimensions.top) { // top overflow
        delta.top = viewportDimensions.top - topEdgeOffset
      } else if (bottomEdgeOffset > viewportDimensions.top + viewportDimensions.height) { // bottom overflow
        delta.top = viewportDimensions.top + viewportDimensions.height - bottomEdgeOffset
      }
    } else {
      var leftEdgeOffset  = pos.left - viewportPadding
      var rightEdgeOffset = pos.left + viewportPadding + actualWidth
      if (leftEdgeOffset < viewportDimensions.left) { // left overflow
        delta.left = viewportDimensions.left - leftEdgeOffset
      } else if (rightEdgeOffset > viewportDimensions.width) { // right overflow
        delta.left = viewportDimensions.left + viewportDimensions.width - rightEdgeOffset
      }
    }

    return delta
  }

  Tooltip.prototype.getTitle = function () {
    var title
    var $e = this.$element
    var o  = this.options

    title = $e.attr('data-original-title')
      || (typeof o.title == 'function' ? o.title.call($e[0]) :  o.title)

    return title
  }

  Tooltip.prototype.getUID = function (prefix) {
    do prefix += ~~(Math.random() * 1000000)
    while (document.getElementById(prefix))
    return prefix
  }

  Tooltip.prototype.tip = function () {
    return (this.$tip = this.$tip || $(this.options.template))
  }

  Tooltip.prototype.arrow = function () {
    return (this.$arrow = this.$arrow || this.tip().find('.tooltip-arrow'))
  }

  Tooltip.prototype.validate = function () {
    if (!this.$element[0].parentNode) {
      this.hide()
      this.$element = null
      this.options  = null
    }
  }

  Tooltip.prototype.enable = function () {
    this.enabled = true
  }

  Tooltip.prototype.disable = function () {
    this.enabled = false
  }

  Tooltip.prototype.toggleEnabled = function () {
    this.enabled = !this.enabled
  }

  Tooltip.prototype.toggle = function (e) {
    var self = this
    if (e) {
      self = $(e.currentTarget).data('bs.' + this.type)
      if (!self) {
        self = new this.constructor(e.currentTarget, this.getDelegateOptions())
        $(e.currentTarget).data('bs.' + this.type, self)
      }
    }

    self.tip().hasClass('in') ? self.leave(self) : self.enter(self)
  }

  Tooltip.prototype.destroy = function () {
    clearTimeout(this.timeout)
    this.hide().$element.off('.' + this.type).removeData('bs.' + this.type)
  }


  // TOOLTIP PLUGIN DEFINITION
  // =========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.tooltip')
      var options = typeof option == 'object' && option

      if (!data && option == 'destroy') return
      if (!data) $this.data('bs.tooltip', (data = new Tooltip(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.tooltip

  $.fn.tooltip             = Plugin
  $.fn.tooltip.Constructor = Tooltip


  // TOOLTIP NO CONFLICT
  // ===================

  $.fn.tooltip.noConflict = function () {
    $.fn.tooltip = old
    return this
  }

}(jQuery);

/* ========================================================================
 * Bootstrap: popover.js v3.2.0
 * http://getbootstrap.com/javascript/#popovers
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // POPOVER PUBLIC CLASS DEFINITION
  // ===============================

  var Popover = function (element, options) {
    this.init('popover', element, options)
  }

  if (!$.fn.tooltip) throw new Error('Popover requires tooltip.js')

  Popover.VERSION  = '3.2.0'

  Popover.DEFAULTS = $.extend({}, $.fn.tooltip.Constructor.DEFAULTS, {
    placement: 'right',
    trigger: 'click',
    content: '',
    template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
  })


  // NOTE: POPOVER EXTENDS tooltip.js
  // ================================

  Popover.prototype = $.extend({}, $.fn.tooltip.Constructor.prototype)

  Popover.prototype.constructor = Popover

  Popover.prototype.getDefaults = function () {
    return Popover.DEFAULTS
  }

  Popover.prototype.setContent = function () {
    var $tip    = this.tip()
    var title   = this.getTitle()
    var content = this.getContent()

    $tip.find('.popover-title')[this.options.html ? 'html' : 'text'](title)
    $tip.find('.popover-content').empty()[ // we use append for html objects to maintain js events
      this.options.html ? (typeof content == 'string' ? 'html' : 'append') : 'text'
    ](content)

    $tip.removeClass('fade top bottom left right in')

    // IE8 doesn't accept hiding via the `:empty` pseudo selector, we have to do
    // this manually by checking the contents.
    if (!$tip.find('.popover-title').html()) $tip.find('.popover-title').hide()
  }

  Popover.prototype.hasContent = function () {
    return this.getTitle() || this.getContent()
  }

  Popover.prototype.getContent = function () {
    var $e = this.$element
    var o  = this.options

    return $e.attr('data-content')
      || (typeof o.content == 'function' ?
            o.content.call($e[0]) :
            o.content)
  }

  Popover.prototype.arrow = function () {
    return (this.$arrow = this.$arrow || this.tip().find('.arrow'))
  }

  Popover.prototype.tip = function () {
    if (!this.$tip) this.$tip = $(this.options.template)
    return this.$tip
  }


  // POPOVER PLUGIN DEFINITION
  // =========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.popover')
      var options = typeof option == 'object' && option

      if (!data && option == 'destroy') return
      if (!data) $this.data('bs.popover', (data = new Popover(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.popover

  $.fn.popover             = Plugin
  $.fn.popover.Constructor = Popover


  // POPOVER NO CONFLICT
  // ===================

  $.fn.popover.noConflict = function () {
    $.fn.popover = old
    return this
  }

}(jQuery);

/* ========================================================================
 * Bootstrap: scrollspy.js v3.2.0
 * http://getbootstrap.com/javascript/#scrollspy
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // SCROLLSPY CLASS DEFINITION
  // ==========================

  function ScrollSpy(element, options) {
    var process  = $.proxy(this.process, this)

    this.$body          = $('body')
    this.$scrollElement = $(element).is('body') ? $(window) : $(element)
    this.options        = $.extend({}, ScrollSpy.DEFAULTS, options)
    this.selector       = (this.options.target || '') + ' .nav li > a'
    this.offsets        = []
    this.targets        = []
    this.activeTarget   = null
    this.scrollHeight   = 0

    this.$scrollElement.on('scroll.bs.scrollspy', process)
    this.refresh()
    this.process()
  }

  ScrollSpy.VERSION  = '3.2.0'

  ScrollSpy.DEFAULTS = {
    offset: 10
  }

  ScrollSpy.prototype.getScrollHeight = function () {
    return this.$scrollElement[0].scrollHeight || Math.max(this.$body[0].scrollHeight, document.documentElement.scrollHeight)
  }

  ScrollSpy.prototype.refresh = function () {
    var offsetMethod = 'offset'
    var offsetBase   = 0

    if (!$.isWindow(this.$scrollElement[0])) {
      offsetMethod = 'position'
      offsetBase   = this.$scrollElement.scrollTop()
    }

    this.offsets = []
    this.targets = []
    this.scrollHeight = this.getScrollHeight()

    var self     = this

    this.$body
      .find(this.selector)
      .map(function () {
        var $el   = $(this)
        var href  = $el.data('target') || $el.attr('href')
        var $href = /^#./.test(href) && $(href)

        return ($href
          && $href.length
          && $href.is(':visible')
          && [[$href[offsetMethod]().top + offsetBase, href]]) || null
      })
      .sort(function (a, b) { return a[0] - b[0] })
      .each(function () {
        self.offsets.push(this[0])
        self.targets.push(this[1])
      })
  }

  ScrollSpy.prototype.process = function () {
    var scrollTop    = this.$scrollElement.scrollTop() + this.options.offset
    var scrollHeight = this.getScrollHeight()
    var maxScroll    = this.options.offset + scrollHeight - this.$scrollElement.height()
    var offsets      = this.offsets
    var targets      = this.targets
    var activeTarget = this.activeTarget
    var i

    if (this.scrollHeight != scrollHeight) {
      this.refresh()
    }

    if (scrollTop >= maxScroll) {
      return activeTarget != (i = targets[targets.length - 1]) && this.activate(i)
    }

    if (activeTarget && scrollTop <= offsets[0]) {
      return activeTarget != (i = targets[0]) && this.activate(i)
    }

    for (i = offsets.length; i--;) {
      activeTarget != targets[i]
        && scrollTop >= offsets[i]
        && (!offsets[i + 1] || scrollTop <= offsets[i + 1])
        && this.activate(targets[i])
    }
  }

  ScrollSpy.prototype.activate = function (target) {
    this.activeTarget = target

    $(this.selector)
      .parentsUntil(this.options.target, '.active')
      .removeClass('active')

    var selector = this.selector +
        '[data-target="' + target + '"],' +
        this.selector + '[href="' + target + '"]'

    var active = $(selector)
      .parents('li')
      .addClass('active')

    if (active.parent('.dropdown-menu').length) {
      active = active
        .closest('li.dropdown')
        .addClass('active')
    }

    active.trigger('activate.bs.scrollspy')
  }


  // SCROLLSPY PLUGIN DEFINITION
  // ===========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.scrollspy')
      var options = typeof option == 'object' && option

      if (!data) $this.data('bs.scrollspy', (data = new ScrollSpy(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.scrollspy

  $.fn.scrollspy             = Plugin
  $.fn.scrollspy.Constructor = ScrollSpy


  // SCROLLSPY NO CONFLICT
  // =====================

  $.fn.scrollspy.noConflict = function () {
    $.fn.scrollspy = old
    return this
  }


  // SCROLLSPY DATA-API
  // ==================

  $(window).on('load.bs.scrollspy.data-api', function () {
    $('[data-spy="scroll"]').each(function () {
      var $spy = $(this)
      Plugin.call($spy, $spy.data())
    })
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: tab.js v3.2.0
 * http://getbootstrap.com/javascript/#tabs
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // TAB CLASS DEFINITION
  // ====================

  var Tab = function (element) {
    this.element = $(element)
  }

  Tab.VERSION = '3.2.0'

  Tab.prototype.show = function () {
    var $this    = this.element
    var $ul      = $this.closest('ul:not(.dropdown-menu)')
    var selector = $this.data('target')

    if (!selector) {
      selector = $this.attr('href')
      selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
    }

    if ($this.parent('li').hasClass('active')) return

    var previous = $ul.find('.active:last a')[0]
    var e        = $.Event('show.bs.tab', {
      relatedTarget: previous
    })

    $this.trigger(e)

    if (e.isDefaultPrevented()) return

    var $target = $(selector)

    this.activate($this.closest('li'), $ul)
    this.activate($target, $target.parent(), function () {
      $this.trigger({
        type: 'shown.bs.tab',
        relatedTarget: previous
      })
    })
  }

  Tab.prototype.activate = function (element, container, callback) {
    var $active    = container.find('> .active')
    var transition = callback
      && $.support.transition
      && $active.hasClass('fade')

    function next() {
      $active
        .removeClass('active')
        .find('> .dropdown-menu > .active')
        .removeClass('active')

      element.addClass('active')

      if (transition) {
        element[0].offsetWidth // reflow for transition
        element.addClass('in')
      } else {
        element.removeClass('fade')
      }

      if (element.parent('.dropdown-menu')) {
        element.closest('li.dropdown').addClass('active')
      }

      callback && callback()
    }

    transition ?
      $active
        .one('bsTransitionEnd', next)
        .emulateTransitionEnd(150) :
      next()

    $active.removeClass('in')
  }


  // TAB PLUGIN DEFINITION
  // =====================

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data('bs.tab')

      if (!data) $this.data('bs.tab', (data = new Tab(this)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.tab

  $.fn.tab             = Plugin
  $.fn.tab.Constructor = Tab


  // TAB NO CONFLICT
  // ===============

  $.fn.tab.noConflict = function () {
    $.fn.tab = old
    return this
  }


  // TAB DATA-API
  // ============

  $(document).on('click.bs.tab.data-api', '[data-toggle="tab"], [data-toggle="pill"]', function (e) {
    e.preventDefault()
    Plugin.call($(this), 'show')
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: affix.js v3.2.0
 * http://getbootstrap.com/javascript/#affix
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // AFFIX CLASS DEFINITION
  // ======================

  var Affix = function (element, options) {
    this.options = $.extend({}, Affix.DEFAULTS, options)

    this.$target = $(this.options.target)
      .on('scroll.bs.affix.data-api', $.proxy(this.checkPosition, this))
      .on('click.bs.affix.data-api',  $.proxy(this.checkPositionWithEventLoop, this))

    this.$element     = $(element)
    this.affixed      =
    this.unpin        =
    this.pinnedOffset = null

    this.checkPosition()
  }

  Affix.VERSION  = '3.2.0'

  Affix.RESET    = 'affix affix-top affix-bottom'

  Affix.DEFAULTS = {
    offset: 0,
    target: window
  }

  Affix.prototype.getPinnedOffset = function () {
    if (this.pinnedOffset) return this.pinnedOffset
    this.$element.removeClass(Affix.RESET).addClass('affix')
    var scrollTop = this.$target.scrollTop()
    var position  = this.$element.offset()
    return (this.pinnedOffset = position.top - scrollTop)
  }

  Affix.prototype.checkPositionWithEventLoop = function () {
    setTimeout($.proxy(this.checkPosition, this), 1)
  }

  Affix.prototype.checkPosition = function () {
    if (!this.$element.is(':visible')) return

    var scrollHeight = $(document).height()
    var scrollTop    = this.$target.scrollTop()
    var position     = this.$element.offset()
    var offset       = this.options.offset
    var offsetTop    = offset.top
    var offsetBottom = offset.bottom

    if (typeof offset != 'object')         offsetBottom = offsetTop = offset
    if (typeof offsetTop == 'function')    offsetTop    = offset.top(this.$element)
    if (typeof offsetBottom == 'function') offsetBottom = offset.bottom(this.$element)

    var affix = this.unpin   != null && (scrollTop + this.unpin <= position.top) ? false :
                offsetBottom != null && (position.top + this.$element.height() >= scrollHeight - offsetBottom) ? 'bottom' :
                offsetTop    != null && (scrollTop <= offsetTop) ? 'top' : false

    if (this.affixed === affix) return
    if (this.unpin != null) this.$element.css('top', '')

    var affixType = 'affix' + (affix ? '-' + affix : '')
    var e         = $.Event(affixType + '.bs.affix')

    this.$element.trigger(e)

    if (e.isDefaultPrevented()) return

    this.affixed = affix
    this.unpin = affix == 'bottom' ? this.getPinnedOffset() : null

    this.$element
      .removeClass(Affix.RESET)
      .addClass(affixType)
      .trigger($.Event(affixType.replace('affix', 'affixed')))

    if (affix == 'bottom') {
      this.$element.offset({
        top: scrollHeight - this.$element.height() - offsetBottom
      })
    }
  }


  // AFFIX PLUGIN DEFINITION
  // =======================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.affix')
      var options = typeof option == 'object' && option

      if (!data) $this.data('bs.affix', (data = new Affix(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.affix

  $.fn.affix             = Plugin
  $.fn.affix.Constructor = Affix


  // AFFIX NO CONFLICT
  // =================

  $.fn.affix.noConflict = function () {
    $.fn.affix = old
    return this
  }


  // AFFIX DATA-API
  // ==============

  $(window).on('load', function () {
    $('[data-spy="affix"]').each(function () {
      var $spy = $(this)
      var data = $spy.data()

      data.offset = data.offset || {}

      if (data.offsetBottom) data.offset.bottom = data.offsetBottom
      if (data.offsetTop)    data.offset.top    = data.offsetTop

      Plugin.call($spy, data)
    })
  })

}(jQuery);
