<div class="col-sm-6 col-md-3">
    <div class="thumbnail">
        <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 200, 200); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        <div class="caption ">
            <h3 class="center"><?php echo $data->values['name']; ?></h3>
            <p class="center" id="zag"></p>
            <p class="center"><a href="<?php echo $siteData->urlBasicLanguage; ?>/products<?php echo $data->values['name_url']; ?>" class="btn btn-default" role="button">Подробнее</a></p>
        </div>
    </div>
</div>
