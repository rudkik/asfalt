<div class="col-12 col-sm-auto col-lg-12 margin-auto">
    <div class="news__block">
        <figure class="news__block__img">
            <img class="news__block__img__img loaded" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 228, 164); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
            <div class="loading__wrap">
                <div class="loading">
                    <div class="loading__dotes">
                        <div class="loading__dote">
                        </div>
                        <div class="loading__dote">
                        </div>
                        <div class="loading__dote">
                        </div>
                    </div>
                </div>
            </div>
        </figure>
        <div class="news__block__date"><?php echo $data->values['created_at']; ?></div>
        <div class="news__block__title"><?php echo $data->values['name']; ?></div>
        <div class="news__block__desc"><?php echo Arr::path($data->values['options'], 'info', ''); ?></div>
        <button class="btn news__block__more_info">
            <a href="<?php echo $siteData->urlBasic; ?>/article?id=<?php echo $data->values['id']; ?>">
                Подробнее
                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/page/more_info.png" alt="Подробнее">
            </a>
        </button>
    </div>
</div>