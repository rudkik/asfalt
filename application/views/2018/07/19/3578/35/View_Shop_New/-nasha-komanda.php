<div class="col-md-2-5">
    <div class="box-img">
        <a href="<?php echo $siteData->urlBasic;?>/team?id=<?php echo $data->id; ?>"><img class="img-circle" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 118, 118); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>"></a>
    </div>
    <p class="name"><a href="<?php echo $siteData->urlBasic;?>/team?id=<?php echo $data->id; ?>"><?php echo $data->values['name']; ?></a></p>
    <div class="info"><?php echo Arr::path($data->values['options'], 'info', ''); ?></div>
</div>