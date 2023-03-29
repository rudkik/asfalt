<?php $siteData->titleTop = 'Выплата от источников (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shoppaymentsource/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/payment/source/one/edit']); ?>
</form>
