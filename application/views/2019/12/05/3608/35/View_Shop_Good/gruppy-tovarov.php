<div class="col-xs-3 box-category" style="background-image: url('<?php echo Helpers_Image::getPhotoPathByImageType($data->values['files'], 'background'); ?>');">
    <a href="<?php echo $siteData->urlBasicLanguage; ?>/groups<?php echo $data->values['name_url']; ?>">
        <img src="<?php echo Helpers_Image::getPhotoPathByImageType($data->values['files'], 'main'); ?>">
        <h3><?php echo $data->values['name']; ?></h3>
    </a>
</div>