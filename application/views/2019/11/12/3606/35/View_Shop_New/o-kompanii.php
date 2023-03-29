<div class="col-xs-6 box-about-img">
    <img class="width-100" src="<?php echo Helpers_Image::getPhotoPath(Helpers_Image::getPhotoPathByImageType($data->values['files'], 'left'), 660, 399); ?>">
</div>
<div class="col-xs-6 box-about-img">
    <img class="width-100" src="<?php echo Helpers_Image::getPhotoPath(Helpers_Image::getPhotoPathByImageType($data->values['files'], 'right'), 660, 399); ?>">
</div>
<div class="col-xs-12">
    <div class="box_text text-center margin-t-10">
        <?php echo Arr::path($data->values['options'], 'info', ''); ?>
    </div>
</div>