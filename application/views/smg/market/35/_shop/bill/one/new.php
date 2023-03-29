<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        № заказа
    </label>
    <div class="col-md-4">
        <input name="old_id" type="text" class="form-control" placeholder="№ заказа">
    </div>
    <label class="col-md-2 control-label">
        Дата создания
    </label>
    <div class="col-md-4">
        <input name="approve_source_at" type="datetime" date-type="datetime" class="form-control" value="<?php echo date('d.m.Y H:i'); ?>">
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
        <select data-type="select2" id="shop_bill_delivery_type_id" name="shop_bill_delivery_type_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php  echo $siteData->globalDatas['view::_shop/bill/delivery/type/list/list']; ?>
        </select>
    </div>
    <label class="col-md-2 control-label">
        Стоимость доставки
    </label>
    <div class="col-md-4">
        <input name="delivery_amount" type="text" class="form-control" placeholder="Стоимость доставки">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Планируется доставка
    </label>
    <div class="col-md-4">
        <input name="delivery_plan_at" type="datetime" date-type="datetime" class="form-control">
    </div>
    <label class="col-md-2 control-label">
        Фактическая доставка
    </label>
    <div class="col-md-4">
        <input name="delivery_at" type="datetime" date-type="datetime" class="form-control">
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
        <input name="buyer_lastname" type="text" class="form-control" placeholder="Фамилия">
    </div>
    <label class="col-md-2 control-label">
        Имя
    </label>
    <div class="col-md-4">
        <input name="buyer_firstname" type="text" class="form-control" placeholder="Имя">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Телефон
    </label>
    <div class="col-md-4">
        <input name="buyer_phone" type="text" class="form-control" placeholder="Телефон" required>
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
        <input name="delivery_city_name" type="text" class="form-control" placeholder="Город">
    </div>
    <label class="col-md-2 control-label">
        Улица
    </label>
    <div class="col-md-4">
        <input name="delivery_street" type="text" class="form-control" placeholder="Улица">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Дом
    </label>
    <div class="col-md-4">
        <input name="delivery_house" type="text" class="form-control" placeholder="Дом">
    </div>
    <label class="col-md-2 control-label">
        Квартира
    </label>
    <div class="col-md-4">
        <input name="delivery_apartment" type="text" class="form-control" placeholder="Квартира">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Широта
    </label>
    <div class="col-md-4">
        <input name="delivery_latitude" type="text" class="form-control" placeholder="Широта">
    </div>
    <label class="col-md-2 control-label">
        Долгота
    </label>
    <div class="col-md-4">
        <input name="delivery_longitude" type="text" class="form-control" placeholder="Долгота">
    </div>
</div>

<?php echo $siteData->globalDatas['view::_shop/bill/item/list/index']; ?>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
