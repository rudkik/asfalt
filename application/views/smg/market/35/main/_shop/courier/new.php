<?php $siteData->titleTop = 'Курьер (добавление)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopcourier/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/courier/one/new']); ?>
</form>
