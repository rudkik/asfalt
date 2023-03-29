<div class="col-md-6">
    <div class="row box-blog">
        <div class="col-md-6 box-img-date">
            <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 337, 343); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
            <div class="date"><?php echo Helpers_DateTime::getDateFormatRus($data->values['created_at']); ?></div>
        </div>
        <div class="col-md-6 box-text">
            <p class="name"><?php echo $data->values['name']; ?></p>
            <div class="line-green"></div>
            <p class="text"><?php echo Arr::path($data->values['options'], 'info', ''); ?></p>
            <a class="a-green" href="<?php echo $siteData->urlBasic; ?>/article?id=<?php echo $data->values['id']; ?>">Читать полностью</a>
        </div>
    </div>
</div>