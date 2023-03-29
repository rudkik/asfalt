<p class="address-title">
    <img class="place" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/place-w.png"> Адрес
</p>
<p><?php echo Helpers_Address::getAddressStr($siteData, $data->values, ', ', TRUE, TRUE); ?></p>