<div class="box-phone">
    <div class="media-left">
        <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone-w.png">
    </div>
    <div class="media-body">
		<?php echo str_replace('<a ', '<a class="phone" ', Func::getContactHTMLRus($data->values, false, true));?>
    </div>
</div>