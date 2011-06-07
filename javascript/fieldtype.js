$('.map').each(function()
{
	var $div = $(this);
	var fieldId = $(this).attr('data-field-id');
	
	// Turn our empty DIV elements into maps
	var map = new google.maps.Map(this,
	{
		zoom: 1,
		center: new google.maps.LatLng(0, 0),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	
	// Listen for clicks on each DIV and add markers
	google.maps.event.addListener(map, "click", function(event)
	{
		createMarker(event.latLng);
		
		// Store the results in a hidden field for EE
		$div.after($('<input />', {
			"type": "hidden",
			"class": "geodePoint",
			"name": "field_id_"+fieldId+"[]",
			"value": event.latLng.toUrlValue()
		}));
	});
	
	// Add stored markers
	$('input[name="field_id_'+fieldId+'[]"]').each(function()
	{
		var point = $(this).val().split(',');
		var latLng = new google.maps.LatLng(point[0], point[1]);
		
		createMarker(latLng);
	});
	
	// Create a Marker
	function createMarker(latLng)
	{
		// Add the marker
		var marker = new google.maps.Marker({
			map: map,
			position: latLng
		});
		
		// listen for clicks on the marker to remove it
		google.maps.event.addListener(marker, "click", function(event)
		{
			// Remove the marker
			marker.setMap(null);
			
			// Find the hidden input to remove
			$('input.geodePoint[value="'+event.latLng.toUrlValue()+'"]').remove();
		});
	}
});