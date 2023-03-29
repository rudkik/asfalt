<div class="col-md-6 box-article">
    <img class="img-box" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 660, 440); ?>">
    <a class="name" href="<?php echo $siteData->urlBasicLanguage; ?>/articles<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a>
    <div class="text"><?php echo Arr::path($data->values['options'], 'info', ''); ?></div>
    <a href="<?php echo $siteData->urlBasicLanguage; ?>/articles<?php echo $data->values['name_url']; ?>">Подробнее <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/arrow.png"></a>
</div>