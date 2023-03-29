<?php $siteData->titleTop = 'Статус звонков (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbillcallstatus/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bill/call/status/one/edit']); ?>
</form>
