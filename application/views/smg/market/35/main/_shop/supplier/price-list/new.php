<?php $siteData->titleTop = 'Прайс лист (добавление)'; ?>
<form class="form-horizontal" enctype="multipart/form-data" action="<?php echo Func::getFullURL($siteData, '/shopsupplierpricelist/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/supplier/price-list/one/new']); ?>
</form>