<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Поставщик
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_boxcar_client_id" name="shop_boxcar_client_id" class="form-control select2" required style="width: 100%;">
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
        <select id="shop_client_contract_id" name="shop_client_contract_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
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
        <select id="shop_raw_id" name="shop_raw_id" class="form-control select2" required style="width: 100%;">
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
        <select id="shop_boxcar_departure_station_id" name="shop_boxcar_departure_station_id" class="form-control select2" required style="width: 100%;">
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
        <select id="shop_boxcar_factory_id" name="shop_boxcar_factory_id" class="form-control select2" required style="width: 100%;">
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
        <input name="contract_number" type="text" class="form-control" placeholder="№ договора">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дата договора
        </label>
    </div>
    <div class="col-md-3">
        <input name="contract_date" type="datetime" class="form-control" placeholder="Дата договора">
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
        <input name="tracker" type="text" class="form-control" placeholder="Код отслеживания">
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
        <input name="date_shipment" type="datetime"  class="form-control">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Общий вес (т)
        </label>
    </div>
    <div class="col-md-3">
        <input id="quantity_total" type="text" class="form-control" placeholder="Общий вес (т)" readonly>
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
        <input data-type="money" data-fractional-length="0" id="downtime_permitted" name="downtime_permitted" type="text" class="form-control" placeholder="Допустимый простой (час)">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Штраф простоя (за день)
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" id="fine_day" name="fine_day" type="text" class="form-control" placeholder="Штраф простоя (за день)">
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
        <textarea name="text" class="form-control" placeholder="Примечание"></textarea>
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
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" onclick="addBoxcar('new-boxcar', 'boxcars', true);">Добавить вагон</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<script>
    $('#shop_boxcar_client_id').change(function () {
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