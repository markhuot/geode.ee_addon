<div
	id="map<?php echo $id ?>"
	class="<?php echo @$class_name ?>"
	style="width:100%; height: 500px;">
</div>

<script>
(function()
{
	var map = new google.maps.Map(document.getElementById('map<?php echo $id ?>'),
	{
		zoom: 1,
		center: new google.maps.LatLng(0, 0),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	
	<?php foreach ($data as $point): ?>
	(function ()
	{
		var marker = new google.maps.Marker({
			map: map,
			position: new google.maps.LatLng(<?php echo $point["0"]; ?>, <?php echo $point["1"]; ?>)
		});
		
		google.maps.event.addListener(marker, "click", function(event)
		{
			var infoWindow = new google.maps.InfoWindow({
				"content": "Edit: <a href='<?php echo BASE.'&C=content_publish&M=entry_form&channel_id='.$point['channel_id'].'&entry_id='.$point['entry_id'] ?>'><?php echo $point['title'] ?></a>"
			});
			
			infoWindow.open(map, marker);
		});
	})();
	<?php endforeach; ?>
})();
</script>