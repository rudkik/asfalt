<div class="col-sm-6 doctor">
    <img itemprop="associatedMedia" class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 468, 350); ?>">
    <a href="<?php echo $siteData->urlBasicLanguage; ?>/doctors<?php echo $data->values['name_url']; ?>" class="name"><?php echo $data->values['name']; ?></a>
    <p class="info"><?php echo Arr::path($data->values['options'], 'info', ''); ?></p>
</div>