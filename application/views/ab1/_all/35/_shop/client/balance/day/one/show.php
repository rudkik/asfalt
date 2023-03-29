<div class="tab-pane active">
    <h3>
        Фиксация прайс-листа на <b><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']);?></b>
        сумма: <b><?php echo Func::getNumberStr($data->values['amount'], true, 2, false);?></b>
        тг
    </h3>
</div>
<div class="nav-tabs-custom" style="margin-bottom: 0px;">
    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
        <li class="<?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopcaritem/index')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/index', array(), array(), array(), true);?>">Машины</a></li>
        <li class="<?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopcaritem/balance_day')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/balance_day', array(), array(), array(), true);?>">Накладные</a></li>
    </ul>
</div>