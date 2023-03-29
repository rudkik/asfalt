<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
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
        <input name="name" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Время начала смены
        </label>
    </div>
    <div class="col-md-3">
        <input name="time_from" type="datetime" date-type="time" class="form-control" value="<?php echo Helpers_DateTime::getTimeByDate($data->values['time_from']);?>"  required>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Время окончания смены
        </label>
    </div>
    <div class="col-md-3">
        <input name="time_to" type="datetime" date-type="time" class="form-control" value="<?php echo Helpers_DateTime::getTimeByDate($data->values['time_to']);?>"  required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Количество ночных часов (для расчета заработной платы)
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="0" name="night_hours" type="phone" class="form-control" placeholder="Количество ночных часов (для расчета заработной платы)" value="<?php echo $data->values['night_hours'];?>">
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