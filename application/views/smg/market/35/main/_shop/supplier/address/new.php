<?php $siteData->titleTop = 'Адрес поставщика (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopsupplieraddress/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/supplier/address/one/new']); ?>
</form>
