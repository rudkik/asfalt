<div class="row top20" id="edit_panel">
    <input name="shop_id" type="text" hidden="hidden" value="<?php echo $siteData->shopID;?>">
    <div class="col-md-12">
        <div class="form-group">
            <input type="checkbox" class="flat-red"<?php if($data->values['is_public'] == 1){ echo 'checked';} ?>> Опубликовать
        </div>

        <div class="form-group">
            <label>Название</label>
            <input name="name" type="text" class="form-control" placeholder="Название"
                   value="<?php echo $data->values['name']; ?>">
        </div>
    </div>

    <div class="col-md-12">
        <?php
        $view = View::factory('cabinet/35/shopinformationdatacatalog/options');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<div class="row top20">
    <div class="col-md-3">
        <input name="data_language_id" type="text" hidden="hidden" value="<?php echo $siteData->dataLanguageID; ?>">
        <input name="shop_id" type="text" hidden="hidden" value="<?php echo $siteData->shopID;?>">
        <input type="submit" value="Сохранить" class="btn btn-primary btn-block"
               onclick="actionSaveObject('<?php echo $siteData->urlBasic . '/cabinet/shopinformationdatacatalog/save'; ?>?', <?php echo $data->id; ?>, 'edit_panel', true)">
    </div>
</div>