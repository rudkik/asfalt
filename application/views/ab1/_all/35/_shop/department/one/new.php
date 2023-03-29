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
            Полное название
        </label>
    </div>
    <div class="col-md-9">
        <input name="name_full" type="text" class="form-control" placeholder="Полное название" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Родитель
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_department_id" name="shop_department_id" class="form-control select2" style="width: 100%">
            <option value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/department/list/list'];?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Интерфейс для редактирования договоров
        </label>
    </div>
    <div class="col-md-9">
        <select multiple id="contract_interface_ids[]" name="contract_interface_ids[]" class="form-control select2" style="width: 100%">
            <option value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::interface/list/list'];?>
        </select>
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

