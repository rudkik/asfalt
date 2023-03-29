<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="tz-introduce-content tz-introduce-content-style-2 theme-white">
        <div class="tz-introduce-images">
            <img src="<?php echo Func::getPhotoPath($data->values['file_logotype'], 570, 570); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" style="width: 100%">
        </div>
        <h3><a href="<?php echo $siteData->urlBasic; ?>/event?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a></h3>
        <p><?php echo Func::trimTextNew($data->values['info'], 210);?></p>
        <a href="<?php echo $siteData->urlBasic; ?>/event?id=<?php echo $data->values['id']; ?>">
            <span>Узнать больше</span>
        </a>
    </div>
</div>