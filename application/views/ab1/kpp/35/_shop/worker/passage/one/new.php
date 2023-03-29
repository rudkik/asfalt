<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none;">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Показать
        </label>
    </div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_car" value="0" type="checkbox" class="minimal">
            Въезд на машине
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_exit" value="1" checked type="checkbox" class="minimal">
            Выход из территории
        </label>
    </div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_inside_move" value="0" type="checkbox" class="minimal">
            Внутреннее перемещение
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
            Серийный номер
        </label>
    </div>
    <div class="col-md-3">
        <input name="old_id" type="text" class="form-control" placeholder="Серийный номер устройства">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Ключ аутентификации
        </label>
    </div>
    <div class="col-md-3">
        <input name="controller_number" type="text" class="form-control" placeholder="Ключ аутентификации">
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>