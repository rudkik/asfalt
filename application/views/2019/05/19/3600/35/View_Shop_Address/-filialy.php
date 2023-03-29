<h4><?php echo $data->values['name']; ?></h4>
<div class="contact">
    <div class="media-left">
        <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/map.png">
    </div>
    <div class="media-body">
        <span>Адрес</span>
        <label><?php echo Helpers_Address::getAddressStr($siteData, $data->values, 'разделитель', TRUE, FALSE); ?></label>
    </div>
</div>
<div class="row">
    <?php echo $data->additionDatas['view::View_Shop_Addresss\group\-filialy']; ?>
</div>