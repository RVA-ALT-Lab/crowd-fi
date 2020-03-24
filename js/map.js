var MapTool = new MapUtilityClass(jQuery);

var mymap = MapTool.initMap();


MapTool.getMapPoints()
.then(data => {
    MapTool.addMapMarkers(data, mymap)
})