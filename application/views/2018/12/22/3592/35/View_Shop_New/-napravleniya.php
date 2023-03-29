<div class="col-md-2-5 department">
    <div class="media-left">
        <img class="active" src="<?php echo Func::addSiteNameInFilePath(Helpers_Image::getPhotoPathByImageType($data->values['files'], 'no_active'), $siteData); ?>">
        <img class="no-active" src="<?php echo Func::addSiteNameInFilePath(Helpers_Image::getPhotoPathByImageType($data->values['files'], 'active'), $siteData); ?>">
    </div>
    <div class="media-body">
        <div class="box-text"><a href="<?php echo $siteData->urlBasicLanguage; ?>/directions<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a></div>
    </div>
</div>