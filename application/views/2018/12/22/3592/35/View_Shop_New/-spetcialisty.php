<div class="col-md-2-5 worker">
    <a href="<?php echo $siteData->urlBasicLanguage; ?>/doctors<?php echo $data->values['name_url']; ?>"><img itemprop="associatedMedia" class="img-circle" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 149, 149); ?>"></a>
    <div class="name"><a href="<?php echo $siteData->urlBasicLanguage; ?>/doctors<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a></div>
    <div class="position"><?php echo Arr::path($data->values['options'], 'position', ''); ?></div>
</div>
