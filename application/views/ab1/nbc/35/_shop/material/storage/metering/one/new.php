<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Куб готовой продукции
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_material_storage_id" name="shop_material_storage_id" class="form-control select2" style="width: 100%">
            <option data-id="0" value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/material/storage/list/list'];?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Кол-во метров
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" name="meter" type="text" class="form-control" placeholder="Кол-во метров" required>
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitSave('shopmaterialstoragemetering');">Применить</button>
        <button type="button" class="btn btn-primary" onclick="submitSave('shopmaterialstoragemetering');">Сохранить</button>
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
