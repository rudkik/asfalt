<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none;">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Показать
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Код 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="text" class="form-control" placeholder="Код 1С">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Сортировка
        </label>
    </div>
    <div class="col-md-3">
        <input name="order" type="text" class="form-control" placeholder="Сортировка">
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
            Заполнение по вычисляемому параметру
        </label>
    </div>
    <div class="col-md-9">
        <select id="indicator_type_id" name="indicator_type_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::indicator/type/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Единица измерения
        </label>
    </div>
    <div class="col-md-3">
        <input name="unit" type="text" class="form-control" placeholder="Единица измерения">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_driver" value="0" style="display: none;">
            <input name="is_driver" value="0" type="checkbox" class="minimal">
            Является параметром выработки водителей
        </label>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Буквенный код
        </label>
    </div>
    <div class="col-md-3">
        <input name="short_name" type="text" class="form-control" placeholder="Буквенный код">
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
