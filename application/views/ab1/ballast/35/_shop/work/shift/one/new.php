<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
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
        <input name="name" type="text" class="form-control" placeholder="Название" required>
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
        <input name="time_from" type="datetime" date-type="time" class="form-control"  required>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Время окончания смены
        </label>
    </div>
    <div class="col-md-3">
        <input name="time_to" type="datetime" date-type="time" class="form-control"  required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Количество ночных часов (для расчета заработной платы)
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="0" name="night_hours" type="phone" class="form-control" placeholder="Количество ночных часов (для расчета заработной платы)">
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>

