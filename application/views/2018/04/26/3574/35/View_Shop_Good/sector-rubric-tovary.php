<div class="col-md-4 goods">
    <div class="block-goods">
        <a href="<?php echo $siteData->urlBasic; ?>/sector-goods?id=<?php echo $data->values['id']; ?>&sector=<?php echo $data->values['shop_id']; ?>">
            <img class="img-goods img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 320, 250); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        </a>
        <div class="goods-info">
            <h3>
                <a href="<?php echo $siteData->urlBasic; ?>/sector-goods?id=<?php echo $data->values['id']; ?>&sector=<?php echo $data->values['shop_id']; ?>"><?php echo $data->values['name']; ?></a>
            </h3>
        </div>
    </div>
</div>