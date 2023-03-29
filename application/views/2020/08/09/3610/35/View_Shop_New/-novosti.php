<div class="col-md-3 box-col">
    <div class="box-news">
        <div class="img-news" >
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/news<?php echo $data->values['name_url']; ?>"><img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 415, 242); ?>"></a>
            <div class="date"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/calendar-w.png"> <?php echo Helpers_DateTime::getDateFormatRus($data->values['created_at']); ?></div>
        </div>
        <div class="box-news-body">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/news<?php echo $data->values['name_url']; ?>" class="title"><?php echo $data->values['name']; ?></a>
            <p class="subtitle"><?php echo Arr::path($data->values['options'], 'subtitle', ''); ?></p>
        </div>
        <a href="<?php echo $siteData->urlBasicLanguage; ?>/news<?php echo $data->values['name_url']; ?>" class="btn btn-flat btn-black-red btn-border-none width-100">Подробнее</a>
    </div>
</div>