<div class="item">
	<div class="row">
        <div class="col-md-2 text-center">
            <div class="box-img">
                <img class="img-circle" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 118, 118); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
            </div>
            <p class="name"><?php echo $data->values['name']; ?></p>
        </div>
        <div class="col-md-10">
            <img class="quote-left" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/quotes-l.png">
            <div class="text"><?php echo $data->values['text']; ?></div>
            <img class="quote-right" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/quotes-r.png">
        </div>
    </div>
</div>
	