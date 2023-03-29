<?php
$view = View::factory('cabinet/35/shop/_menu');
$view->siteData = $siteData;
$view->data = $data;
$view->isShowMenuAll = TRUE;
echo Helpers_View::viewToStr($view);
?>
<div class="row top20">
    <input name="id" type="text" hidden="hidden" value="<?php echo $siteData->shopID;?>">
    <input name="url" type="text" hidden="hidden" value="<?php echo $siteData->urlBasic.$siteData->url;?>?is_main=1">

    <div class="col-md-2">
        <input type="submit" value="Сохранить" class="btn btn-primary btn-block" onclick="actionSaveObject('<?php echo $siteData->urlBasic . '/cabinet/shop/save' ?>?', <?php echo $data->id; ?>,'edit_panel', 'table_panel', false)">
    </div>
</div>
