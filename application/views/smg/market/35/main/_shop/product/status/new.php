<?php $siteData->titleTop = 'Статус товаров (добавление)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopproductstatus/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/product/status/one/new']); ?>
</form>
