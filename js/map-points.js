var MapTool = new MapUtilityClass($);

var mymap = MapTool.initMap();

var mapPoints;
MapTool.getMapPoints()
.then(data => {
    MapTool.addMapMarkers(data, mymap)
    mapPoints = data
    console.log(data)
})

var zoomButtons = document.querySelectorAll('.zoom-button');

var zoomButtonsArray = Array.from(zoomButtons);

zoomButtonsArray.forEach(button => {
    button.addEventListener('click', function(event){
        var clickedPoint = mapPoints.filter(point => point.id == this.getAttribute('data-id'))[0]
        mymap.flyTo([clickedPoint.meta.latitude, clickedPoint.meta.longitude])
    })
})