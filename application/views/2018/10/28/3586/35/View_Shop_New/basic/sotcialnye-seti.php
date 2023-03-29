<a href="<?php echo Arr::path($data->values['options'], 'url', ''); ?>">
	<img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 26, 26); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
</a>