<div class="col-md-6">
    <div class="box-comment">
        <div class="row">
            <div class="col-md-3">
                <img class="img-comment" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 220, 146); ?>">
            </div>
            <div class="col-md-9">
                <p class="name"><?php echo $data->values['name']; ?></p>
                <div class="comment comment-size"><?php echo Func::trimTextNew($data->values['text'], 342); ?></div>
                <a href="<?php echo $siteData->urlBasic;?>/comment?id=<?php echo $data->values['id']; ?>">Полностью <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/arrow.png"></a>
            </div>
        </div>
    </div>
</div>