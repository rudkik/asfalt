<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Название
        </label>
    </div>
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Продукт
        </label>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <select id="shop_product_id" name="shop_product_id" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
            </select>
        </div>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Материал
        </label>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <select id="shop_material_id" name="shop_material_id" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php
                $tmp = 'data-id="'.$data->values['shop_material_id'].'"';
                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/material/list/list']));
                ?>
            </select>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Рецепт
        </label>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/formula/item/list/index'];?>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-danger" onclick="addElement('new-product', 'products', true);">Добавить строчку</button>
        </div>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="submitFormula('shopformula');">Сохранить</button>
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitFormula('shopformula');">Применить</button>
    </div>
</div>
<script>
    function submitFormula(id) {
        var isError = false;

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>