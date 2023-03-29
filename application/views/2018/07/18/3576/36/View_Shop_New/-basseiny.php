<div class="col-sm-6 pool">
    <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 675, 432); ?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    <div class="title">
        <p><?php echo $data->values['name']; ?></p>
        <div class="row box-list-size">
            <div class="col-sm-4 box-size">
                <?php echo Arr::path($data->values['options'], 'width', 0); ?> м х <?php echo Arr::path($data->values['options'], 'length', 0); ?> м
            </div>
            <div class="col-sm-4 box-c">
                <?php echo Arr::path($data->values['options'], 'temperature', 0); ?> C
            </div>
            <div class="col-sm-4 box-height">
                <?php echo Arr::path($data->values['options'], 'height', 0); ?> см
            </div>
        </div>
    </div>
</div>