function usoftMapInit()
{
	usoftMap = new ymaps.Map("map", {
		center: [usoftMapCenter.lon, usoftMapCenter.lat],
		zoom: usoftMapCenter.zoom
	});

/*      // Передаём объект с метками в качестве параметра
    var usoftMapCollection = ymaps.geoQuery(usoftPlacemarks);
 
    if (usoftMapCollection.isReady()) {
        // В цикле добавляем каждую метку на карту
        for (i = 0; i < usoftMapCollection.getLength(); i++) {
            var pm = usoftMapCollection.get(i);
            if (pm.properties.get('name')) {
                pm.properties.set({
                    'hintContent': pm.properties.get('name')
                });
 
            }
            usoftMap.geoObjects.add(pm);
        }
    } */
}

$(document).ready(function(){
	$('#usoftMapAddPlacemark').click(function(){
		var lon = $('#usoftMapControls input[name="lon"]').val();
		var lat = $('#usoftMapControls input[name="lat"]').val();
		if (lon == "") lon = $('#usoftMapControls input[name="lon"]').attr('placeholder');
		if (lat == "") lat = $('#usoftMapControls input[name="lat"]').attr('placeholder');
 		myPlacemark = new ymaps.Placemark([lon, lat], {}, {
            draggable: true,
        });
//		usoftPlacemarks[] = usoftMap.geoObjects.add(myPlacemark);
//		console.log(usoftPlacemarks);
 	});
});