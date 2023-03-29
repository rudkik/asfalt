<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select data-client="-1" data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                    data-attorney="#shop_client_attorney_id" data-contract="#shop_client_contract_id"
                    id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
            </select>
            <span class="input-group-btn add-client">
                <a href="" class="btn bg-purple btn-flat" data-toggle="modal" data-target="#dialog-client"><i class="fa fa-fw fa-plus"></i> Добавить клиента</a>
            </span>
            <span class="input-group-btn"> <a class="btn btn-flat"><b id="client-amount" class="text-navy" style="font-size: 18px;"></b></a></span>
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
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-danger" onclick="addElement('new-product', 'products', true);">Добавить продукт</button>
        </div>
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
                <input name="name" id="name" type="text" data-type="auto-number" class="form-control" placeholder="Введите гос. номер автомобиля" required>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    ФИО водителя
                </label>
            </div>
            <div class="col-md-9">
                <input name="shop_driver_name" type="text" class="form-control" placeholder="ФИО водителя">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Талон клиента
                </label>
            </div>
            <div class="col-md-9">
                <input name="ticket" type="text" class="form-control" required placeholder="Введите номер талона">
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
                    <select id="shop_delivery_id" name="shop_delivery_id" data-quantity="0" data-delivery-quantity="0" class="form-control select2" required style="width: 100%;">
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
                <input data-type="money" data-fractional-length="3" id="delivery_km" name="delivery_km" type="text" class="form-control">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Стоимость доставки
                </label>
            </div>
            <div class="col-md-9">
                <input id="delivery_amount" name="delivery_amount" type="text" class="form-control" data-amount="0" >
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
                    <input data-value="0" data-amount="0" data-service-amount="0" id="total" type="text" class="form-control input-amount" placeholder="Сумма" value="0" disabled>
                    <span class="input-group-btn"> <a class="btn btn-flat"><b id="car-amount" class="text-red" style="font-size: 18px;"></b></a></span>
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
                    <input id="is_debt" name="is_debt" value="0" type="checkbox" class="minimal">
                    В долг
                </label><br>
                <label class="span-checkbox">
                    <input id="is_charity" name="is_charity" data-id="1" value="0" type="checkbox" class="minimal">
                    Благотворительность
                </label>
            </div>
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="is_balance" value="0" type="checkbox" class="minimal">
                    Проверять по балансу
                </label>
            </div>
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="is_invoice_print" value="0" type="checkbox" class="minimal">
                    Нужен счет-фактура?
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-3 record-title">
        <label>Доверенность</label>
    </div>
    <div class="col-md-3">
        <select data-contract="#shop_client_contract_id" data-product="#shop_delivery_id" id="shop_client_attorney_id" name="shop_client_attorney_id"
                data-product-amount="0" data-attorney-id="-1" data-delivery-amount="0" data-amount="0"
                class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Наличными</option>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>Договор</label>
    </div>
    <div class="col-md-3">
        <select id="shop_client_contract_id" name="shop_client_contract_id" data-contract-id="-1" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без договора</option>
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
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-danger" onclick="addElement('new-addition-service', 'addition_services', true);">Добавить услугу</button>
        </div>
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitPiece('shoppiece');">Применить</button>
        <button type="button" class="btn btn-primary" onclick="submitPiece('shoppiece');">Сохранить</button>
    </div>
</div>
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
