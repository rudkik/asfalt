<?php if (count($data['view::View_Shop_AddressContact\basic\e-mail-snizu']->childs) > 0){ ?>
    <p class="address-title">
        <img class="place" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/email-w.png"> E-mail
    </p>
    <ul class="box-menu">
        <?php
        foreach ($data['view::View_Shop_AddressContact\basic\e-mail-snizu']->childs as $value){
            echo $value->str;
        }
        ?>
    </ul>
<?php } ?>