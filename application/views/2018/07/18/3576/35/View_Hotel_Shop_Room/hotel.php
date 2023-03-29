<div class="box-room">
    <div class="room standard<?php if($data->additionDatas['is_free'] != 1){echo ' busy';} ?>">
        <p class="number"><?php echo $data->values['name']; ?></p>
        <div class="price"><?php echo Func::getPriceStr($siteData->currency, $data->values['price']); ?></div><img class="pull-right" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/room/<?php echo $data->values['human']; ?>.png">
        <input data-id="shop_rooms" name="shop_rooms[]" value="<?php echo $data->id; ?>" style="display: none" type="checkbox">
        <div class="bedroom">
            <?php if($data->values['two_bedroom'] > 0){ ?>
                <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/two-bedroom/<?php echo $data->values['two_bedroom']; ?>.png">
            <?php } ?>
            <?php if($data->values['bedroom'] > 0){ ?>
                <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/bedroom/<?php echo $data->values['bedroom']; ?>.png">
            <?php } ?>
            <?php if($data->values['sofa'] > 0){ ?>
                <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/sofa/<?php echo $data->values['sofa']; ?>.png">
            <?php } ?>
        </div>
    </div>
</div>