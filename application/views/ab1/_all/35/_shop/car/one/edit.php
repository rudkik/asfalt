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
            <?php if($isShow && $siteData->operation->getShopTableRubricID() != Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING){ ?>
                <input name="shop_client_id" value="<?php echo $data->values['shop_client_id']; ?>" style="display: none">
            <?php } ?>
            <select data-client="<?php echo $data->values['shop_client_id'];?>" data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                    data-attorney="#shop_client_attorney_id" data-contract="#shop_client_contract_id"
                    id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%"
                    data-date="<?php echo $data->values['created_at'];?>"
                    data-is-invoice-print="<?php echo Func::boolToStr(Func::_empty($data->getElementValue('shop_client_id', 'bin'))); ?>" data-cache="<?php echo $data->getElementValue('shop_client_id', 'balance_cache'); ?>" <?php if($isShow && $siteData->operation->getShopTableRubricID() != Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING){ ?>disabled<?php } ?>>
                <option value="<?php echo $data->values['shop_client_id']; ?>" selected><?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES); ?></option>
            </select>
            <?php if(!$isShow || $siteData->operation->getShopTableRubricID() == Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING){ ?>
                <span class="input-group-btn add-client">
                    <a href="" class="btn bg-purple btn-flat" data-toggle="modal" data-target="#dialog-client"><i class="fa fa-fw fa-plus"></i> Добавить клиента</a>
                </span>
            <?php } ?>
            <span class="input-group-btn"> <a class="btn btn-flat box-amount-p"><b id="client-amount" class="text-navy" style="font-size: 18px;"><?php echo Func::getPriceStr($siteData->currency, $amount, TRUE, FALSE); ?></b></a></span>
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
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Доставка
                </label>
            </div>
            <div class="col-md-9">
                <div class="input-group">
                    <?php if($isShow && $siteData->operation->getShopTableRubricID() != Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING){ ?>
                        <input name="shop_delivery_id" value="<?php echo $data->values['shop_delivery_id']; ?>" style="display: none">
                    <?php } ?>
                    <select id="shop_delivery_id" name="shop_delivery_id" data-delivery-quantity="<?php echo $data->values['delivery_quantity']; ?>" data-quantity="<?php echo $data->values['quantity']; ?>" class="form-control select2" required style="width: 100%;" <?php if($isShow && $siteData->operation->getShopTableRubricID() != Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING){ ?>disabled<?php } ?>>
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
                <div class="input-group">
                    <?php if(!$siteData->operation->getIsAdmin() && $data->values['shop_turn_place_id'] > 0  && $siteData->operation->getShopTableRubricID() != Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING){ ?>
                        <input id="shop_product_id" name="shop_product_id"  value="<?php echo $data->values['shop_product_id']; ?>" style="display: none">
                        <select class="form-control select2" required style="width: 100%;" disabled>
                            <option value="0" data-id="0">Без значения</option>
                            <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
                        </select>
                    <?php }else{ ?>
                        <?php if($isShow || ($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_EXIT && !$siteData->operation->getIsAdmin() && $siteData->operation->getShopTableRubricID() != Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING)){ ?>
                            <input name="shop_product_id" value="<?php echo $data->values['shop_product_id']; ?>" style="display: none">
                        <?php } ?>
                        <select id="shop_product_id" name="shop_product_id" class="form-control select2" required style="width: 100%;" <?php if(($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_EXIT) && !$siteData->operation->getIsAdmin() && $siteData->operation->getShopTableRubricID() != Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING){ echo 'disabled'; }?> <?php if($isShow){ ?>disabled<?php } ?>>
                            <option value="0" data-id="0">Без значения</option>
                            <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
                        </select>
                    <?php } ?>
                    <span class="input-group-btn"> <a class="btn btn-flat box-amount-p"><span id="product-price" class="text-navy" style="font-size: 16px;"><?php echo Func::getPriceStr($siteData->currency, $amount, TRUE, FALSE); ?></span></a></span>
                </div>
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
                <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone" class="form-control" placeholder="Введите заявленное количество продукции" required value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>" <?php if(($data->values['tarra'] > 0) && (($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT) || (($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_CASH_EXIT))) && (!$siteData->operation->getIsAdmin())){ echo 'readonly'; }?> <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
        </div>

        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Сумма
                </label>
            </div>
            <div class="col-md-9">
                <div class="input-group">
                    <input id="total" data-value="<?php echo $data->values['amount'] + $data->values['delivery_amount']; ?>" data-amount="<?php echo $data->values['amount'] + $data->values['delivery_amount']; ?>" data-service-amount="<?php echo $data->values['amount_service']; ?>"  type="text" class="form-control" placeholder="Сумма" value="<?php echo Func::getNumberStr($data->values['amount'] +  + $data->values['delivery_amount'], true); ?>" disabled>
                    <span class="input-group-btn"> <a class="btn btn-flat box-amount-p"><b id="car-amount" class="text-red" style="font-size: 18px;"></b></a></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div style="min-height: 152px;" class="col-md-3">
        <div class="row">
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="is_debt" value="0" style="display: none">
                    <input id="is_debt" name="is_debt" <?php if (Arr::path($data->values, 'is_debt', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){ ?>disabled<?php } ?>>
                    В долг
                </label><br>
                <label class="span-checkbox">
                    <input name="is_charity" value="0" style="display: none">
                    <input id="is_charity" name="is_charity" data-id="1" <?php if (Arr::path($data->values, 'is_charity', '0') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){ ?>disabled<?php } ?>>
                    Благотворительность
                </label>
            </div>
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="is_balance" value="0" style="display: none">
                    <input name="is_balance"  <?php if (Arr::path($data->values, 'is_balance', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){ ?>disabled<?php } ?>>
                    Проверять по балансу
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
        <div class="row">
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="options[is_not_overload]" value="0" style="display: none">
                    <input name="options[is_not_overload]" <?php if (Arr::path($data->values['options'], 'is_not_overload', '') == 1){ ?> value="1" checked <?php }else{?> value="0" <?php }?> type="checkbox" class="minimal" <?php if($isShow){ ?>disabled<?php } ?>>
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
                <a href="javascript:deleteSelectPayment()"> <i class="fa fa-fw fa-remove text-red"></i></a>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="col-md-3 record-title">
        <label>Доверенность</label>
    </div>
    <div class="col-md-3">
        <?php if($isShow){ ?>
            <input name="shop_client_attorney_id" value="<?php echo $data->values['shop_client_attorney_id']; ?>" style="display: none">
        <?php } ?>
        <select data-contract="#shop_client_contract_id" data-product="#shop_product_id" id="shop_client_attorney_id" name="shop_client_attorney_id"
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
        <?php if($isShow){ ?>
            <input name="shop_client_contract_id" value="<?php echo $data->values['shop_client_contract_id']; ?>" style="display: none">
        <?php } ?>
        <select id="shop_client_contract_id" name="shop_client_contract_id" data-contract-id="<?php echo $data->values['shop_client_contract_id']; ?>" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Без договора</option>
            <?php echo $siteData->globalDatas['view::_shop/client/contract/list/list']; ?>
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
<?php if($siteData->operation->getIsAdmin() && $data->values['is_exit'] == 1){ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Место производства
            </label>
        </div>
        <div class="col-md-3">
            <?php if($isShow){ ?>
                <input name="shop_turn_place_id" value="<?php echo $data->values['shop_turn_place_id']; ?>" style="display: none">
            <?php } ?>
            <select id="shop_turn_place_id" name="shop_turn_place_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/turn/place/list/list']; ?>
            </select>
        </div>
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Склад забора
            </label>
        </div>
        <div class="col-md-3">
            <?php if($isShow){ ?>
                <input name="shop_storage_id" value="<?php echo $data->values['shop_storage_id']; ?>" style="display: none" <?php if($isShow){ ?>disabled<?php } ?>>
            <?php } ?>
            <select id="shop_storage_id" name="shop_storage_id" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/storage/list/list']; ?>
            </select>
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Транспортная компания
            </label>
        </div>
        <div class="col-md-3">
            <?php if($isShow){ ?>
                <input name="shop_transport_company_id" value="<?php echo $data->values['shop_transport_company_id']; ?>" style="display: none">
            <?php } ?>
            <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/transport/company/list/list']; ?>
            </select>
        </div>
    </div>
<?php } ?>
<?php if($data->values['is_public'] == 0){?>
<?php $files = Arr::path($data->values['options'], 'files', array()); ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Примечание
            </label>
        </div>
        <div class="col-md-9">
            <textarea name="text" class="form-control" placeholder="Примечание" <?php if($isShow){ ?>readonly<?php } ?>><?php echo htmlspecialchars(Arr::path($data->values, 'text', ''), ENT_QUOTES);?></textarea>
        </div>
    </div>
    <?php if(count($files) > 0){ ?>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Подтверждающие файлы
                </label>
            </div>
            <div class="col-md-9">
                <input name="options[files][]" value="" style="display: none">
                <table class="table table-hover table-db table-tr-line" >
                    <tr>
                        <th>Файлы</th>
                        <th class="width-90"></th>
                    </tr>
                    <tbody id="files">
                    <?php
                    $i = -1;
                    foreach ($files as $file){
                        $i++;
                        if(empty($file)){
                            continue;
                        }
                        ?>
                        <tr>
                            <td>
                                <a target="_blank" href="<?php echo Arr::path($file, 'file', ''); ?>"><?php echo Arr::path($file, 'name', ''); ?></a>
                                <input name="options[files][<?php echo $i; ?>][file]" value="<?php echo Arr::path($file, 'file', ''); ?>" style="display: none">
                                <input name="options[files][<?php echo $i; ?>][name]" value="<?php echo Arr::path($file, 'name', ''); ?>" style="display: none">
                                <input name="options[files][<?php echo $i; ?>][size]" value="<?php echo Arr::path($file, 'size', ''); ?>" style="display: none">
                            </td>
                            <td>
                                <ul class="list-inline tr-button ">
                                    <li class="tr-remove"><a href="#" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                </ul>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <?php if ($siteData->operation->getIsAdmin()){ ?>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-danger" onclick="addElement('new-file', 'files', true);">Добавить файл</button>
                    </div>
                    <div id="new-file" data-index="0">
                        <!--
                        <tr>
                            <td>
                                <div class="file-upload" data-text="Выберите файл" placeholder="Выберите файл">
                                    <input type="file" name="options[files][_#index#]" >
                                </div>
                            </td>
                            <td>
                                <ul class="list-inline tr-button delete">
                                    <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="#" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                </ul>
                            </td>
                        </tr>
                        -->
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<?php if($isShow){ ?>
    <div class="row">
        <div class="modal-footer text-center">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/talonxls', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> Талон</a>
            <?php if($siteData->operation->getIsAdmin() || $siteData->operation->getShopTableRubricID() == Model_Ab1_Shop_Operation::RUBRIC_SBYT){ ?>
                <a href="<?php echo Func::getFullURL($siteData, '/shopreport/talon_left_xls', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> Талон весовой</a>
            <?php } ?>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/car_ttn', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> ТТН</a>
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
            <?php if($siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_CASH && empty($data->values['shop_payment_id']) && $siteData->operation->values['shop_cashbox_id'] > 0 ){ ?>
                <a href="javascript:showAddNewPayment()" class="btn bg-purple btn-flat pull-left"><i class="fa fa-fw fa-money"></i> Добавить оплату</a>
            <?php } ?>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/talonxls', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> Талон</a>
            <?php if($siteData->operation->getIsAdmin() || $siteData->operation->getShopTableRubricID() == Model_Ab1_Shop_Operation::RUBRIC_SBYT){ ?>
                <a href="<?php echo Func::getFullURL($siteData, '/shopreport/talon_weighted_xls', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> Талон весовой</a>
            <?php } ?>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/car_ttn', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> ТТН</a>
            <?php if(((intval($data->values['shop_payment_id'])) > 0)){ ?>
                <a href="<?php echo Func::getFullURL($siteData, '/shopreport/orderxls_payment', array(), array('id' => $data->values['shop_payment_id'])); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> Счет</a>
                <a href="<?php echo Func::getFullURL($siteData, '/shopreport/pkoxls_payment', array(), array('id' => $data->values['shop_payment_id'])); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-list-alt"></i> ПКО</a>
            <?php } ?>
            <?php if($data->values['is_public'] == 1){?>
                <?php if(($data->values['tarra'] > 0) && (($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_CASH_EXIT))){ ?>
                    <button type="button" class="btn btn-primary pull-left" onclick="submitRelease('shopcar');">Выпустить</button>
                <?php } ?>
                <button type="button" class="btn btn-primary pull-right" onclick="submitCar('shopcar');">Сохранить</button>
                <button type="button" class="btn btn-primary pull-right" onclick="$('#is_close').val(0); submitCar('shopcar');">Применить</button>
            <?php }elseif ($siteData->operation->getIsAdmin()){ ?>
                <button type="button" class="btn btn-primary pull-right" onclick="submitCar('shopcar');">Сохранить</button>
                <button type="button" class="btn btn-primary pull-right" onclick="$('#is_close').val(0); submitCar('shopcar');">Применить</button>
            <?php } ?>
        </div>
    <?php }else{ ?>
        <div hidden>
            <input id="shop_payment_id" name="shop_payment_id" value="0">
            <input id="shop_turn_id" name="shop_turn_id" value="<?php echo Model_Ab1_Shop_Turn::TURN_WEIGHTED_ENTRY; ?>">
            <input id="is_close" name="is_close" value="1">
        </div>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitCar('shopcar');">Применить</button>
            <button type="button" class="btn btn-primary" onclick="submitCar('shopcar');">Сохранить</button>
        </div>
    <?php } ?>
</div>
<script>
    $('#shop_client_id, #shop_client_contract_id, #is_charity').change(function () {
        $('#quantity').trigger('change');
    });

    $(function () {
        initClientAttorneyNew(
            $('#shop_delivery_id'),
            $('#delivery_amount'),
            $('#delivery_km'),
            $('#shop_product_id'),
            $('#product-price'),
            '#quantity',
            $('#total'),
            $('#car-amount'),
            $('[name="shop_client_id"]'),
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
        $('#dialog-payment #modal_shop_product_id').attr('value', $('#shop_product_id').val());
        $('#dialog-payment #modal_quantity').attr('value', $('#quantity').val());

        $('#dialog-payment [name="amount"]').valNumber($('#total').valNumber() - $('#delivery_amount').valNumber());
        $('#dialog-payment').modal('show');
    }
    function submitRelease(id) {
        $('#is_exit').val(1);
        $('#is_exit').attr('value', 1);
        $('#shop_turn_id').val(<?php echo Model_Ab1_Shop_Turn::TURN_EXIT; ?>);
        $('#shop_turn_id').attr('value', <?php echo Model_Ab1_Shop_Turn::TURN_EXIT; ?>);

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

        var deliveryAmount = Number($('#delivery_amount').valNumber());
        if($('#is_debt').val() != 1 && $('#shop_client_attorney_id').val() > 0){
            var clientAmount = Number($('#shop_client_attorney_id').data('amount'));
            var total = Number($('#total').valNumber());
            var amount = total + deliveryAmount;
            if(clientAmount < amount - $('#total').data('value')){
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
<?php } ?>