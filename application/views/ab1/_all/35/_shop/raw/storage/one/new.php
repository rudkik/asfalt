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
            Кол-во тонн в метре
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="3" name="ton_in_meter" type="text" class="form-control" placeholder="Название" required>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Размер в метрах
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" name="size_meter" type="text" class="form-control" placeholder="Размер в метрах" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Вид
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_raw_storage_type_id" name="shop_raw_storage_type_id" class="form-control select2" style="width: 100%">
            <option value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/raw/storage/type/list/list'];?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Группа
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_raw_storage_group_id" name="shop_raw_storage_group_id" class="form-control select2" style="width: 100%">
            <option value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/raw/storage/group/list/list'];?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Единицы измерения
        </label>
    </div>
    <div class="col-md-9">
        <input name="unit" type="text" class="form-control" placeholder="Единицы измерения">
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

<script>
    function submitSave(id) {
        var isError = false;

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>
