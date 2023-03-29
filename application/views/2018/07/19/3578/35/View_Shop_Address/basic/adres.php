<div class="address">
    <div class="media-left">
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/point.png">
    </div>
    <div class="media-body">
        <p>Мы находимся:</p>
        <a href="<?php echo $siteData->urlBasic; ?>/contacts"><?php echo $data->values['street']. ', '.$data->values['house']; ?></a>
    </div>
</div>