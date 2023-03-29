<?php $siteData->titleTop = 'Стадия обработки заказа источниками  (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbillstatesource/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bill/state/source/one/edit']); ?>
</form>
