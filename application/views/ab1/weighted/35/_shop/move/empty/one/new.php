<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Место вывоза
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_move_place_id" name="shop_move_place_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/move/place/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Владелец транспорта
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/transport/company/list/list']; ?>
            </select>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            № автомобиля
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_car_tare_id" name="shop_car_tare_id" class="text-number form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php
            $name = 'data-name="'.Request_RequestParams::getParamStr('number').'"';
            echo str_replace($name, $name.' selected', $siteData->replaceDatas['view::_shop/car/tare/list/list']);
            ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            ФИО водителя
        </label>
    </div>
    <div class="col-md-3">
        <input name="shop_driver_name" type="text" class="form-control" placeholder="ФИО водителя">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Брутто
        </label>
    </div>
    <div class="col-md-3">
        <input id="brutto" name="brutto" type="text" class="text-number form-control" required placeholder="Брутто" value="<?php echo Request_RequestParams::getParamFloat('weight'); ?>"  readonly>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Нетто
        </label>
    </div>
    <div class="col-md-3">
        <input id="netto" type="text" class="text-number form-control" required placeholder="Нетто" readonly>
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitCar('shopcar');">Применить</button>
        <button type="button" class="btn btn-primary" onclick="submitCar('shopcar');">Сохранить</button>
    </div>
</div>

<script>
    function submitCar(id) {
        var isError = false;

        var element = $('#'+id+' [name="shop_move_place_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('#'+id+' [name="shop_car_tare_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('#'+id+' [name="brutto"]');
        if (!$.isNumeric(element.val()) || parseFloat(element.val()) <= 0){
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