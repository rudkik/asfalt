<section class="tz-introduce-univesity">
    <div class="tz-events-title bgwhite">
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/images/check.png" alt="Image">
        <h1><a href="<?php echo $siteData->urlBasic; ?>/about"><?php echo $data->values['name']; ?></a></h1>
        <span><a href="<?php echo $siteData->urlBasic; ?>/">Главная</a> / <?php echo $data->values['name']; ?></span>
    </div>
    <div class="tz-introduce-content">
        <div class="row">
            <div class="col-md-7">
                <h4><?php echo Arr::path($data->values['options'], 'title', ''); ?></h4>
                <div><?php echo $data->values['text']; ?></div>
            </div>
            <div class="col-md-5">
                <img src="<?php echo Func::getPhotoPath($data->values['image_path'], 634, 425); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" class="img-responsive">
            </div>
        </div>
    </div>
</section>