<?php $siteData->titleTop = 'Закуп товаров курьером (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shoppreorder/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/pre-order/one/edit']); ?>
</form>
