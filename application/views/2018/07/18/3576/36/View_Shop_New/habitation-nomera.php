<div class="row margin-t-40">
    <div class="col-sm-6 pool">
        <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 675, 432); ?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        <div class="title">
            <div class="row box-list-size">
                <div class="col-sm-3 box-price">
                    <?php echo Arr::path($data->values['options'], 'price', ''); ?>
                </div>
                <div class="col-sm-6 box-name">
                    <?php echo Arr::path($data->values['options'], 'name', ''); ?>
                </div>
                <div class="col-sm-3 box-url">
                    <a href="<?php echo $siteData->urlBasicLanguage; ?>/room?id=<?php echo $data->values['id']; ?>">More information</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <p class="name"><?php echo $data->values['name']; ?></p>
        <div class="info"><?php echo Arr::path($data->values['options'], 'info', ''); ?></div>
    </div>
</div>