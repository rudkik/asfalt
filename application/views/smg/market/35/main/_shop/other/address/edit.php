<?php $siteData->titleTop = 'Другие адресса (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopotheraddress/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/other/address/one/edit']); ?>
</form>
