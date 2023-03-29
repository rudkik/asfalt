<?php $siteData->titleTop = 'Статус заказов (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbillstatus/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bill/status/one/edit']); ?>
</form>
