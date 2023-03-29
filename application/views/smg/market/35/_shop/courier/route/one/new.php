

<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Курьер
    </label>
    <div class="col-md-10">
        <select id="shop_courier_id" name="shop_courier_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/courier/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Первая точка
    </label>
    <div class="col-md-4">
        <select id="shop_courier_address_id" name="shop_courier_address_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/courier/address/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Дата
    </label>
    <div class="col-md-4">
        <input name="date" type="datetime"  date-type="date"  class="form-control" placeholder="Дата"  >
    </div>
    <label class="col-md-2 control-label">
        Кол-во точек
    </label>
    <div class="col-md-4">
        <input name="quantity_points" type="phone" class="form-control" placeholder="Количество точек в маршруте"  >
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Цена
    </label>
    <div class="col-md-4">
        <input name="price_point" type="text" class="form-control" placeholder="Цена"  >
    </div>
    <label class="col-md-2 control-label">
        Зарплата
    </label>
    <div class="col-md-4">
        <input name="wage" type="text" class="form-control" placeholder="Зарплата"  >
    </div>
</div>
<div class="form-group">
    <label class="col-md-12 text-center" style="font-size: 18px">
        Маршрут
    </label>
    <div class="col-md-3">
        Расстояние (км)
        <input name="distance" type="text" class="form-control" placeholder="Расстояние (км)"  >
    </div>
    <div class="col-md-3">
        Время (сек.)
        <input name="seconds" type="text" class="form-control" placeholder="Время (сек.)"  >
    </div>
    <div class="col-md-3">
        Цена (км)
        <input name="price_km" type="text" class="form-control" placeholder="Цена (км)"  >
    </div>
    <div class="col-md-3">
        Стоимость
        <input name="amount" type="text" class="form-control" placeholder="Стоимость"  >
    </div>
</div>
<div class="form-group">
    <label class="col-md-12 text-center" style="font-size: 18px">
        Среднее
    </label>
    <label class="col-md-2 control-label">
        Расстояние (км)
    </label>
    <div class="col-md-3">
        <input name="mean_point_distance_km" type="text" class="form-control" placeholder="Расстояние (км)"  >
    </div>
    <label class="col-md-2 control-label">
        Время (сек.)
    </label>
    <div class="col-md-3">
        <input name="mean_point_second" type="text" class="form-control" placeholder="Время (сек.)"  >
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>