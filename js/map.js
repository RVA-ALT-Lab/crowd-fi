var MapTool = new MapUtilityClass(jQuery);

var mymap = MapTool.initMap();

MapTool.startGeolocation(mymap)

var userPositionCircle = L.circle(
    MapTool.richmondCentroid
    ).addTo(mymap);

function onLocationFound (e) {
    userPositionCircle.setLatLng([e.latitude, e.longitude]);
    MapTool.stopGeolocation(mymap);
}

mymap.on('locationfound', onLocationFound);

MapTool.getMapPoints()
.then(data => {
    MapTool.addMapMarkers(data, mymap)
})