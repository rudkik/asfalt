<div class="tab-pane active">
    <h3>
        Клиент <b><?php echo $data->values['name']; ?></b> БИН/ИИН <b><?php echo $data->values['bin']; ?></b>
        оплата
        <b>
            <?php if(Request_RequestParams::getParamBoolean('is_cash')){ ?>
                наличными
            <?php }else{ ?>
                безналичными
            <?php } ?>
        </b>
    </h3>
</div>
<div class="nav-tabs-custom" style="margin-bottom: 0px;">
    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
        <li class="<?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopcaritem/index')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/index', array(), array(), array(), true);?>">Машины</a></li>
        <li class="<?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopinvoice/money_type')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/money_type', array(), array(), array(), true);?>">Накладные</a></li>
    </ul>
</div>

