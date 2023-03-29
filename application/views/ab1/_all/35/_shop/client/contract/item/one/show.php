<div class="tab-pane active">
    <h3>
        Договор №<b><?php echo $data->getElementValue('shop_client_contract_id', 'number');?></b>
        от <b><?php echo Helpers_DateTime::getDateFormatRus($data->getElementValue('shop_client_contract_id', 'from_at'));?>
            продукция <?php echo $data->getElementValue('shop_product_id');?></b>
        <?php if($data->values['discount'] != 0){?>
            скидка: <b><?php echo Func::getNumberStr($data->values['discount'], true, 2, false);?></b>
        <?php }else{?>
            цена: <b><?php echo Func::getNumberStr($data->values['price'], true, 2, false);?></b>
        <?php }?>
        тг
    </h3>
</div>
<div class="nav-tabs-custom" style="margin-bottom: 0px;">
    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
        <li class="<?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopcaritem/index')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/index', array(), array(), array(), true);?>">Машины</a></li>
        <li class="<?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopcaritem/invoice')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/invoice', array(), array(), array(), true);?>">Накладные</a></li>
    </ul>
</div>

