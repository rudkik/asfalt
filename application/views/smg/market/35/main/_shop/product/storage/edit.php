<?php $siteData->titleTop = 'Склад (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopproductstorage/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/product/storage/one/edit']); ?>
</form>
