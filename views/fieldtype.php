<div
	data-field-id='<?php echo $field_id ?>'
	class='map'
	style='width:100%;height:400px;'>
</div>

<?php if (is_array($data)): foreach ($data as $point): ?>
	<input
		type="hidden"
		class="geodePoint"
		name="field_id_<?php echo $field_id ?>[]"
		value="<?php echo $point ?>" />
<?php endforeach; endif; ?>