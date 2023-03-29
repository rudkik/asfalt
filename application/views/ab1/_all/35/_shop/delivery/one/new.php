<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Показать
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="Название" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название в 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="name_1c" type="text" class="form-control" placeholder="Название в 1С">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название на сайте
        </label>
    </div>
    <div class="col-md-3">
        <input name="name_site" type="text" class="form-control" placeholder="Название на сайте">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>Группа в 1С</label>
    </div>
    <div class="col-md-3">
        <select id="shop_delivery_group_id" name="shop_delivery_group_id" class="form-control select2" style="width: 100%;">
            <option data-id="0" value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/delivery/group/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>Рубрика продуктов</label>
    </div>
    <div class="col-md-3">
        <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" style="width: 100%;">
            <option data-id="0" value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>Продукт</label>
    </div>
    <div class="col-md-9">
        <select id="shop_product_id" name="shop_product_id" class="form-control select2" style="width: 100%;">
            <option data-id="0" value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Расстояние (км)
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="3" name="km" type="phone" class="form-control" placeholder="Расстояние (км)" required>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Цена
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" name="price" type="phone" class="form-control" placeholder="Цена" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>Тип доставки</label>
    </div>
    <div class="col-md-3">
        <select id="delivery_type_id" name="delivery_type_id" class="form-control select2" style="width: 100%;">
            <option data-id="0" value="0">Оплата за рейс</option>
            <?php echo $siteData->globalDatas['view::deliverytype/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Мин. вес при цене за вес и км
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" name="min_quantity" type="text" class="form-control" placeholder="Минимальный вес при цене за вес и км">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <h4 class="text-blue">Для прайс-листа</h4>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Расстояние
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="3" name="options[distance]" type="text" class="form-control" placeholder="Расстояние">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Время
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" name="options[time]" type="text" class="form-control" placeholder="Время">
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>

