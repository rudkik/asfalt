<?php
Helpers_SEO::setSEOHeader(Model_Shop_New::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<div class="row">
    <div class="col-12 col-md-4">
        <div id="about_switch" class="about__switch">
			<?php echo trim($siteData->globalDatas['view::View_Shop_News\about-rubrikatciya']); ?>
        </div>
    </div>
    <div class="col-12 col-md-8">
        <div class="about__title" data-company="<?php echo $data->values['id']; ?>">
            <?php echo $data->values['name']; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-8 offset-lg-4">
        <div class="about__body" data-company="1">
            <div class="row justify-content-between about__body__block__wrap">
                <div class="col-12 col-md-6">
                    <div class="about__body__block">
                        <a target="_blank" href="<?php echo Arr::path($data->values['options'], 'url', ''); ?>"><img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 329, 214); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>"></a>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="about__body__block">
                        <?php echo Arr::path($data->values['options'], 'info', ''); ?>
                    </div>
                </div>
            </div>
            <div class="about__body__text">
                <?php echo $data->values['text']; ?>
            </div>
        </div>
    </div>
</div>