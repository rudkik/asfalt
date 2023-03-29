<?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title"></div>
        <div class="col-md-9">
            <label class="span-checkbox">
                <input name="is_public" value="0" style="display: none;">
                <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal"<?php if($isShow){ ?>disabled<?php } ?>>
                Показать
            </label>
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Название
            </label>
        </div>
        <div class="col-md-9">
            <input name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Кол-во тонн в метре
            </label>
        </div>
        <div class="col-md-3">
            <input data-type="money" data-fractional-length="3" name="ton_in_meter" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars($data->values['ton_in_meter'], ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
        </div>
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Размер в метрах
            </label>
        </div>
        <div class="col-md-3">
            <input data-type="money" data-fractional-length="3" name="size_meter" type="text" class="form-control" placeholder="Размер в метрах" required value="<?php echo htmlspecialchars($data->values['size_meter'], ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
        </div>
    </div>
<?php if(!$isShow){ ?>
    <div class="row">
        <div hidden>
            <?php if($siteData->action != 'clone') { ?>
                <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
            <?php } ?>
            <input id="is_close" name="is_close" value="1" style="display: none">
        </div>
        <div class="modal-footer text-center">
            <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
            <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
        </div>
    </div>

<script>
    function submitSave(id) {
        var isError = false;

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>
<?php } ?>