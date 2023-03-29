<?php $siteData->titleTop = 'Выплата от источников (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shoppaymentsource/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/payment/source/one/new']); ?>
</form>
