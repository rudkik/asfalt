<?php $siteData->titleTop = 'Выплаченная коммисия источнику (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopcommissionsource/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/commission/source/one/new']); ?>
</form>
