<?php $isNotEdit = FALSE && $data->values['is_exit'] || Request_RequestParams::getParamBoolean('is_show'); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Поставщик
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_boxcar_client_id" name="shop_boxcar_client_id" class="form-control select2" required style="width: 100%;" <?php if($isNotEdit){echo 'disabled';}?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/boxcar/client/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Договор
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_client_contract_id" name="shop_client_contract_id" class="form-control select2" required style="width: 100%;" <?php if($isNotEdit){echo 'disabled';}?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/client/contract/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Сырье
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_raw_id" name="shop_raw_id" class="form-control select2" required style="width: 100%;" <?php if($isNotEdit){echo 'disabled';}?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/raw/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Станция отправления
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_boxcar_departure_station_id" name="shop_boxcar_departure_station_id" class="form-control select2" required style="width: 100%;" <?php if($isNotEdit){echo 'disabled';}?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/boxcar/departure/station/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Завод-изготовитель
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_boxcar_factory_id" name="shop_boxcar_factory_id" class="form-control select2" required style="width: 100%;" <?php if($isNotEdit){echo 'disabled';}?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/boxcar/factory/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            № договора
        </label>
    </div>
    <div class="col-md-3">
        <input name="contract_number" type="text" class="form-control" placeholder="№ договора" value="<?php echo htmlspecialchars(Arr::path($data->values, 'contract_number', ''), ENT_QUOTES);?>" <?php if($isNotEdit){echo 'readonly';}?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дата договора
        </label>
    </div>
    <div class="col-md-3">
        <input name="contract_date" type="datetime" date-type="date" class="form-control" placeholder="Дата договора" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($data->values, 'contract_date', ''));?>" <?php if($isNotEdit){echo 'readonly';}?>>
    </div>
</div>
<div class="row record-input record-list" style="display: none">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Код отслеживания
        </label>
    </div>
    <div class="col-md-3">
        <input name="tracker" type="text" class="form-control" placeholder="Код отслеживания" value="<?php echo htmlspecialchars(Arr::path($data->values, 'tracker', ''), ENT_QUOTES);?>" <?php if($isNotEdit){echo 'readonly';}?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дата отгрузки
        </label>
    </div>
    <div class="col-md-3">
        <input name="date_shipment" type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($data->values, 'date_shipment', ''));?>" <?php if($isNotEdit){echo 'readonly';}?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Общий вес (т)
        </label>
    </div>
    <div class="col-md-3">
        <input id="quantity_total" type="text" class="form-control" placeholder="Общий вес (т)" value="<?php echo htmlspecialchars(Arr::path($data->values, 'quantity', ''), ENT_QUOTES);?>" readonly>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Допустимый простой (час)
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="0" id="downtime_permitted" name="downtime_permitted" type="text" class="form-control" placeholder="Допустимый простой (час)" value="<?php echo htmlspecialchars(floatval(Arr::path($data->values, 'downtime_permitted', '')), ENT_QUOTES);?>" <?php if($isNotEdit){echo 'readonly';}?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Штраф простоя (за день)
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" id="fine_day" name="fine_day" type="text" class="form-control" placeholder="Штраф простоя (за день)" value="<?php echo htmlspecialchars(floatval(Arr::path($data->values, 'fine_day', '')), ENT_QUOTES);?>" <?php if($isNotEdit){echo 'readonly';}?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент, для которого поставка
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_client_id" name="shop_client_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/client/list/list']; ?>
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
        <textarea name="text" class="form-control" placeholder="Примечание" <?php if($isNotEdit){echo 'readonly';}?>><?php echo htmlspecialchars(Arr::path($data->values, 'text', ''), ENT_QUOTES);?></textarea>
    </div>
</div>
<div class="row record-input record-list" style="margin-top: 30px">
    <div class="col-md-3 record-title">
        <h3 class="pull-right">
            Вагоны
        </h3>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/boxcar/list/item'];?>
        <?php if(!$isNotEdit){?>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" onclick="addBoxcar('new-boxcar', 'boxcars', true);">Добавить вагон</button>
            </div>
        <?php }?>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <?php if(!$isNotEdit){?>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        <?php }?>
        <a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/index'); ?>" class="btn btn-primary">Закрыть</a>
    </div>
</div>
<script>
    $('#fshop_boxcar_client_id').change(function () {
        var  shopClientID = $(this).val();
        // контракт
        jQuery.ajax({
            url: '/<?php echo $siteData->actionURLName;?>/shopclientcontract/select_options',
            data: ({
                'shop_client_id': (shopClientID),
                'client_contract_type_id': (<?php echo Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_RAW;?>),
                'is_basic': (1),
            }),
            type: "POST",
            success: function (data) {
                var contractEl = $('#shop_client_contract_id');
                contractEl.select2('destroy').empty().html(data).select2().val(0);

                if (contractEl.children('option[value="' + v + '"]').length > 0) {
                    contractEl.val(v).trigger('change');
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });
</script>