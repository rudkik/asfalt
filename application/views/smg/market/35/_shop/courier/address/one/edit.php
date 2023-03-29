<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Курьер
    </label>
    <div class="col-md-10">
        <select id="shop_courier_id" data-type="select2" name="shop_courier_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/courier/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Город
    </label>
    <div class="col-md-4">
        <input name="city_name" type="text" class="form-control" placeholder="Город" value="<?php echo htmlspecialchars($data->values['city_name'], ENT_QUOTES); ?>">
    </div>
    <label class="col-md-2 control-label">
        Улица
    </label>
    <div class="col-md-4">
        <input name="street" type="text" class="form-control" placeholder="Улица" value="<?php echo htmlspecialchars($data->values['street'], ENT_QUOTES); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Дом
    </label>
    <div class="col-md-4">
        <input name="house" type="text" class="form-control" placeholder="Дом" value="<?php echo htmlspecialchars($data->values['house'], ENT_QUOTES); ?>">
    </div>
    <label class="col-md-2 control-label">
        Квартира
    </label>
    <div class="col-md-4">
        <input name="apartment" type="text" class="form-control" placeholder="Квартира" value="<?php echo htmlspecialchars($data->values['apartment'], ENT_QUOTES); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Широта
    </label>
    <div class="col-md-4">
        <input name="latitude" type="text" class="form-control" placeholder="Широта" value="<?php echo htmlspecialchars($data->values['latitude'], ENT_QUOTES); ?>">
    </div>
    <label class="col-md-2 control-label">
        Долгота
    </label>
    <div class="col-md-4">
        <input name="longitude" type="text" class="form-control" placeholder="Долгота" value="<?php echo htmlspecialchars($data->values['longitude'], ENT_QUOTES); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Примечание
    </label>
    <div class="col-md-10">
        <textarea name="text" rows="5" placeholder="Примечание" class="form-control"><?php echo htmlspecialchars($data->values['text'], ENT_QUOTES); ?></textarea>
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
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
