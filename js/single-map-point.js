var MapTool = new MapUtilityClass($);

var mymap = MapTool.initMap();


var postID = document.querySelector('.post-id').value;

MapTool.getMapPointsById(postID)
.then(data => {
    MapTool.addSingleMapMarker(data, mymap)
    mymap.flyTo([data.meta.latitude, data.meta.longitude])
})