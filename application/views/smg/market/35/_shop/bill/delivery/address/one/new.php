<div class="form-group">
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
        Город
    </label>
    <div class="col-md-4">
        <input name="city_name" type="text" class="form-control" placeholder="Город" >
    </div>
    <label class="col-md-2 control-label">
        Улица
    </label>
    <div class="col-md-4">
        <input name="street" type="text" class="form-control" placeholder="Улица" >
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Дом
    </label>
    <div class="col-md-4">
        <input name="house" type="text" class="form-control" placeholder="Дом" >
    </div>
    <label class="col-md-2 control-label">
        Квартира
    </label>
    <div class="col-md-4">
        <input name="apartment" type="text" class="form-control" placeholder="Квартира">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Широта
    </label>
    <div class="col-md-4">
        <input name="latitude" type="text" class="form-control" placeholder="Широта" >
    </div>
    <label class="col-md-2 control-label">
        Долгота
    </label>
    <div class="col-md-4">
        <input name="longitude" type="text" class="form-control" placeholder="Долгота" >
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Примечание
    </label>
    <div class="col-md-10">
        <textarea name="text" rows="5" placeholder="Примечание" class="form-control"></textarea>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Ссылка на Yandex-карту
    </label>
    <div class="col-md-10">
        <textarea name="yandex" rows="5" placeholder="Ссылка на Yandex-карту" class="form-control"></textarea>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>