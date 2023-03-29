<?php $siteData->titleTop = 'Источник заказов (добавление)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbillsource/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bill/source/one/new']); ?>
</form>
