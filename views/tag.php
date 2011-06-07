<div
	id="map<?php echo $id ?>"
	class="<?php echo @$class_name ?>"
	style="width:400px; height: 400px;">
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
	new google.maps.Marker({
		map: map,
		position: new google.maps.LatLng(<?php echo $point[0]; ?>, <?php echo $point[1]; ?>)
	});
	<?php endforeach; ?>
})();
</script>