<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<?php if($siteData->operation->getIsAdmin()){ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Дата
            </label>
        </div>
        <div class="col-md-3">
            <input name="created_at" type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['created_at']); ?>" required <?php if($isShow){ ?>readonly<?php } ?>>
        </div>
    </div>
<?php } ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Продукция
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_product_id" name="shop_product_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
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
        <input data-type="money" data-fractional-length="3" name="quantity" required type="phone" class="form-control" placeholder="Кол-во" value="<?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3); ?>" required <?php if($isShow || ($data->values['shop_car_tare_id'] > 0 && !$siteData->operation->getIsAdmin())){ ?>readonly<?php } ?>>
    </div>
    <?php if($data->values['shop_car_tare_id'] > 0){ ?>
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Машина
            </label>
        </div>
        <div class="col-md-3">
            <input name="shop_car_tare_id" value="<?php echo $data->values['shop_car_tare_id']; ?>" style="display: none">
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
        <select id="shop_storage_id" name="shop_storage_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
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
        <select id="shop_turn_place_id" name="shop_turn_place_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
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
        <select id="asu_operation_id" name="asu_operation_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/operation/list/list']; ?>
        </select>
    </div>
</div>
<?php } ?>
<?php if(!$isShow){ ?>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
<?php } ?>