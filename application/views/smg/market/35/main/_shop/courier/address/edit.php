<?php $siteData->titleTop = 'Адрес курьера (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopcourieraddress/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/courier/address/one/edit']); ?>
</form>
