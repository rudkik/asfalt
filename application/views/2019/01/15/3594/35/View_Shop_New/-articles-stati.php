<div class="col-md-4 box-article">
    <div class="box-img">
        <img src="<?php echo Helpers_Image::getPhotoPath(Helpers_Image::getOptimalSizePhotoPath($data->values['files'], 403, 356, $data->values['image_path']), 403, 356); ?>">
        <div class="date"><span><?php echo $data->values['created_at']; ?></span></div>
    </div>
    <h3><a href="<?php echo $siteData->urlBasicLanguage; ?>/articles<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a></h3>
    <p class="info"><?php echo Func::trimTextNew($data->values['text'], 180); ?></p>
    <a class="more" href="<?php echo $siteData->urlBasicLanguage; ?>/articles<?php echo $data->values['name_url']; ?>">Подробнее &gt;</a>
</div>