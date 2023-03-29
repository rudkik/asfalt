<h2><?php echo $data->values['name']; ?></h2>
<div class="row box-img">
    <div class="col-lg-7">
        <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath(Helpers_Image::getPhotoPathByImageType($data->values['files'], 'image_1'), 728, 358); ?>">
    </div>
    <div class="col-lg-5">
        <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath(Helpers_Image::getPhotoPathByImageType($data->values['files'], 'image_2'), 511, 358); ?>">
    </div>
</div>
<div class="box_text">
    <?php echo $data->values['text']; ?>
</div>