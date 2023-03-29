<?php if (count($data['view::View_Shop_AddressContact\basic\faks-snizu']->childs) > 0){ ?>
    <p class="address-title">
        <img class="place" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/fax-w.png"> Факс
    </p>
    <ul class="box-menu">
        <?php
        foreach ($data['view::View_Shop_AddressContact\basic\faks-snizu']->childs as $value){
            echo $value->str;
        }
        ?>
    </ul>
<?php } ?>