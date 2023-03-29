<div class="col-md-6 service">
    <div class="yellow" style="background: url('<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 713, 305); ?>') no-repeat scroll center top transparent;">
        <div class="bg-gradient">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/services<?php echo $data->values['name_url']; ?>" class="btn btn-default">Подробнее</a>
            <p class="title"><?php echo $data->values['name']; ?></p>
        </div>
    </div>
</div>