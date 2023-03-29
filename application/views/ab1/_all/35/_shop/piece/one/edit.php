<?php $isOneAttorney = $data->values['is_one_attorney'] || Request_RequestParams::getParamBoolean('is_one_attorney') !== false; ?>
<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <?php
    $amount = $data->getElementValue('shop_client_id', 'balance');
    if ($amount < 0){
        $amount = 0;
    }
    ?>
    <div class="col-md-9">
        <div class="input-group">
            <select data-client="<?php echo $data->values['shop_client_id'];?>" data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                    data-attorney='[data-action="shop_client_attorney"]' data-contract='[data-action="shop_client_contract"]'
                    id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%"
                    data-date="<?php echo $data->values['created_at'];?>"
                    data-is-invoice-print="<?php echo Func::boolToStr(Func::_empty($data->getElementValue('shop_client_id', 'bin'))); ?>" data-cache="<?php echo $amount; ?>"
                    <?php if($isShow){ ?>disabled<?php } ?>>
                <option value="<?php echo $data->values['shop_client_id']; ?>" selected><?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES); ?></option>
            </select>
            <?php if(!$isShow){ ?>
                <span class="input-group-btn add-client">
                <a href="" class="btn bg-purple btn-flat" data-toggle="modal" data-target="#dialog-client"><i class="fa fa-fw fa-plus"></i> Добавить клиента</a>
            </span>
            <?php } ?>
            <span class="input-group-btn"> <a class="btn btn-flat box-amount-p"><b id="client-amount" class="text-navy" style="font-size: 18px;"><?php echo Func::getPriceStr($siteData->currency, $amount, TRUE, FALSE); ?></b></a></span>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Оплата за
        </label>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/piece/item/list/index'];?>
        <?php if(!$isShow){ ?>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-danger" onclick="addElement('new-product', 'products', true);">Добавить продукт</button>
            </div>
        <?php } ?>
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
                    ФИО водителя
                </label>
            </div>
            <div class="col-md-9">
                <input name="shop_driver_name" type="text" class="form-control" placeholder="ФИО водителя" value="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_driver_id.name', ''), ENT_QUOTES); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Талон клиента
                </label>
            </div>
            <div class="col-md-9">
                <input name="ticket" type="text" class="form-control" required placeholder="Введите номер талона"  value="<?php echo htmlspecialchars($data->values['ticket']); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Доставка
                </label>
            </div>
            <div class="col-md-9">
                <div class="input-group">
                    <select id="shop_delivery_id" name="shop_delivery_id" data-delivery-quantity="<?php echo $data->values['delivery_quantity']; ?>" data-quantity="<?php echo $data->values['quantity']; ?>" class="form-control select2" required style="width: 100%;"<?php if($isShow){ ?>disabled<?php } ?>>
                        <option value="0" data-id="0">Без доставки</option>
                        <?php echo $siteData->globalDatas['view::_shop/delivery/list/list']; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Расстояние (км)
                </label>
            </div>
            <div class="col-md-9">
                <input data-type="money" data-fractional-length="3" id="delivery_km" name="delivery_km" type="text" class="form-control" value="<?php echo Func::getNumberStr($data->values['delivery_km'], FALSE); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Стоимость доставки
                </label>
            </div>
            <div class="col-md-9">
                <input id="delivery_amount" name="delivery_amount" type="text" class="form-control" data-amount="<?php echo Func::getNumberStr($data->values['delivery_amount']); ?>" value="<?php echo Func::getNumberStr($data->values['delivery_amount']); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Сумма
                </label>
            </div>
            <div class="col-md-9">
                <div class="input-group">
                    <input id="total" data-value="<?php echo $data->values['amount']; ?>" data-amount="<?php echo $data->values['amount']; ?>" data-service-amount="<?php echo $data->values['amount_service']; ?>" type="text" class="form-control" placeholder="Сумма" value="<?php echo Func::getNumberStr($data->values['amount'] +  + $data->values['delivery_amount'], true); ?>" disabled>
                    <span class="input-group-btn"> <a class="btn btn-flat box-amount-p"><b id="car-amount" class="text-red" style="font-size: 18px;"></b></a></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div style="min-height: 152px;"  class="col-md-3">
        <div class="row">
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input id="is_debt" name="is_debt" <?php if (Arr::path($data->values, 'is_debt', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal"<?php if($isShow){ ?>disabled<?php } ?>>
                    В долг
                </label><br>
                <label class="span-checkbox">
                    <input id="is_charity" name="is_charity" data-id="1" <?php if (Arr::path($data->values, 'is_charity', '0') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){ ?>disabled<?php } ?>>
                    Благотворительность
                </label>
            </div>
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="is_balance"  <?php if (Arr::path($data->values, 'is_balance', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){ ?>disabled<?php } ?>>
                    Проверять по балансу
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="options[is_not_overload]" <?php if (Arr::path($data->values['options'], 'is_not_overload', '') == 1){ ?> value="1" checked <?php }else{?> value="0" <?php }?> type="checkbox" class="minimal" <?php if($isShow){ ?>disabled<?php } ?>>
                    Не перегружать
                </label>
            </div>
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="is_invoice_print" value="0" style="display: none">
                    <input name="is_invoice_print"  <?php if (Arr::path($data->values, 'is_invoice_print', '0') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){ ?>disabled<?php } ?>>
                    Нужен счет-фактура?
                </label>
            </div>
        </div>
        <?php if($siteData->action != 'clone') { ?>
            <div class="row">
                <div id="send-payment" class="col-md-12" <?php if($data->values['shop_payment_id'] < 1){echo 'style="display:none;"';} ?>>
                    <span>Привязан к оплате </span>
                    <label>
                        <a target="_blank" class="text-purple" href="<?php echo Func::getFullURL($siteData, '/shoppayment/edit', array('id' => 'shop_payment_id'), array('is_show' => true), $data->values); ?>">
                            №<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_payment_id.number', '');?>
                        </a>
                    </label>
                    <?php if(!$isShow){ ?>
                        <a href="javascript:deleteSelectPayment()"> <i class="fa fa-fw fa-remove text-red"></i></a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php if($isOneAttorney) { ?>
    <div class="col-md-3 record-title">
        <label>Доверенность</label>
    </div>
    <div class="col-md-3">
        <select data-action="shop_client_attorney" data-contract="#shop_client_contract_id" data-product="#shop_delivery_id" id="shop_client_attorney_id" name="shop_client_attorney_id"
                data-product-amount="<?php echo $data->values['amount']; ?>" data-attorney-id="<?php echo $data->values['shop_client_attorney_id']; ?>"
                data-delivery-amount="<?php echo $data->getElementValue('shop_client_attorney_id', 'balance-delivery', 0); ?>" data-product-delivery-amount="<?php echo $data->values['delivery_amount']; ?>"
                data-amount="<?php echo $data->getElementValue('shop_client_attorney_id', 'balance', $data->getElementValue('shop_client_id', 'balance_cache', 0)); ?>"
                class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Наличными</option>
            <?php echo $siteData->globalDatas['view::_shop/client/attorney/list/option-balance']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>Договор</label>
    </div>
    <div class="col-md-3">
        <select data-action="shop_client_contract" id="shop_client_contract_id" name="shop_client_contract_id" data-contract-id="<?php echo $data->values['shop_client_contract_id']; ?>" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Без договора</option>
            <?php echo $siteData->globalDatas['view::_shop/client/contract/list/list']; ?>
        </select>
    </div>
    <?php } ?>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Транспортная компания
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/transport/company/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Дополнительные услуги
        </label>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/addition/service/item/list/index'];?>
        <?php if(!$isShow){ ?>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-danger" onclick="addElement('new-addition-service', 'addition_services', true);">Добавить услугу</button>
            </div>
        <?php } ?>
    </div>
</div>
<?php if(!$isShow){ ?>
    <div class="row">
        <div hidden>
            <?php if($siteData->action != 'clone') { ?>
                <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
            <?php } ?>
            <input id="is_close" name="is_close" value="1">
        </div>
        <?php if($siteData->action != 'clone') { ?>
            <div class="modal-footer text-center">
                <?php if($siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_CASH && empty($data->values['shop_payment_id']) && (!$siteData->operation->getShopTableUnitID()) && $siteData->operation->values['shop_cashbox_id'] > 0){ ?>
                    <a href="javascript:showAddNewPayment()" class="btn bg-purple btn-flat pull-left"><i class="fa fa-fw fa-money"></i> Добавить оплату</a>
                <?php } ?>
                <a href="<?php echo Func::getFullURL($siteData, '/shopreport/talon_piecexls', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> Талон</a>
                <a href="<?php echo Func::getFullURL($siteData, '/shopreport/ttnxls', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> ТТН</a>
                <?php if((intval($data->values['shop_payment_id']) > 0)){ ?>
                    <a href="<?php echo Func::getFullURL($siteData, '/shopreport/orderxls_payment', array(), array('id' => $data->values['shop_payment_id'])); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> Счет</a>
                    <a href="<?php echo Func::getFullURL($siteData, '/shopreport/pkoxls_payment', array(), array('id' => $data->values['shop_payment_id'])); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-list-alt"></i> ПКО</a>
                <?php } ?>
                <button type="button" class="btn btn-primary pull-right" onclick="submitPiece('shoppiece');">Сохранить</button>
                <button type="button" class="btn btn-primary pull-right" onclick="$('#is_close').val(0); submitPiece('shoppiece');">Применить</button>
            </div>
        <?php }else{ ?>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitPiece('shoppiece');">Применить</button>
                <button type="button" class="btn btn-primary" onclick="submitPiece('shoppiece');">Сохранить</button>
            </div>
        <?php } ?>
    </div>
<?php }else{ ?>
    <div class="row">
        <div class="modal-footer text-center">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/talon_piecexls', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> Талон</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/ttnxls', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> ТТН</a>
        </div>
    </div>
<?php } ?>
<script>
    $('#shop_client_id, #shop_client_contract_id, #is_charity').change(function () {
        $('[data-action="calc-piece"]').trigger('change');
    });

    $(function () {
        initClientAttorneyPieceNew(
            $('#shop_delivery_id'),
            $('#delivery_amount'),
            $('#delivery_km'),
            'input[data-action="calc-piece"]',
            $('#total'),
            $('#car-amount'),
            $('#shop_client_attorney_id'),
            $('#is_charity')
        );
    });

    $('[name="is_invoice_print"]').on('ifChecked', function (event) {
        if(!$('[name="shop_client_id"]').data('is-invoice-print')) {
            alert('БИН/ИИН не задан у данного клиента');
        }
    })

    function showAddNewPayment() {
        $('#dialog-payment #modal_shop_client_id').attr('value', $('#shop_client_id').val());

        $('#dialog-payment [name="amount"]').valNumber($('#total').valNumber() - $('#delivery_amount').valNumber());
        $('#dialog-payment').modal('show');
    }

    function submitPiece(id) {
        var isError = false;

        var element = $('[name="shop_client_id"]');
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

        $('#products').find('select').each(function (){
            var element = $(this);
            if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
                element.parent().addClass('has-error');
                isError = true;
            }else{
                element.parent().removeClass('has-error');
            }
        });

        $('#products').find('input').each(function (){
            var element = $(this);
            if (element.valNumber() == 0){
                element.parent().addClass('has-error');
                isError = true;
            }else{
                element.parent().removeClass('has-error');
            }
        });

        var deliveryAmount = $('#delivery_amount').valNumber();
        if($('#is_debt').val() != 1){
            var clientAmount = Number($('#shop_client_attorney_id').data('amount'));
            var total = $('#total').valNumber();
            var amount = total;
            if(clientAmount < amount){
                alert('У клиента не достаточно денег!');
                isError = true;
            }
        }

        if(!isError) {
            $('#delivery_amount').val(deliveryAmount);
            $('#'+id).submit();
        }
    }
</script>