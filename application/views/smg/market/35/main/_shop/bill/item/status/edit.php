<?php $siteData->titleTop = 'Статус товаров заказов (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbillitemstatus/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bill/item/status/one/edit']); ?>
</form>
