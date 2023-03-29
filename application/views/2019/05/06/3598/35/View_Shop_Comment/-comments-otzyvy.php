<div class="box-comment">
    <div class="row">
        <div class="col-md-2">
            <img class="img-comment" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 220, 146); ?>">
        </div>
        <div class="col-md-10">
            <p class="name"><?php echo $data->values['name']; ?></p>
            <div class="comment"><?php echo $data->values['text']; ?></div>
        </div>
    </div>
</div>