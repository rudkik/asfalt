<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none;">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; } ?> type="checkbox" class="minimal">
            Показать
        </label>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        ИИН
    </label>
    <div class="col-md-4">
        <input name="iin" type="text" class="form-control" placeholder="ИИН" maxlength="12" value="<?php echo htmlspecialchars($data->values['iin'], ENT_QUOTES); ?>" required>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        ФИО
    </label>
    <div class="col-md-10">
        <input name="name" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
    </div>
</div>
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
