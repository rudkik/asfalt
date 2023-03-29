<?php $siteData->titleTop = 'Статус возврата (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbillreturnstatus/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bill/return/status/one/new']); ?>
</form>
