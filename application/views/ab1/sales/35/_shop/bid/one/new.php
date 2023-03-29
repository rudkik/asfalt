<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <div class="col-md-9">
        <select data-client="-1" data-action="shop_client" data-basic-url="sales" data-action-select2="1" data-less-zero="false"
                id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Месяц
        </label>
    </div>
    <div class="col-md-3">
        <?php
        $month = intval(date('m')) + 1;
        if ($month > 12){
            $month = 1;
        }
        ?>
        <select id="month" name="month" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <option value="1" data-id="1" <?php if ($month == 1){echo 'selected';} ?>>Январь</option>
            <option value="2" data-id="2" <?php if ($month == 2){echo 'selected';} ?>>Февраль</option>
            <option value="3" data-id="3" <?php if ($month == 3){echo 'selected';} ?>>Март</option>
            <option value="4" data-id="4" <?php if ($month == 4){echo 'selected';} ?>>Апрель</option>
            <option value="5" data-id="5" <?php if ($month == 5){echo 'selected';} ?>>Май</option>
            <option value="6" data-id="6" <?php if ($month == 6){echo 'selected';} ?>>Июнь</option>
            <option value="7" data-id="7" <?php if ($month == 7){echo 'selected';} ?>>Июль</option>
            <option value="8" data-id="8" <?php if ($month == 8){echo 'selected';} ?>>Август</option>
            <option value="9" data-id="9" <?php if ($month == 9){echo 'selected';} ?>>Сентябрь</option>
            <option value="10" data-id="10" <?php if ($month == 10){echo 'selected';} ?>>Октябрь</option>
            <option value="11" data-id="11" <?php if ($month == 11){echo 'selected';} ?>>Ноябрь</option>
            <option value="12" data-id="12" <?php if ($month == 12){echo 'selected';} ?>>Декабрь</option>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Год
        </label>
    </div>
    <div class="col-md-3">
        <input name="year" type="text" class="form-control" placeholder="Год" value="<?php echo date('Y'); ?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Филиал
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Заявка
        </label>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/bid/item/list/index'];?>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-danger" onclick="addElement('new-product', 'products', true);">Добавить строчку</button>
        </div>
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1">
        <input id="is_month" name="is_month" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitBid('shopbid');">Применить</button>
        <button type="button" class="btn btn-primary" onclick="submitBid('shopbid');">Сохранить</button>
    </div>
</div>
<script>
    function submitBid(id) {
        var isError = false;

        var element = $('[name="month"]');
        s = element.val();
        if (!$.isNumeric(s) || parseFloat(s) <= 0){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="year"]');
        s = element.val();
        if (!$.isNumeric(s) || parseFloat(s) <= 0){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>