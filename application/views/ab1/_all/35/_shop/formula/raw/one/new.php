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
            Сырье
        </label>
    </div>
    <div class="col-md-3">
        <input id="shop_raw_id" name="shop_raw_id" value="<?php echo $shopProductID = Request_RequestParams::getParamInt('shop_raw_id'); ?>" style="display: none">
        <select class="form-control select2" required style="width: 100%;" disabled>
            <option value="0" data-id="0">Без значения</option>
            <?php
            $tmp = 'data-id="'.$shopProductID.'"';
            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/raw/list/list']));
            ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дробилка
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_ballast_crusher_id" name="shop_ballast_crusher_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo trim($siteData->globalDatas['view::_shop/ballast/crusher/list/list']); ?>
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
<?php echo $siteData->globalDatas['view::_shop/formula/raw/item/list/index'];?>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitSave('shopformularaw');">Применить</button>
        <button type="button" class="btn btn-primary" onclick="submitSave('shopformularaw');">Сохранить</button>
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
