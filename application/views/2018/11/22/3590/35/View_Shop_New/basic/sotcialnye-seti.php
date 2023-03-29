<li>
	<a href="<?php echo Arr::path($data->values['options'], 'url', ''); ?>" target="blank">
		<img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 32, 32); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
	</a>
</li>