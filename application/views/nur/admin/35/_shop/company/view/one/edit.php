<div class="form-group">
    <label class="span-checkbox">
        <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
        Показывать
    </label>
</div>
<div class="form-group">
    <label for="name" class="block">Название</label>
    <input id="name" name="name" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>" required>
</div>
<div class="text-center" style="width: 100%;">
    <?php if($siteData->action != 'clone') { ?>
        <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>" style="display: none">
    <?php } ?>
    <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Сохранить</button>
    <a href="/nur-admin/shopcompanyview/index" class="btn btn-danger">Отменить</a>
</div>