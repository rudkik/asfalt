<div class="contentInside__text col-md-6 col-12">
    <h1><?php echo $data->values['name']; ?></h1>
    <div class="mainText"><?php echo $data->values['text']; ?></div>
</div>
<div class="contentInside__picture col-md-6 col-12">
    <div class="picture__holder">
        <img class="bigImage" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 700, null); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </div>
</div>