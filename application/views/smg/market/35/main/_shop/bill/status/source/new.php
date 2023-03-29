<?php $siteData->titleTop = 'Статус заказов источников (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbillstatussource/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bill/status/source/one/new']); ?>
</form>
