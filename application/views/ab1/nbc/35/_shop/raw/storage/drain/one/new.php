<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_upload" value="0" style="display: none;">
            <input name="is_upload" value="0" type="checkbox" class="minimal">
            Производство материала
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Лоток слива НБЦ
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_raw_drain_chute_id" name="shop_raw_drain_chute_id" class="form-control select2" style="width: 100%">
            <option data-id="0" value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/raw/drain-chute/list/list'];?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Сырьевой парк
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_raw_storage_id" name="shop_raw_storage_id" class="form-control select2" style="width: 100%">
            <option data-id="0" value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/raw/storage/list/list'];?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Куб готовой продукции
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_material_storage_id" name="shop_material_storage_id" class="form-control select2" style="width: 100%">
            <option data-id="0" value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/material/storage/list/list'];?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Материал
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_material_id" name="shop_material_id" class="form-control select2" style="width: 100%">
            <option data-id="0" value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/material/list/list'];?>
        </select>
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitSave('shoprawstoragedrain');">Применить</button>
        <button type="button" class="btn btn-primary" onclick="submitSave('shoprawstoragedrain');">Сохранить</button>
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
