<div class="col-sm-4" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
    <div class="box-contact">
        <img class="box-img" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/location-y.png">
        <p class="contact" itemprop="streetAddress"><?php echo Helpers_Address::getAddressStr($siteData, $data->values, ', ', TRUE); ?></p>
        <p class="title">наш адрес</p>
    </div>
</div>