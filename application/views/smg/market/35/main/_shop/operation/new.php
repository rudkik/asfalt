<?php $siteData->titleTop = 'Оператор (добавление)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopoperation/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/operation/one/new']); ?>
</form>
