<header class="header-about">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="line-green"></div>
				<h2>Об <span>авторе</span></h2>
				<h4><?php echo Arr::path($data->values['options'], 'name', ''); ?></h4>
				<div class="info">
					<?php echo Arr::path($data->values['options'], 'info', ''); ?>
				</div>
                <a href="<?php echo $siteData->urlBasic;?>/about">Подробнее <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/arrow.png"></a>
            </div>
            <div class="col-md-4">
                <img class="img-box" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 422, 532); ?>">
            </div>
        </div>
    </div>
</header>