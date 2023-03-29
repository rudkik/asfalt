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
        <select id="shop_car_tare_id" name="shop_car_tare_id" class="form-control select2 text-number" required style="width: 100%;" <?php if($siteData->action != 'clone' && !$siteData->operation->getIsAdmin()) { ?> disabled<?php } ?>>
            <option value="0" data-id="0">Без значения</option>
            <?php if($siteData->action == 'clone') { ?>
                <?php
                $s = 'data-name="'.Request_RequestParams::getParamStr('number').'"';
                echo str_replace($s, $s.' selected', str_replace('selected', '', $siteData->replaceDatas['view::_shop/car/tare/list/list']));
                ?>
            <?php }else{ ?>
                <?php echo $siteData->globalDatas['view::_shop/car/tare/list/list']; ?>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            ФИО водителя
        </label>
    </div>
    <div class="col-md-3">
        <input name="shop_driver_name" type="text" class="form-control" placeholder="ФИО водителя" value="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_driver_id.name', ''), ENT_QUOTES); ?>">
    </div>
</div>
<?php if($siteData->action != 'clone') { ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Вес
            </label>
        </div>
        <div class="col-md-9">
            <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone" class="text-number form-control" placeholder="Вес" required value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>" <?php if(!$siteData->operation->getIsAdmin()) { ?> disabled<?php } ?>>
        </div>
    </div>
<?php }else{ ?>
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
<?php } ?>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
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
        var element2 = $('#'+id+' [name="quantity"]');
        var s1 = element.valNumber();
        var s2 = element2.valNumber();
        if ((!$.isNumeric(s1) || parseFloat(s1) <= 0)
            && (!$.isNumeric(s2) || parseFloat(s2) <= 0)){
            element.parent().addClass('has-error');
            element2.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>