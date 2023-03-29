<?php $siteData->titleTop = 'Звонок по заказу (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbillcall/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bill/call/one/edit']); ?>
</form>
