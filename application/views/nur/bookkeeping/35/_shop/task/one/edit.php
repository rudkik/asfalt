<div class="form-group">
    <label class="span-checkbox">
        <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
        Активная задача
    </label>
</div>
<div class="form-group">
    <label for="name" class="block">Название</label>
    <input id="name" name="name" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>" required>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="date_from" class="block">Срок действия от</label>
            <input name="date_from" id="date_from" type="datetime" data-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from']); ?>">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="date_to" class="block">Срок действия до</label>
            <input name="date_to" id="date_to" type="datetime" data-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_to']); ?>">
        </div>
    </div>
</div>
<div class="text-center" style="width: 100%;">
    <?php if($siteData->action != 'clone') { ?>
        <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>" style="display: none">
    <?php } ?>
    <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Сохранить</button>
    <a href="/nur-bookkeeping/shoptask/index" class="btn btn-danger">Отменить</a>
</div>