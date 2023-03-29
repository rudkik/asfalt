<div class="element tz-item-portfolio">
    <div class="tz-image-portfolio">
        <img src="<?php echo Func::getPhotoPath(Func::getOptimalSizePhotoPath($data->values['files'], 384, 384, $data->values['file_logotype']), 384, 384); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </div>
    <div class="tz-portfolio-content-style-2">
        <h4 class="tac"><a class="link-white mt20" href="<?php echo $siteData->urlBasic; ?>/event?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a></h4>
    </div>
</div>
