<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Отправитель
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select id="shop_daughter_id" name="shop_daughter_id" class="form-control select2" required style="width: 100%;" disabled>
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/daughter/list/list']; ?>
            </select>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Материал
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select id="shop_material_id" name="shop_material_id" class="form-control select2" required style="width: 100%;" disabled>
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
            </select>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Получатель
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select id="shop_client_material_id" name="shop_client_material_id" class="form-control select2" required style="width: 100%;" disabled>
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/client/material/list/list']; ?>
            </select>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Владелец транспорта
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" required style="width: 100%;" disabled>
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/transport/company/list/list']; ?>
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
        <select id="shop_car_tare_id" name="shop_car_tare_id" class="form-control select2 text-number" required style="width: 100%;" disabled>
            <option value="0" data-id="0">Без значения</option>
            <?php if($siteData->action == 'clone') { ?>
                <?php
                $s = 'data-name="'.Request_RequestParams::getParamStr('number').'"';
                echo str_replace($s, $s.' selected', str_replace('selected', '', $siteData->replaceDatas['view::_shop/car/tare/list/list']));
                ?>
            <?php }else{ ?>
                <?php echo $siteData->globalDatas['view::_shop/car/tare/list/list']; ?>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            ФИО водителя
        </label>
    </div>
    <div class="col-md-3">
        <input name="shop_driver_name" type="text" class="form-control" placeholder="ФИО водителя" value="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_driver_id.name', ''), ENT_QUOTES); ?>" disabled>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            <?php if($siteData->action != 'clone') { ?>
                Вес
            <?php }else{ ?>
                Брутто
            <?php } ?>
        </label>
    </div>
    <div class="col-md-9">
        <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone"  class="text-number form-control" placeholder="Вес" required value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>" disabled>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Вес по накладной
        </label>
    </div>
    <div class="col-md-9">
        <input data-type="money" data-fractional-length="3" id="quantity_invoice" name="quantity_invoice" type="text" class="form-control" required placeholder="Вес по накладной" value="<?php echo Func::getNumberStr($data->values['quantity_invoice'], FALSE); ?>" readonly>
    </div>
</div>
