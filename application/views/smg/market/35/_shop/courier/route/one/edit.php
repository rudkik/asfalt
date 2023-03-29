<div class="row">
    <label class="col-md-2 control-label" style="padding-top: 33px;"></label>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Дата</label>
                    <input type="datetime" date-type="date" class="form-control" placeholder="Дата" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Начало</label>
                    <input type="datetime" date-type="datetime" class="form-control" placeholder="Дата" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['from_at']); ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Окончание</label>
                    <input type="datetime" date-type="datetime" class="form-control" placeholder="Дата" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['to_at']); ?>" readonly>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Курьер
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" placeholder="Курьер" value="<?php echo htmlspecialchars($data->getElementValue('shop_courier_id'), ENT_QUOTES); ?>" readonly>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Первая точка
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" placeholder="Первая точка" value="<?php echo htmlspecialchars($data->getElementValue('shop_courier_address_id_from'), ENT_QUOTES); ?>" readonly>
    </div>
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Последняя точка
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" placeholder="Последняя точка" value="<?php echo htmlspecialchars($data->getElementValue('shop_courier_address_id_to'), ENT_QUOTES); ?>" readonly>
    </div>
</div>
<div class="row">
    <label class="col-md-2 control-label" style="padding-top: 33px;">
        Маршрут
    </label>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Расстояние (км)</label>
                    <input name="distance" type="text" class="form-control" placeholder="Расстояние (км)" value="<?php echo Func::getNumberStr($data->values['distance'], false); ?>" >
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Цена (за км)</label>
                    <input name="price_km" type="text" class="form-control" placeholder="Цена (за км)" value="<?php echo Func::getNumberStr($data->values['price_km'], false); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Стоимость</label>
                    <input name="amount" type="text" class="form-control" placeholder="Стоимость" value="<?php echo Func::getNumberStr($data->values['amount'], false); ?>" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Время (сек.)</label>
                    <input type="text" class="form-control" placeholder="Время (сек.)" value="<?php echo Func::getNumberStr($data->values['seconds'], false); ?>" readonly>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <label class="col-md-2 control-label" style="padding-top: 33px;">
        Кол-во точек
    </label>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Закупы</label>
                    <input type="text" class="form-control" placeholder="Закупы" value="<?php echo $data->values['quantity_pre_order_points']; ?>" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Заказы</label>
                    <input type="text" class="form-control" placeholder="Заказы" value="<?php echo $data->values['quantity_bill_points']; ?>" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Возвраты</label>
                    <input name="quantity_return_points" type="text" class="form-control" placeholder="Возвраты" value="<?php echo $data->values['quantity_return_points']; ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Прочие</label>
                    <input name="quantity_other_points" type="text" class="form-control" placeholder="Прочие" value="<?php echo $data->values['quantity_other_points']; ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <label class="col-md-2 control-label" style="padding-top: 33px;">
        Зарплата
    </label>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Кол-во точек</label>
                    <input type="text" class="form-control" placeholder="Кол-во точек" value="<?php echo htmlspecialchars($data->values['quantity_points'], ENT_QUOTES); ?>" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Цена (за точку)</label>
                    <input name="price_point" type="text" class="form-control" placeholder="Цена (за точку)" value="<?php echo Func::getNumberStr($data->values['price_point'], false); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Зарплата</label>
                    <input type="text" class="form-control" placeholder="Зарплата" value="<?php echo Func::getNumberStr($data->values['wage'], false); ?>" readonly>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <label class="col-md-2 control-label" style="padding-top: 33px;">
        Среднее
    </label>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Расстояние к точки (км)</label>
                    <input type="text" class="form-control" placeholder="Расстояние к точки (км)" value="<?php echo Func::getNumberStr($data->values['mean_point_distance_km'], false); ?>" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group margin-lr-0">
                    <label class="control-label">Время к точки (сек.)</label>
                    <input type="text" class="form-control" placeholder="Время к точки (сек.)" value="<?php echo Func::getNumberStr($data->values['mean_point_second'], false); ?>" readonly>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <b style="font-size: 16px;">Завершенные точки</b>
    </label>
    <div class="col-md-10">
        <?php echo $siteData->globalDatas['view::_shop/courier/route/item/list/index']; ?>
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
