<div class="row">
    <div class="col-md-9">
        <div class="row record-input record-tab">
            <div class="col-md-3 record-title"></div>
            <div class="col-md-5" style="max-width: 250px;">
                <span class="span-checkbox">
                    <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                    Показать статичный блок
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <span>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Название
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>
            </div>
            <div class="col-md-9">
                <input name="name" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars($data->values['name']);?>">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <span>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Тип
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>
            </div>
            <div class="col-md-9">
                <select name="shop_information_data_catalog_id" class="form-control select2" style="width: 100%;">
                    <option value="0" data-id="0"></option>
                    <?php echo trim($siteData->globalDatas['view::shopinformationdatacatalogs/list']); ?>
                </select>
            </div>
        </div>
        <?php
        $view = View::factory('cabinet/35/_addition/options-fields');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->className = 'record-list';
        $view->fields = Arr::path($data->values, '$elements$.shop_new_catalog_id.options', array());
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Описание
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="col-md-9 record-textarea">
                <textarea name="text" placeholder="Описание..." rows="11" class="form-control"><?php echo $data->values['text'];?></textarea>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <?php
        $view = View::factory('smmarket/sadmin/35/_addition/files');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->columnSize = 12;
        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<script>
    CKEDITOR.replace('text');
</script>