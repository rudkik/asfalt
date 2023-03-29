<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="tz-event-speaker">
        <div class="tz-speaker-images">
            <img src="<?php echo Func::getPhotoPath($data->values['image_path'], 203, 266); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" class="center-image">
        </div>
        <div class="tz-speaker-content">
            <strong><?php echo $data->values['name'];?></strong>
            <small><?php echo Arr::path($data->values['options'], 'city', '');?></small>
        </div>
    </div>
</div>