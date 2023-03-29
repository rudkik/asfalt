<div class="col-sm-2-5">
    <div class="body">
        <a href="<?php echo $siteData->urlBasicLanguage; ?>/led<?php echo $data->values['name_url']; ?>">
            <span class="title"><?php echo $data->values['name'];?></span>
            <img style="width: 100%" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 340, 255);?>" />
        </a>
    </div>
</div>