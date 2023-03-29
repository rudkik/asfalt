<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        № заказа
    </label>
    <div class="col-md-4">
        <input name="old_id" type="text" class="form-control" placeholder="№ заказа" value="<?php echo $data->values['old_id']; ?>">
    </div>
    <label class="col-md-2 control-label">
        Дата создания
    </label>
    <div class="col-md-4">
        <input name="approve_source_at" type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['approve_source_at']); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Компания
    </label>
    <div class="col-md-4">
        <select data-type="select2" id="shop_company_id" name="shop_company_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php  echo $siteData->globalDatas['view::_shop/company/list/list']; ?>
        </select>
    </div>
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Источник
    </label>
    <div class="col-md-4">
        <select data-type="select2" id="shop_source_id" name="shop_source_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/source/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Способ оплаты
    </label>
    <div class="col-md-4">
        <select data-type="select2" id="shop_bill_payment_type_id" name="shop_bill_payment_type_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php  echo $siteData->globalDatas['view::_shop/bill/payment-type/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Статус источника
    </label>
    <div class="col-md-4">
        <select data-type="select2" id="shop_bill_status_source_id" name="shop_bill_status_source_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php  echo $siteData->globalDatas['view::_shop/bill/status/source/list/list']; ?>
        </select>
    </div>
    <label class="col-md-2 control-label">
        Стадия источника
    </label>
    <div class="col-md-4">
        <select data-type="select2" id="shop_bill_state_source_id" name="shop_bill_state_source_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php  echo $siteData->globalDatas['view::_shop/bill/state/source/list/list']; ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Способ доставки
    </label>
    <div class="col-md-4">
        <select data-type="select2" id="shop_bill_delivery_id" name="shop_bill_delivery_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php  echo $siteData->globalDatas['view::_shop/bill/delivery/type/list/list']; ?>
        </select>
    </div>
    <label class="col-md-2 control-label">
        Стоимость доставки
    </label>
    <div class="col-md-4">
        <input name="delivery_amount" type="text" class="form-control" placeholder="Стоимость доставки" value="<?php echo $data->values['delivery_amount']; ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Планируется доставка
    </label>
    <div class="col-md-4">
        <input name="delivery_plan_at" type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['delivery_plan_at']); ?>">
    </div>
    <label class="col-md-2 control-label">
        Фактическая доставка
    </label>
    <div class="col-md-4">
        <input name="delivery_at" type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['delivery_at']); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-10"><b>Покупатель</b></div>
    <input name="is_buyer" value="1" style="display: none">
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Фамилия
    </label>
    <div class="col-md-4">
        <input name="buyer_lastname" type="text" class="form-control" placeholder="Фамилия" value="<?php echo $data->getElementValue('shop_buyer_id', 'lastName'); ?>">
    </div>
    <label class="col-md-2 control-label">
        Имя
    </label>
    <div class="col-md-4">
        <input name="buyer_firstname" type="text" class="form-control" placeholder="Имя" value="<?php echo $data->getElementValue('shop_buyer_id', 'firstName'); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Телефон
    </label>
    <div class="col-md-4">
        <input name="buyer_phone" type="text" class="form-control" placeholder="Телефон" value="<?php echo $data->getElementValue('shop_buyer_id', 'phone'); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-10"><b>Адрес</b></div>
    <input name="is_delivery" value="1" style="display: none">
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Город
    </label>
    <div class="col-md-4">
        <input name="delivery_city_name" type="text" class="form-control" placeholder="Город" value="<?php echo $data->getElementValue('shop_bill_delivery_id', 'city_name'); ?>">
    </div>
    <label class="col-md-2 control-label">
        Улица
    </label>
    <div class="col-md-4">
        <input name="delivery_street" type="text" class="form-control" placeholder="Улица" value="<?php echo $data->getElementValue('shop_bill_delivery_id', 'street'); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Дом
    </label>
    <div class="col-md-4">
        <input name="delivery_house" type="text" class="form-control" placeholder="Дом" value="<?php echo $data->getElementValue('shop_bill_delivery_id', 'house'); ?>">
    </div>
    <label class="col-md-2 control-label">
        Квартира
    </label>
    <div class="col-md-4">
        <input name="delivery_apartment" type="text" class="form-control" placeholder="Квартира" value="<?php echo $data->getElementValue('shop_bill_delivery_id', 'apartment'); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Широта
    </label>
    <div class="col-md-4">
        <input name="delivery_latitude" type="text" class="form-control" placeholder="Широта" value="<?php echo $data->getElementValue('shop_bill_delivery_id', 'latitude'); ?>">
    </div>
    <label class="col-md-2 control-label">
        Долгота
    </label>
    <div class="col-md-4">
        <input name="delivery_longitude" type="text" class="form-control" placeholder="Долгота" value="<?php echo $data->getElementValue('shop_bill_delivery_id', 'longitude'); ?>">
    </div>
</div>

<?php echo $siteData->globalDatas['view::_shop/bill/item/list/index']; ?>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
