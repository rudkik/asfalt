<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Продукция
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_product_id" name="shop_product_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
        </select>
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
        <input data-type="money" data-fractional-length="3" name="quantity" type="phone" class="form-control" placeholder="Кол-во" value="<?php echo $quantity = Request_RequestParams::getParamFloat('quantity'); ?>" <?php if($quantity > 0){ echo 'readonly';} ?>  required>
    </div>
    <?php if(Request_RequestParams::getParamInt('shop_car_tare_id') > 0){ ?>
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Машина
            </label>
        </div>
        <div class="col-md-3">
            <input name="tarra" value="<?php echo Request_RequestParams::getParamFloat('tare'); ?>" style="display: none">
            <input name="shop_car_tare_id" value="<?php echo Request_RequestParams::getParamInt('shop_car_tare_id'); ?>" style="display: none">
            <select id="shop_car_tare_id" class="form-control select2" disabled required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/car/tare/list/list']; ?>
            </select>
        </div>
    <?php } ?>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Склад
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_storage_id" name="shop_storage_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/storage/list/list']; ?>
        </select>
    </div>
</div>
<?php if($siteData->interfaceID != Model_Ab1_Shop_Operation::RUBRIC_ZHBIBC){ ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Место производства
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_turn_place_id" name="shop_turn_place_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/turn/place/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Оператор АСУ
        </label>
    </div>
    <div class="col-md-3">
        <select id="asu_operation_id" name="asu_operation_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/operation/list/list']; ?>
        </select>
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
