<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Активный
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Материал
        </label>
    </div>
    <div class="col-md-9">
        <input name="shop_material_id" value="<?php echo $shopMaterialID = Request_RequestParams::getParamInt('shop_material_id'); ?>" style="display: none">
        <select id="shop_material_id" class="form-control select2" required style="width: 100%;" disabled>
            <option value="0" data-id="0">Без значения</option>
            <?php
            $tmp = 'data-id="'.$shopMaterialID.'"';
            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/material/list/list']));
            ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Начало
        </label>
    </div>
    <div class="col-md-3">
        <input name="from_at" type="datetime" date-type="date" class="form-control" placeholder="Начало" required>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Окончание
        </label>
    </div>
    <div class="col-md-3">
        <input name="to_at" type="datetime" date-type="date" class="form-control" placeholder="Окончание" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            № приказа
        </label>
    </div>
    <div class="col-md-3">
        <input name="contract_number" type="text" class="form-control" placeholder="№ приказа">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Дата приказа
        </label>
    </div>
    <div class="col-md-3">
        <input name="contract_date" type="datetime" class="form-control" placeholder="Дата приказа">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Группы рецептов
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select id="access" name="shop_formula_group_ids[]" class="form-control select2" multiple required style="width: 100%;">
                <?php echo $siteData->globalDatas['view::_shop/formula/group/list/list']; ?>
            </select>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Примечание
        </label>
    </div>
    <div class="col-md-9">
        <textarea name="name" class="form-control" placeholder="Примечание"></textarea>
    </div>
</div>
<?php echo $siteData->globalDatas['view::_shop/formula/material/item/list/index'];?>
<?php echo $siteData->globalDatas['view::_shop/formula/material/item/list/side'];?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Влажность (%)
        </label>
    </div>
    <div class="col-md-9">
        <input data-type="money" data-fractional-length="2" name="wet" type="text" class="form-control" placeholder="Влажность (%)">
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1">
        <input id="formula_type_id" name="formula_type_id" value="<?php echo Request_RequestParams::getParamInt('formula_type_id'); ?>">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitSave('shopformulamaterial');">Применить</button>
        <button type="button" class="btn btn-primary" onclick="submitSave('shopformulamaterial');">Сохранить</button>
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
