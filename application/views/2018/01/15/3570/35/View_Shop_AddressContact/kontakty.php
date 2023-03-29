<div class="phone">
    <div class="media-left">
        <?php if(($data->values['contact_type_id'] == 13) || ($data->values['contact_type_id'] == 14)){ ?>
		<img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/contact/phone.png">
        <?php } ?>
    </div>
    <div class="media-body">
        <?php echo Func::getContactHTMLRus($data->values, false, true);?>
    </div>
</div>