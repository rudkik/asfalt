<?php $siteData->titleTop = 'Причины отказа заказов (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbillcanceltype/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bill/cancel-type/one/edit']); ?>
</form>
