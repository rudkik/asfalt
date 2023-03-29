<?php $siteData->titleTop = 'Способ доставки (добавление)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbilldeliverytype/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bill/delivery/type/one/new']); ?>
</form>
