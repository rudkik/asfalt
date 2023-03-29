<div itemscope itemtype="http://schema.org/ImageObject" style="display: none;">
    <h2 itemprop="name"><?php echo $data->values['name']; ?></h2>
    <h2 itemprop="caption"><?php echo $data->values['name']; ?></h2>
    <img src=​"<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 900, 800); ?>" itemprop="contentUrl" />
    <span itemprop="description"><?php echo Arr::path($data->values, 'text', Arr::path($data->values, 'info', '')); ?></span>
</div>