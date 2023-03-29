<div class="box-email">
    <div class="media-left">
        <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/email-w.png">
    </div>
    <div class="media-body">
		<?php echo str_replace('<a ', '<a class="email"', Func::getContactHTMLRus($data->values, false, true));?>
    </div>
</div>