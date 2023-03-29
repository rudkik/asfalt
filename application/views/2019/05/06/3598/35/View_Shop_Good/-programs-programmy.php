<div class="col-md-12 box-program">
    <div class="row">
        <div class="col-md-2">
            <img class="img-box" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 300, NULL); ?>">
        </div>
        <div class="col-md-10">
            <a class="name" href="<?php echo $siteData->urlBasicLanguage; ?>/programs<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a>
            <div class="text"><?php echo Arr::path($data->values['options'], 'info', ''); ?></div>
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/programs<?php echo $data->values['name_url']; ?>">Подробнее <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/arrow.png"></a>
        </div>
    </div>
</div>