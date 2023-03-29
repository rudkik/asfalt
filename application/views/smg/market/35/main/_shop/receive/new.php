<?php $siteData->titleTop = 'Закуп товаров (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopreceive/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/receive/one/new']); ?>
</form>
