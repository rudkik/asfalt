<div class="col-md-3 box-car">
    <a href="<?php echo $siteData->urlBasicLanguage; ?>/trucks<?php echo $data->values['name_url']; ?>">
        <div class="box-car-img">
            <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 295, 196); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
            <div class="box-select-yellow"></div>
        </div>
    </a>
    <a class="url" href="<?php echo $siteData->urlBasicLanguage; ?>/trucks<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name_total']; ?></a>
</div>