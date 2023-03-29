<div class="col-sm-6 pool">
    <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 675, 432); ?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    <div class="title">
        <div class="row box-list-size">
            <div class="col-sm-3 box-price">
                <?php echo Arr::path($data->values['options'], 'price', ''); ?>
            </div>
            <div class="col-sm-9 box-name" style="border-right: none;">
                <?php echo $data->values['name']; ?>
            </div>
        </div>
    </div>
</div>