<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <div class="col-md-9">
        <div class="box-typeahead">
            <input id="shop_client_name" type="text" class="form-control typeahead" placeholder="Введите наименование клиента или его БИН/ИИН" value="<?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES); ?>" style="width: 100%" required readonly>
            <input id="shop_client_id" data-date="<?php echo $data->values['created_at'];?>" data-cash="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.balance_cache', ''); ?>" name="shop_client_id" value="<?php echo $data->values['shop_client_id']; ?>" style="display: none;" required>
        </div>
    </div>
</div>
<script>
    var bestPictures = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/general/shopclient/json?name_bin=%QUERY&sort_by[name]=asc&limit=50&_fields[]=name&_fields[]=bin&_fields[]=balance_cache&_fields[]=balance',
            wildcard: '%QUERY'
        }
    });

    field = $('#shop_client_name.typeahead');
    field.typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'best-pictures',
        display: 'name',
        source: bestPictures,
        templates: {
            empty: [
                '<div class="empty-message">Клиент не найден</div>'
            ].join('\n'),
            suggestion: Handlebars.compile('<div>{{name}} – {{bin}}</div>')
        }
    });
    field.on('keypress', function(e) {
        if(e.which == 13) {
            $(this).parent().parent().find(".tt-suggestion:first-child").trigger('click');
        }
    });
    field.on('change', function() {
        client = $('#shop_client_id');
        if(client.data('name') != $(this).val()){
            client.attr('value', '');
            client.val('');
            $(this).parent().addClass('has-error');
        }else{
            $(this).parent().removeClass('has-error');
        }
    });
    field.on('typeahead:select', function(e, selected) {
        $(this).parent().removeClass('has-error');

        var amount = selected.balance;
        if (amount < 0){
            amount = 0;
        }

        var amount_cash = selected.balance_cache;
        if (amount_cash < 0){
            amount_cash = 0;
        }

        var client = $('#shop_client_id');
        client.data('name', selected.name);
        client.data('amount', amount);
        client.data('amount_cash', amount_cash);
        client.data('cash', selected.balance_cache);
        client.attr('value', selected.id);
        $('#attorney ul li a[data-id="0"]').data('amount', amount);
        client.val(selected.id).trigger("change");
        $('#shop_product_id').trigger("change");
    });
</script>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Оплата за
        </label>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/piece/item/list/index'];?>
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
                <input name="name" id="name" type="text" data-type="auto-number" class="form-control" placeholder="Введите гос. номер автомобиля" required value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>" readonly>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    ФИО водителя
                </label>
            </div>
            <div class="col-md-9">
                <input name="shop_driver_name" type="text" class="form-control" placeholder="ФИО водителя" value="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_driver_id.name', ''), ENT_QUOTES); ?>" readonly>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Талон клиента
                </label>
            </div>
            <div class="col-md-9">
                <input name="ticket" type="text" class="form-control" required placeholder="Введите номер талона"  value="<?php echo htmlspecialchars($data->values['ticket']); ?>" readonly>
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
                    <select id="shop_delivery_id" name="shop_delivery_id" class="form-control select2" required style="width: 100%;" disabled>
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
                <input data-type="money" data-fractional-length="3" id="delivery_km" name="delivery_km" type="text" class="form-control" value="<?php echo Func::getNumberStr($data->values['delivery_km'], FALSE); ?>" readonly>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Стоимость доставки
                </label>
            </div>
            <div class="col-md-9">
                <input data-type="money" data-fractional-length="2" id="delivery_amount" name="delivery_amount" type="text" class="form-control" data-amount="<?php echo $data->values['delivery_amount']; ?>" value="<?php echo Func::getNumberStr($data->values['delivery_amount']); ?>" readonly>
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
                    <input id="total" data-value="<?php echo $data->values['amount']; ?>" data-amount="<?php echo $data->values['amount']; ?>" type="text" class="form-control input-amount" placeholder="Сумма" value="<?php echo Func::getNumberStr($data->values['amount'] + $data->values['delivery_amount'], true); ?>" disabled>
                    <span class="input-group-btn"> <a class="btn btn-flat box-amount-p"><b id="car-amount" class="text-red" style="font-size: 18px;"></b></a></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <div class="row">
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="is_debt" <?php if (Arr::path($data->values, 'is_debt', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" readonly>
                    В долг
                </label>
            </div>
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="is_balance"  <?php if (Arr::path($data->values, 'is_balance', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" readonly>
                    Проверять по балансу
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="options[is_not_overload]" <?php if (Arr::path($data->values['options'], 'is_not_overload', '') == 1){ ?> value="1" checked <?php }else{?> value="0" <?php }?> type="checkbox" class="minimal" readonly>
                    Не перегружать
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <div class="btn-group" id="attorney">
            <input id="shop_client_attorney_id" name="shop_client_attorney_id" value="<?php echo $data->values['shop_client_attorney_id']; ?>" style="display: none;">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php
                $attorney = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_attorney_id', '');

                $client = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id', '');
                $amountCash = Arr::path($client, 'balance_cache', '0');
                if (empty($attorney)){
                    echo 'Наличными';

                    if($amountCash > 0){
                        echo '<br><span class="text-red"> Остаток: <b style="font-size: 18px;">'.Func::getPriceStr($siteData->currency, $amountCash).' </b></span>';
                    }
                }else{
                    echo Arr::path($attorney, 'name', '').'<br><span class="text-red"> Остаток: <b style="font-size: 18px;">'.Func::getPriceStr($siteData->currency, Arr::path($attorney, 'balance', '0')).' </b></span>';
                }
                ?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" style="max-height: 309px;overflow-y: auto;">
                <li><a href="#" data-id="0" data-amount="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.balance', ''); ?>">Наличные<?php
                        if($amountCash > 0){
                            echo '<br><span class="text-red"> Остаток: <b style="font-size: 18px;">'.Func::getPriceStr($siteData->currency, $amountCash).' </b></span>';
                        }?></a></li>
                <?php echo $siteData->globalDatas['view::_shop/client/attorney/list/list']; ?>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <input id="is_close" name="is_close" value="1">
    </div>
</div>