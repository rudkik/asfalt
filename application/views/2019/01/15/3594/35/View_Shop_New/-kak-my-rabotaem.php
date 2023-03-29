<div class="col-lg-6 work">
    <div class="box-img-work">
        <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 630, 355); ?>">
        <div class="box-circle">#index#</div>
    </div>
    <p class="title"><a href="<?php echo $siteData->urlBasicLanguage; ?>/work-stages<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a></p>
    <div class="info"><?php echo Arr::path($data->values['options'], 'info', ''); ?></div>
    <a href="<?php echo $siteData->urlBasicLanguage; ?>/work-stages<?php echo $data->values['name_url']; ?>">Подробнее ></a>
</div>