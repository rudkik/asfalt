<div class="tab-pane active">
    <h3>
        Клиент <b><?php echo $data->getElementValue('shop_client_id'); ?></b>
        доверенность №<b><?php echo $data->values['number'];?></b>
        от <b><?php echo Helpers_DateTime::getDateFormatRus($data->values['from_at']);?></b>
    </h3>
</div>
<div class="nav-tabs-custom" style="margin-bottom: 0px;">
    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
        <li class="<?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopcaritem/index')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/index', array(), array(), array(), true);?>">Машины</a></li>
        <li class="<?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopcaritem/attorney')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/attorney', array(), array(), array(), true);?>">Накладные</a></li>
    </ul>
</div>

