<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%" <?php if($isShow){ ?>disabled<?php } ?>>
            <?php echo $siteData->globalDatas['view::_shop/client/list/list'];?>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    № автомобиля
                </label>
            </div>
            <div class="col-md-9">
                <input name="name" id="name" type="text" data-type="auto-number" class="form-control" placeholder="Введите гос. номер автомобиля" required value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Талон клиента
                </label>
            </div>
            <div class="col-md-9">
                <input name="ticket" type="text" data-type="auto-number" class="form-control" required placeholder="Введите номер талона"  value="<?php echo htmlspecialchars($data->values['ticket']); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Продукт
                </label>
            </div>
            <div class="col-md-9">
                <select id="shop_product_id" name="shop_product_id" class="form-control select2" required style="width: 100%;" <?php if(($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_EXIT) && (!$siteData->operation->getIsAdmin())){ echo 'disabled'; }?> <?php if($isShow){ ?>disabled<?php } ?>>
                    <option value="0" data-id="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
                </select>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Кол-во
                </label>
            </div>
            <div class="col-md-9">
                <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone" class="form-control" placeholder="Введите заявленное количество продукции" required value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>" <?php if(($data->values['tarra'] > 0) && (($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT) || (($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_CASH_EXIT))) && (!$siteData->operation->getIsAdmin())){ echo 'disabled'; }?> <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
        </div>
    </div>
</div>
<?php if($isShow){ ?>
    <div class="row">
        <div class="modal-footer text-center">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/talonxls', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> Талон</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/lessee_car_ttn', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> ТТН</a>
        </div>
    </div>
<?php }else{ ?>
<div class="row">
    <?php if($siteData->action != 'clone') { ?>
        <div hidden>
            <input id="is_close" name="is_close" value="1">
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
            <?php if(($data->values['tarra'] > 0) && (($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_CASH_EXIT))){ ?>
                <input id="is_exit" name="is_exit" value="<?php echo $data->values['is_exit']; ?>">
                <input id="shop_turn_id" name="shop_turn_id" value="<?php echo $data->values['shop_turn_id']; ?>">
            <?php } ?>
        </div>
        <div class="modal-footer text-center">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/talonxls', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> Талон</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/lessee_car_ttn', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> ТТН</a>
            <?php if(($data->values['tarra'] > 0) && (($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_CASH_EXIT))){ ?>
                <button type="button" class="btn btn-primary pull-left" onclick="submitRelease('shoplesseecar');">Выпустить</button>
            <?php } ?>
            <button type="button" class="btn btn-primary pull-right" onclick="submitCar('shoplesseecar');">Сохранить</button>
            <button type="button" class="btn btn-primary pull-right" onclick="$('#is_close').val(0); submitCar('shoplesseecar');">Применить</button>
        </div>
    <?php }else{ ?>
        <div hidden>
            <input id="shop_payment_id" name="shop_payment_id" value="0">
            <input id="shop_turn_id" name="shop_turn_id" value="<?php echo Model_Ab1_Shop_Turn::TURN_WEIGHTED_ENTRY; ?>">
            <input id="is_close" name="is_close" value="1">
        </div>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitCar('shoplesseecar');">Применить</button>
            <button type="button" class="btn btn-primary" onclick="submitCar('shoplesseecar');">Сохранить</button>
        </div>
    <?php } ?>
</div>
<script>
    function submitRelease(id) {
        $('#is_exit').val(1).attr('value', 1);
        $('#shop_turn_id')
            .val(<?php echo Model_Ab1_Shop_Turn::TURN_EXIT; ?>)
            .attr('value', <?php echo Model_Ab1_Shop_Turn::TURN_EXIT; ?>);

        submitCar(id);
    }
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
        s = element.valNumber();
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
<?php } ?>