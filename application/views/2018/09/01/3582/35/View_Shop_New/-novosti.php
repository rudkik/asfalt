<div class="col-md-4 col-12">
    <div class="main__page__news__wrap">
        <figure class="main__page__news__preview_img">
            <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 304, 219); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        </figure>
        <div class="main__page__news__block">
            <h5 class="main__page__news__block__date"><?php echo $data->values['created_at']; ?></h5>
            <h4 class="main__page__news__block__title"><?php echo $data->values['name']; ?></h4>
            <p class="main__page__news__block__description"><?php echo Arr::path($data->values['options'], 'info', ''); ?></p>
            <span class="btn btn--alt-p main__page__news__block__more_info">
                <a href="<?php echo $siteData->urlBasic; ?>/article?id=<?php echo $data->values['id']; ?>">
                    Подробнее
                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/page/more_info.png" alt="Подробнее">
                </a>
            </span>
        </div>
    </div>
</div>