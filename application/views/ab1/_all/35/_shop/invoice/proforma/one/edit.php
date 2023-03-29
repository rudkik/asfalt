<?php $isShow = Request_RequestParams::getParamBoolean('is_show'); ?>
<div class="col-md-12">
    <h3 class="pull-left">Счет на оплату <small style="margin-right: 10px;">редактирование</small></h3>
    <div class="box-bth-right">
        <div class="btn-group pull-left">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/invoice_proforma_one', array(), array('shop_invoice_proforma_id' => $data->values['id'])); ?>" class="btn bg-navy btn-flat"><i class="fa fa-fw fa-plus"></i> Счет на оплату</a>
            <button type="button" class="btn bg-navy btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/invoice_proforma_pdf', array(), array('id' => $data->values['id'])); ?>">Сохранить в PDF</a></li>
            </ul>
        </div>
        <?php if($siteData->actionURLName == 'cashbox') { ?>
        <a href="<?php echo Func::getFullURL($siteData, '/shopinvoiceproforma/add_payment', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-blue btn-flat pull-left"><i class="fa fa-fw fa-list-alt"></i> Создать ПКО</a>
        <?php } ?>
    </div>
</div>
<form id="proforma" action="<?php echo Func::getFullURL($siteData, '/shopinvoiceproforma/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Дата счета
            </label>
        </div>
        <div class="col-md-3">
            <input name="date" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($data->values, 'date', ''));?>" <?php if($isShow){echo 'readonly';}?>>
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Номер счета
            </label>
        </div>
        <div class="col-md-3">
            <input id="number" name="number" type="text" class="form-control" placeholder="Номер счета" value="<?php echo htmlspecialchars(Arr::path($data->values, 'number', ''), ENT_QUOTES);?>" <?php if($isShow){echo 'readonly';}?>>
        </div>
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Общая сумма счета
            </label>
        </div>
        <div class="col-md-3">
            <input data-type="money" data-fractional-length="2" id="amount_total" name="amount" type="text" class="form-control" placeholder="Общая сумма счета" value="<?php echo Func::getNumberStr(Arr::path($data->values, 'amount', ''), true);?>" readonly>
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
                <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                        data-contract="#shop_client_contract_id" data-client="<?php echo $data->values['shop_client_id']; ?>"
                        id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%" <?php if($isShow){echo 'disabled';}?>>
                    <option value="<?php echo $data->values['shop_client_id']; ?>" selected><?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES); ?></option>
                </select>
                <?php if(!$isShow){ ?>
                <span class="input-group-btn add-client">
                    <a href="" class="btn bg-purple btn-flat" data-toggle="modal" data-target="#dialog-client"><i class="fa fa-fw fa-plus"></i> Добавить клиента</a>
                </span>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Договор
            </label>
        </div>
        <div class="col-md-3">
            <select data-url="/<?php echo $siteData->actionURLName; ?>/shopclientcontract/json?_fields[]=number&_fields[]=from_at"
                    id="shop_client_contract_id" name="shop_client_contract_id" data-contract-id="<?php echo $data->values['shop_client_contract_id']; ?>" class="form-control select2" style="width: 100%;" <?php if($isShow){echo 'disabled';}?>>
                <option value="0" data-id="0">Без договора</option>
                <?php echo trim($siteData->globalDatas['view::_shop/client/contract/list/option']); ?>
            </select>
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Примечание
            </label>
        </div>
        <div class="col-md-9">
            <textarea name="text" class="form-control" placeholder="Примечание" <?php if($isShow){echo 'readonly';}?>><?php echo htmlspecialchars(Arr::path($data->values, 'text', ''), ENT_QUOTES);?></textarea>
        </div>
    </div>
    <div class="row record-input record-list" style="margin-top: 30px">
        <div class="col-md-3 record-title">
            <label>
                Цены на дату
            </label>
        </div>
        <div class="col-md-3">
            <input id="current" type="datetime" date-type="date" class="form-control">
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <h3 class="pull-right">
                Продукция
            </h3>
        </div>
        <div class="col-md-9">
            <?php echo $siteData->globalDatas['view::_shop/invoice/proforma/item/list/index'];?>
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
            <?php if(!$isShow){?>
                <button type="button" class="btn btn-primary" onclick="$('#is_close').val(1); submitPayment('proforma');">Сохранить</button>
                <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitPayment('proforma');">Применить</button>
            <?php }?>
            <a href="/<?php echo $siteData->actionURLName; ?>/shopinvoiceproforma/index" class="btn btn-primary">Закрыть</a>
        </div>
    </div>
</form>
<script>
    function submitPayment(id) {
        var isError = false;

        var element = $('[name="shop_client_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="amount"]');
        var v = element.valNumber();
        if (!$.isNumeric(v) || parseFloat(v) <= 0){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        if(!isError) {
            tmp = $('input[disabled][name]');
            tmp.removeAttr('disabled');
            $('#'+id).submit();
            tmp.attr('disabled', '');
        }
    }
</script>