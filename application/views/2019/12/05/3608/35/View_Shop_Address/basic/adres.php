<div class="phone">
    <div class="media-left">
        <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/address.png">
    </div>
    <div class="media-body">
        <span class="name"><?php echo Helpers_Address::getAddressStr($siteData, $data->values, ', ', TRUE, FALSE); ?></span>
    </div>
</div>