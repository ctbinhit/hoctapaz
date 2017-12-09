var infowindow, infowindowContent;
var marker, map;
var latlng, zoom;
var input = document.getElementById('search-map');

function initAutocomplete() {
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    autocomplete.addListener('place_changed', function () {
        //infowindow.close();
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }

        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(zoom);
        }

        // Set the position of the marker using the place ID and location.
        marker.setPlace({
            placeId: place.place_id,
            location: place.geometry.location

        });

        marker.setIcon('http://wfarm3.dataknet.com/static/resources/icons/set28/58aac1c.png');

        marker.setVisible(true);
        console.log(place);
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        $('#pos_latitude').val(lat);
        $('#pos_longitude').val(lng);

        $('#position').val(place.geometry);
        $('#address').val(place.formatted_address);

        //console.log(place);
//        infowindowContent.children['place-name'].textContent = place.name;
//        infowindowContent.children['place-id'].textContent = place.place_id;
//        infowindowContent.children['place-address'].textContent =
//                place.formatted_address;
//        infowindow.open(map, marker);
    });
}



function setLatLng(x, y) {
    latlng = {lat: parseFloat(x), lng: parseFloat(y)};
}

function addMarker() {
    marker = new google.maps.Marker({
        map: map,
        position: latlng,
        zoom: 14,
    });
}

function setInfoWindow(title, desc) {
    infowindow = new google.maps.InfoWindow();
    infowindow.setContent('<b>' + title + '</b>' + '<br>'
            + '<div style="padding: 10px 0px;">' + desc + '</div>');
}

function markerChange(latlng, map) {
    marker.setPosition(latlng);
    $('#pos_latitude').val(latlng.lat());
    $('#pos_longitude').val(latlng.lng());
}

function initMap(plat, plng, zoom = 14, info_title = '', info_desc = '') {
    zoom = zoom;
    latlng = {lat: parseFloat(plat), lng: parseFloat(plng)};

    map = new google.maps.Map(document.getElementById('map_preview'), {
        center: latlng,
        zoom: zoom
    });
    marker = new google.maps.Marker({
        map: map,
        position: latlng,
        zoom: zoom,
        icon: ''
    });
    infowindow.open(map, marker);
    marker.setVisible(true);
    marker.addListener('click', function () {
        infowindow.open(map, marker);
    });

    map.addListener('click', function (e) {
        markerChange(e.latLng, map);
    });

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    initAutocomplete();
}