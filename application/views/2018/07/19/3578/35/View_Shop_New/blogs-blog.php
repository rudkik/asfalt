<div class="box-blog">
    <div class="box-img-date">
        <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 910, 370); ?>">
        <div class="date"><?php echo Helpers_DateTime::getDateFormatRus($data->values['created_at']); ?></div>
    </div>
    <div class="box-info">
        <p class="name"><?php echo $data->values['name']; ?></p>
        <div class="line-green"></div>
        <p class="text box-text-article"><?php echo Arr::path($data->values['options'], 'info', ''); ?></p>
        <a class="a-green" href="<?php echo $siteData->urlBasic; ?>/article?id=<?php echo $data->values['id']; ?>">Читать полностью</a>
    </div>
</div>