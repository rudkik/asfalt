<div class="col-md-4 goods">
    <div class="box-good">
        <div class="box-img">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/trucks<?php echo $data->values['name_url']; ?>">
				<img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 496, 330); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
			</a>
            <?php if($data->values['shop_table_param_1_id'] > 0){?>
            <div class="tag">
                <?php echo $data->getElementValue('shop_table_param_1_id', 'name'); ?>
                <div class="corner-yellow-right"></div>
            </div>
            <?php } ?>
        </div>
        <h3><a href="<?php echo $siteData->urlBasicLanguage; ?>/trucks<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name_total']; ?></a></h3>
        <h4><a href="<?php echo $siteData->urlBasicLanguage; ?>/trucks<?php echo $data->getElementValue('shop_table_rubric_id', 'name_url'); ?>"><?php echo $data->getElementValue('shop_table_rubric_id', 'name'); ?></a></h4>
        <p class="year"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/year.png"> <a href="<?php echo $siteData->urlBasicLanguage;?>/trucks?year=<?php echo $data->values['param_1_int']; ?>"><?php echo $data->values['param_1_int']; ?> год</a></p>
        <p class="year"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/hour.png"><?php echo $data->values['param_3_int']; ?> ч</a></p>
        <p class="land"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/land.png"><a href="<?php echo $siteData->urlBasicLanguage;?>/trucks?land=<?php echo $data->values['location_land_id']; ?>"><?php echo $data->getElementValue('location_land_id', 'name'); ?></a></p>
        <div class="price"><?php
            $price = Func::getCarPriceStr($siteData->currency, $data, $price, $priceOld, FALSE);
            if ($price > 0){
                echo Func::getCarPriceStr($siteData->currency, $data, $price, $priceOld);
            }else{
                echo 'по запросу';
            }
            ?></div>
    </div>
</div>