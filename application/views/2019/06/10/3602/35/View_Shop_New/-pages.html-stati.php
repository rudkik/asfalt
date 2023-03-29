<div class="row box-article">
    <div class="col-md-4">
        <div class="wrap-col">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/pages<?php echo $data->values['name_url']; ?>">
                <img class="box-img" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 430, 215); ?>" border="0" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>"/>
            </a>
        </div>
    </div>
    <div class="col-md-8">
        <div class="box-info">
            <h2><a href="<?php echo $siteData->urlBasicLanguage; ?>/pages<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a></h2>
            <p class="info"><?php echo Func::trimTextNew($data->values['text'], 522); ?></p>
        </div>
    </div>
</div>