<?php $siteData->titleTop = 'Тип расходов (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopexpensetype/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/expense/type/one/new']); ?>
</form>
