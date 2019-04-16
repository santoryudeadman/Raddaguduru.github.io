jQuery(document).ready(function( $ ) {

"use strict";

var infowindows = [];
var markers = [];
var map = null;
var openedInfo = null;

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/* google */
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

function initialize() {

    var map_canvas = document.getElementsByClassName( 'fwp-map' );

    [].forEach.call( map_canvas, function( el ) {

    markers = [];

    var mapId = el.getAttribute( 'data-mapId' );

    var myLat = fastwp[mapId].gmap_center[0];
    var myLng = fastwp[mapId].gmap_center[1];

    var map_options = {
        center: new google.maps.LatLng( myLat, myLng ),
        zoom: parseInt( fastwp[mapId].gmap_zoom ),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false
    };

    map = new google.maps.Map( el, map_options );

    if( typeof fastwp[mapId].gmap_marker_addrs != undefined && fastwp[mapId].gmap_marker_addrs.length > 0 ) {
        for( var i = 0; i < fastwp[mapId].gmap_marker_addrs.length; i++ ) {
            var title = (typeof fastwp[mapId].gmap_marker_title[i] != undefined? fastwp[mapId].gmap_marker_title[i] : '');

            var mlat = fastwp[mapId].gmap_marker_addrs[i][0];
            var mlng = fastwp[mapId].gmap_marker_addrs[i][1];

            markers[i] = new google.maps.Marker({
                position: new google.maps.LatLng(mlat, mlng),
                map: map,
                title: title
            });
        };
    }

    if( typeof fastwp[mapId].gmap_style == 'undefined' || fastwp[mapId].gmap_style == 'fastwp' ) {
        var styles = [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"administrative.province","elementType":"geometry.fill","stylers":[{"visibility":"on"}]},{"featureType":"administrative.province","elementType":"labels.text.fill","stylers":[{"visibility":"on"}]},{"featureType":"administrative.land_parcel","elementType":"geometry.fill","stylers":[{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#c6cbcd"},{"visibility":"on"}]}];
        map.setOptions({styles: styles});
    }

    if( markers.length > 0 ){
        for( i = 0; i<markers.length; i++ ) {
            var contentString   = ( typeof fastwp[mapId].gmap_marker_ct[i] != 'undefined' ) ? fastwp[mapId].gmap_marker_ct[i] : '';
            infowindows[i]      = new google.maps.InfoWindow({  content: contentString });
            google.maps.event.addListener( markers[i], 'click', makeMapListener( infowindows[i], map, markers[i], i, mapId ) );
        };
    }

    $( '.map-pan-link' ).on( 'click', function(e) {
        e.preventDefault();
        var t = $(this);
        var all = $(this).parents( 'ul' );
        all.find( 'a.active' ).removeClass( 'active' );
        t.addClass( 'active' );
        map.setCenter( {lat: t.data( 'lat' ), lng: t.data( 'lng' ) } );
    });

    });

}


function makeMapListener( window, map, markers, index, mapId ) {
    return function() {
        if(typeof openedInfo == 'string'){
            try{
                eval(openedInfo).close();
            } catch(e){ }
        }
        map.setZoom( parseInt( fastwp[mapId].gmap_izoom ) );
        map.setCenter( markers.getPosition() );
        window.open( map, markers );
        openedInfo = 'infowindows[' + index + ']';
    };
}

google.maps.event.addDomListener( window, 'load', initialize );

});