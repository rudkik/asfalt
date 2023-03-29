<?php $siteData->titleTop = 'Расход (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopexpense/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/expense/one/new']); ?>
</form>
