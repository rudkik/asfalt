<div class="row" style="margin-bottom: 10px">
    <div class="col-md-12">
        <h3 class="pull-left">Акт выполненных работ <small style="margin-right: 10px;">редактирование</small></h3>
        <div class="box-bth-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactservice/rebuild', array(), array('id' => $data->values['id']), array(), false, true); ?>" class="btn bg-orange btn-flat pull-left"><i class="fa fa-fw fa-list-alt"></i> Добавить доп. услуги</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/act_service_one', array(), array('id' => $data->values['id']), array(), false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-list-alt"></i> Акт выполненных работ</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/act_service_registry', array(), array('id' => $data->values['id']), array(), false, true); ?>" class="btn bg-blue btn-flat pull-left"><i class="fa fa-fw fa-list-alt"></i> Реестр</a>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Номер
        </label>
    </div>
    <div class="col-md-3">
        <input type="text" class="form-control" placeholder="Номер" value="<?php echo htmlspecialchars($data->values['number'], ENT_QUOTES);?>" readonly>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дата
        </label>
    </div>
    <div class="col-md-3">
        <input name="date" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Клиент" value="<?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES);?>" readonly>
            <input name="shop_client_id" value="<?php echo $data->values['shop_client_id']; ?>" style="display: none;">
            <span class="input-group-btn"> <a class="btn btn-flat box-amount-p"><b id="client-amount" class="text-navy" style="font-size: 18px;"><?php echo Func::getPriceStr($siteData->currency, $data->getElementValue('shop_client_id', 'balance'), TRUE, FALSE); ?></b></a></span>
        </div>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Доверенность
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_client_attorney_id" name="shop_client_attorney_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без доверенности</option>
            <?php echo trim($siteData->globalDatas['view::_shop/client/attorney/list/option']); ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Тип оплаты
        </label>
    </div>
    <div class="col-md-3">
        <select id="act_service_paid_type_id" name="act_service_paid_type_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::act-service-paid-type/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Договор
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_client_contract_id" name="shop_client_contract_id" data-contract-id="<?php echo $data->values['shop_client_contract_id']; ?>" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без договора</option>
            <?php echo trim($siteData->globalDatas['view::_shop/client/contract/list/list']); ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Цех доставки
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_delivery_department_id" name="shop_delivery_department_id" class="form-control select2" style="width: 100%;">
            <?php echo trim($siteData->globalDatas['view::_shop/delivery/department/list/list']); ?>
        </select>
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary pull-right" onclick="submitInvoice('shopactservice');">Сохранить</button>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Продукция
        </label>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/act/service/item/list/index'];?>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Дополнительные услуги
        </label>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/act/service/item/list/addition-service'];?>
    </div>
</div>
<script>

    function submitInvoice(id) {
        var isError = false;

        var element = $('[name="act_service_paid_type_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="shop_client_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="date"]');
        if ($.trim(element.val()) == ''){
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