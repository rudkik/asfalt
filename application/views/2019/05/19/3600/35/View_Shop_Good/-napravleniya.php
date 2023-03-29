<div class="col-md-6">
    <div class="box-direction">
        <a href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $data->values['name_url']; ?>">
            <img class="basic" src="<?php echo Helpers_Image::getPhotoPathByImageType($data->values['files'], 'basic');?>">
            <img class="active" src="<?php echo Helpers_Image::getPhotoPathByImageType($data->values['files'], 'active');?>">
        </a>
        <a class="name" href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a>
    </div>
</div>
