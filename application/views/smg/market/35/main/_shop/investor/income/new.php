<?php $siteData->titleTop = 'Доход инвестора (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopinvestorincome/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/investor/income/one/new']); ?>
</form>
