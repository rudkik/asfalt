<div class="col-md-6">
    <div class="contact">
        <div class="media-left">
            <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone.png">
        </div>
        <div class="media-body">
            <span>Наш телефон</span>
            <?php echo Func::getContactHTMLRus($data->values, false, true);?>
        </div>
    </div>
</div>
