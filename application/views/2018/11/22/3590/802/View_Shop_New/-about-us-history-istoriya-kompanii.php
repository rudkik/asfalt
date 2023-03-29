<div class="col-md-12 box-history">
    <div class="row">
        <div class="col-md-3">
            <img class="box" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>"
                 src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 395, NULL); ?>"
                 alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" />
        </div>
        <div class="col-md-9">
            <h2><?php echo $data->values['name']; ?></h2>
            <div class="line-red"></div>
            <?php echo $data->values['text']; ?>
        </div>
    </div>
</div>