<div class="col-md-6">
    <div class="article">
        <div class="box-img">
            <div class="date"><?php echo Helpers_DateTime::getDateTimeDayMonth($siteData, $data->values['created_at'], FALSE); ?></div>
            <img itemprop="associatedMedia" class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 413, 293); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        </div>
        <div class="box-text">
            <p class="title"><a href="<?php echo $siteData->urlBasicLanguage; ?>/articles<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a></p>
            <p class="info"><?php echo Arr::path($data->values['options'], 'info', ''); ?></p>
            <a class="next" href="<?php echo $siteData->urlBasicLanguage; ?>/articles<?php echo $data->values['name_url']; ?>">Подробнее &gt;</a>
        </div>
    </div>
</div>