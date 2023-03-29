<li>
    <a href="<?php echo Arr::path($data->values['options'], 'url', ''); ?>" target="_blank">
        <img src="<?php echo $data->values['image_path']; ?>" class="img-responsive social" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </a>
</li>