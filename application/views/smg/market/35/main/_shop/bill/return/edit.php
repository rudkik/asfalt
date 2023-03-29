<?php $siteData->titleTop = 'Заказ для возврата (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbillreturn/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bill/return/one/edit']); ?>
</form>
