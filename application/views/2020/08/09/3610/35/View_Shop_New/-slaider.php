<div class="item">
    <div class="slider">
        <div class="slider-body">
            <div class="container">
                <div class="box-info">
                    <h2><?php echo $data->values['name']; ?></h2>
                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line-slider.png">
                    <div class="text">
                        <?php echo Arr::path($data->values['options'], 'subtitle', ''); ?>
                    </div>
                    <a href="<?php echo Arr::path($data->values['options'], 'url', ''); ?>" class="btn btn-info btn-flat btn-black-red" type="submit">Подробнее</a>
                </div>
            </div>
        </div>
    </div>
</div>