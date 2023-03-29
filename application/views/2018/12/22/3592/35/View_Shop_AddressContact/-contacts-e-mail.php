<div class="col-sm-4">
    <div class="box-contact">
        <img class="box-img" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/email-y.png">
        <p class="contact"><?php echo Func::getContactHTMLRus($data->values, false, true);?></p>
        <p class="title"><?php echo $data->values['text']; ?></p>
    </div>
</div>