<?php $siteData->titleTop = 'Адрес доставок (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbilldeliveryaddress/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bill/delivery/address/one/edit']); ?>
</form>
