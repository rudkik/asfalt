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
            Продукция
        </label>
    </div>
    <div class="col-md-9">
        <input id="shop_product_id" name="shop_product_id" value="<?php echo $shopProductID = Request_RequestParams::getParamInt('shop_product_id'); ?>" style="display: none">
        <select class="form-control select2" required style="width: 100%;" disabled>
            <option value="0" data-id="0">Без значения</option>
            <?php
            $tmp = 'data-id="'.$shopProductID.'"';
            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/product/list/list']));
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
            Примечание
        </label>
    </div>
    <div class="col-md-9">
        <textarea name="name" class="form-control" placeholder="Примечание"></textarea>
    </div>
</div>
<?php echo $siteData->globalDatas['view::_shop/formula/product/item/list/index'];?>
<?php echo $siteData->globalDatas['view::_shop/formula/product/item/list/side'];?>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1">
        <input id="formula_type_id" name="formula_type_id" value="<?php echo Request_RequestParams::getParamInt('formula_type_id');?>">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitSave('shopformulaproduct');">Применить</button>
        <button type="button" class="btn btn-primary" onclick="submitSave('shopformulaproduct');">Сохранить</button>
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
