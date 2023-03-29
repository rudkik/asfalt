<div class="item">
    <div class="slider">
        <div class="container">
            <div class="box-comment" itemscope="" itemtype="http://schema.org/UserComments">
                <img class="box-img" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 113, 113); ?>">
                <p class="name"><?php echo $data->values['name']; ?></p>
                <p class="date"><?php echo Helpers_DateTime::getDateFormatRus($data->values['created_at']); ?></p>
                <div itemtype="http://schema.org/Comment" itemscope="">
                    <div class="text" itemprop="text">
                        <?php echo $data->values['text']; ?>
                    </div>
                </div>
                <img class="img-bottom" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/quotes.png">
            </div>
        </div>
    </div>
</div>