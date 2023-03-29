<div class="phone">
    <div class="media-left">
        <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone.png">
    </div>
    <div class="media-body">
        <?php echo str_replace('<a ', '<a class="name" ', Func::getContactHTMLRus($data->values, false, true));?>
    </div>
</div>