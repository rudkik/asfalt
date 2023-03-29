<?php $siteData->titleTop = 'Аккаунт (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopaccount/save'); ?>"  enctype="multipart/form-data" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/account/one/new']); ?>
</form>
