<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="tz-leader-content">
        <div class="tz-our-leader-image">
            <img src="<?php echo Func::getPhotoPath($data->values['image_path'], 270, 270); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        </div>
        <h6><?php echo $data->values['name']; ?></h6>
        <small><?php echo Arr::path($data->values['options'], 'position', ''); ?></small>
    </div>
</div>