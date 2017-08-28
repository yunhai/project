function initialize() {
	var latlng, address;

	var geocoder = new google.maps.Geocoder();

	if (geocoder) {
		var option = {
			zoom: 18,
			draggable:true,
			animation: google.maps.Animation.DROP,
			mapTypeControl: true,
			mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
			navigationControl: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		map = new google.maps.Map(document.getElementById("map_canvas"), option);

		var target = $('#map_canvas');

		var latlngStr = target.data('geo');
		if (latlngStr) {
			latlngStr = latlngStr.split(',', 2);
			latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
			geoOption = {'location': latlng};
		}

		geocoder.geocode(geoOption, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
					latlng = results[0].geometry.location
					map.setCenter(latlng);

					marker = new google.maps.Marker({
						position: results[0].geometry.location,
						map: map,
						title: address,
						draggable: true,
						animation: google.maps.Animation.DROP,
					});

					option = {
						content: $('#map-template').html(),
						size: new google.maps.Size(150,50)
					}
					var infowindow = new google.maps.InfoWindow(option).open(map, marker);
				}
			}
		});
	}
}

initialize();