<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <?php
    $amount = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.balance', '');
    if ($amount < 0){
        $amount = 0;
    }
    ?>
    <div class="col-md-9">
        <div class="input-group">
            <div class="box-typeahead">
                <input id="shop_client_name" type="text" class="form-control typeahead" placeholder="Введите наименование клиента или его БИН/ИИН" value="<?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES); ?>" style="width: 100%" required readonly>
            </div>
            <span class="input-group-btn"> <a class="btn btn-flat box-amount-p"><b id="client-amount" class="text-navy" style="font-size: 18px;"><?php echo Func::getPriceStr($siteData->currency, $amount, TRUE, FALSE); ?></b></a></span>
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
            <select id="shop_product_id" name="shop_product_id" class="form-control select2" required style="width: 100%;" disabled>
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
        <input name="name" id="name" data-type="auto-number" type="text" class="form-control" placeholder="Введите гос. номер автомобиля" required value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>" readonly>
    </div>
    <div class="col-md-3 record-title">
        <label>
            ФИО водителя
        </label>
    </div>
    <div class="col-md-3">
        <input name="shop_driver_name" type="text" class="form-control" placeholder="ФИО водителя" value="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_driver_id.name', ''), ENT_QUOTES); ?>" readonly>
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
        <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone" class="form-control" placeholder="Введите заявленное количество продукции" required value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>" readonly>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Сумма
        </label>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <input id="amount" data-value="<?php echo $data->values['amount']; ?>" data-amount="<?php echo $data->values['amount']; ?>" type="text" class="form-control" placeholder="Сумма" value="<?php echo Func::getNumberStr($data->values['amount']); ?>" readonly>
            <span class="input-group-btn"> <a class="btn btn-flat box-amount-p"><b id="car-amount" class="text-red" style="font-size: 18px;"></b></a></span>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <div class="row">
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="is_debt" <?php if (Arr::path($data->values, 'is_debt', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" disabled>
                    В долг
                </label>
            </div>
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="is_balance"  <?php if (Arr::path($data->values, 'is_balance', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" disabled>
                    Проверять по балансу
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="is_delivery"  <?php if (Arr::path($data->values, 'is_delivery', '') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" disabled>
                    Доставка
                </label>
            </div>
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="options[is_not_overload]" <?php if (Arr::path($data->values['options'], 'is_not_overload', '') == 1){ ?> value="1" checked <?php }else{?> value="0" <?php }?> type="checkbox" class="minimal" disabled>
                    Не перегружать
                </label>
            </div>
        </div>

        <?php if($siteData->action != 'clone') { ?>
        <div class="row">
            <div id="send-payment" class="col-md-12" <?php if($data->values['shop_payment_id'] < 1){echo 'style="display:none;"';} ?>>
                <span>Привязан к оплате </span>
                <label>
                    <a target="_blank" class="text-purple" href="<?php echo Func::getFullURL($siteData, '/shoppayment/edit', array('id' => 'shop_payment_id'), array(), $data->values); ?>">
                        №<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_payment_id.number', '');?>
                    </a>
                </label>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <div class="btn-group" id="attorney">
            <input id="shop_client_attorney_id" name="shop_client_attorney_id" value="<?php echo $data->values['shop_client_attorney_id']; ?>" style="display: none;">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" disabled><?php
                $attorney = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_attorney_id', '');
                if (empty($attorney)){
                    echo 'Наличными';
                }else{
                    echo Arr::path($attorney, 'name', '');
                }
                ?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" style="max-height: 309px;overflow-y: auto;">
                <li><a href="#" data-id="0" data-amount="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.balance_cache', ''); ?>">Наличные</a></li>
                <?php echo $siteData->globalDatas['view::_shop/client/attorney/list/list']; ?>
            </ul>
        </div>
    </div>
</div>