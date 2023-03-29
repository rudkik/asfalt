<div class="col-lg-4 article">
    <div class="box-img-article">
        <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 403, 356); ?>">
        <div class="border-date"><div class="box-date"><?php echo Helpers_DateTime::getDateFormatRus($data->values['created_at']); ?></div></div>
    </div>
    <p class="title"><a href="<?php echo $siteData->urlBasicLanguage; ?>/articles<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a></p>
    <div class="info"><?php echo Arr::path($data->values['options'], 'info', ''); ?></div>
    <a href="<?php echo $siteData->urlBasicLanguage; ?>/articles<?php echo $data->values['name_url']; ?>">Подробнее ></a>
</div>