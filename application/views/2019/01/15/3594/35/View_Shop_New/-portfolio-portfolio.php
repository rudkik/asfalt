<div class="box-portfolio">
    <img class="one" src="<?php echo Helpers_Image::getPhotoPath(Helpers_Image::getOptimalSizePhotoPath($data->values['files'], 403, 310, $data->values['image_path']), 403, 310); ?>">
    <img class="two" src="<?php echo Helpers_Image::getPhotoPath(Helpers_Image::getOptimalSizePhotoPath($data->values['files'], 403, 480, $data->values['image_path']), 403, 480); ?>">
	
    <div class="select">
        <a href="<?php echo $siteData->urlBasicLanguage; ?>/portfolio<?php echo $data->values['name_url']; ?>"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/search.png"></a>
    </div>
</div>