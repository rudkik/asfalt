<?php $siteData->titleTop = 'Аккаунт (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopaccount/save'); ?>" method="post" enctype="multipart/form-data" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/account/one/edit']); ?>
</form>
