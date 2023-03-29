<?php
Helpers_SEO::setSEOHeader(Model_Shop_New::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<div class="news__block" style="max-width: 100%;">
    <figure class="news__block__img">
        <img class="news__block__img__img loaded" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 428, 0); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        <div class="loading__wrap">
            <div class="loading">
                <div class="loading__dotes">
                    <div class="loading__dote"></div>
                    <div class="loading__dote"></div>
                    <div class="loading__dote"></div>
                </div>
            </div>
        </div>
    </figure>
    <div class="news__block__date">
        <?php echo $data->values['created_at']; ?>						
    </div>
    <div class="news__block__title">
        <?php echo $data->values['name']; ?>						
    </div>
    <div class="news__block__desc" style="white-space: pre-line: "><?php echo $data->values['text']; ?></div>
    <button class="btn news__block__more_info left">
        <a href="<?php echo $siteData->urlBasic; ?>/news">
            <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/page/more_info.png" alt="Новости">
            К списку новостей
        </a>
    </button>
</div>