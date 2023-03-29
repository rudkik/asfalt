<?php $siteData->titleTop = 'Склад (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopproductstorage/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/product/storage/one/new']); ?>
</form>
