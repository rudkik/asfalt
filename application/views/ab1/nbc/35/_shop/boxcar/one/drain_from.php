<div class="row">
    <div class="col-md-9">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Поставщик
                </label>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control"value="<?php echo htmlspecialchars($data->getElementValue('shop_boxcar_client_id'), ENT_QUOTES);?>" readonly>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    Сырье
                </label>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control"value="<?php echo htmlspecialchars($data->getElementValue('shop_raw_id'), ENT_QUOTES);?>" readonly>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    № вагона
                </label>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="№ вагона" value="<?php echo htmlspecialchars(Arr::path($data->values, 'number', ''), ENT_QUOTES);?>" readonly>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    Тоннаж
                </label>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Тоннаж" value="<?php echo htmlspecialchars(Arr::path($data->values, 'quantity', ''), ENT_QUOTES);?>" readonly>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Оператор ТУ НБЦ (Бригадир)
                </label>
            </div>
            <div class="col-md-3">
                <select id="brigadier_drain_from_shop_operation_id" name="brigadier_drain_from_shop_operation_id" class="form-control select2" style="width: 100%">
                    <option data-id="0" value="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/operation/list/brigadier'];?>
                </select>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Начало разгрузки
                </label>
            </div>
            <div class="col-md-3">
                <input name="date_drain_from" type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Arr::path($data->values, 'date_drain_from', ''));?>" >
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Место слива
                </label>
            </div>
            <div class="col-md-3">
                <select id="shop_raw_drain_chute_id" name="shop_raw_drain_chute_id" class="form-control select2" style="width: 100%">
                    <option data-id="0" value="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/raw/drain-chute/list/list'];?>
                </select>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Товарный оператор 1
                </label>
            </div>
            <div class="col-md-3">
                <select id="drain_from_shop_operation_id_1" name="drain_from_shop_operation_id_1" class="form-control select2" style="width: 100%">
                    <option data-id="0" value="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/operation/list/list_1'];?>
                </select>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Товарный оператор 2
                </label>
            </div>
            <div class="col-md-3">
                <select id="drain_from_shop_operation_id_2" name="drain_from_shop_operation_id_2" class="form-control select2" style="width: 100%">
                    <option data-id="0" value="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/operation/list/list_2'];?>
                </select>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Примечание
                </label>
            </div>
            <div class="col-md-9">
                <textarea name="text" class="form-control" placeholder="Примечание"><?php echo htmlspecialchars(Arr::path($data->values, 'text'), ENT_QUOTES);?></textarea>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?php
        $view = View::factory('ab1/35/_addition/files');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->columnSize = 12;
        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>