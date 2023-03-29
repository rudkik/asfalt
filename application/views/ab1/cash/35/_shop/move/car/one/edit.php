<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Подразделение
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select id="shop_client_id" name="shop_client_id" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/move/client/list/list']; ?>
            </select>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Продукт
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select id="shop_product_id" name="shop_product_id" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
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
        <input name="name" id="name" type="text" data-type="auto-number" class="form-control" placeholder="Введите гос. номер автомобиля" required value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
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
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Кол-во
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone" class="form-control" placeholder="Введите заявленное количество продукции" required value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>" <?php if(($data->values['tarra'] > 0) && (($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT) || (($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_CASH_EXIT))) && (!$siteData->operation->getIsAdmin())){ echo 'disabled'; }?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <div class="row">
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="is_delivery"  <?php if (Arr::path($data->values, 'is_delivery', '') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                    Доставка
                </label>
            </div>
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="options[is_not_overload]" <?php if (Arr::path($data->values['options'], 'is_not_overload', '') == 1){ ?> value="1" checked <?php }else{?> value="0" <?php }?> type="checkbox" class="minimal">
                    Не перегружать
                </label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1">
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
            <?php if(($data->values['tarra'] > 0) && (($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_CASH_EXIT))){ ?>
                <input id="is_exit" name="is_exit" value="<?php echo $data->values['is_exit']; ?>">
                <input id="shop_turn_id" name="shop_turn_id" value="<?php echo $data->values['shop_turn_id']; ?>">
            <?php }else{?>
                <input id="shop_turn_id" name="shop_turn_id" value="<?php echo Model_Ab1_Shop_Turn::TURN_WEIGHTED_ENTRY; ?>">
            <?php } ?>
        <?php } ?>
    </div>
    <?php if($siteData->action != 'clone') { ?>
    <div class="modal-footer text-center">
        <a href="<?php echo Func::getFullURL($siteData, '/shopreport/move_talonxls', array(), array('id' => $data->values['id'])); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> Талон</a>
        <button type="button" class="btn btn-primary pull-right" onclick="submitCar('shopmovecar');">Сохранить</button>
        <button type="button" class="btn btn-primary pull-right" onclick="$('#is_close').val(0); submitCar('shopmovecar');">Применить</button>
    </div>
    <?php }else{ ?>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitCar('shopmovecar');">Применить</button>
            <button type="button" class="btn btn-primary" onclick="submitCar('shopmovecar');">Сохранить</button>
        </div>
    <?php } ?>
</div>
<script>
    function submitCar(id) {
        var isError = false;

        var element = $('[name="shop_client_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="shop_product_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="name"]');
        if ($.trim(element.val()) == ''){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="quantity"]');
        var s = element.valNumber();
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