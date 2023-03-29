<div class="callout callout-danger" id="previous-waybill" style="display: none">
    <h4>Найден предыдущий незакрытый путевой лист.</h4>
    <p><a target="_blank" href=""></a></p>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Номер
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="text" class="form-control" placeholder="Номер">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дата
        </label>
    </div>
    <div class="col-md-3">
        <input name="date" type="datetime"  date-type="date"  class="form-control" placeholder="Дата" value="<?php echo date('d.m.Y'); ?>" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Транспортное средство
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_transport_id" name="shop_transport_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/transport/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Подразделение
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_subdivision_id" name="shop_subdivision_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/subdivision/list/list']; ?>
        </select>
    </div>
</div>
<ul class="nav nav-tabs">
    <li class="nav-item active">
        <a class="nav-link active" data-toggle="tab" href="#tab-main">Основные</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab-fuels">Движение ГСМ</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab-cars">Задание водителю</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab-works">Выработки</a>
    </li>
</ul>
<div class="tab-content" style="min-height: 500px">
    <div class="tab-pane fade active in" id="tab-main" style="padding-top: 10px;">
        <div class="row">
            <div class="col-md-6">
                <div class="row record-input record-list">
                    <div class="col-md-3 record-title">
                        <label>
                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                            Водитель
                        </label>
                    </div>
                    <div class="col-md-9">
                        <select id="shop_transport_driver_id" name="shop_transport_driver_id" class="form-control select2" required style="width: 100%;">
                            <option value="0" data-id="0">Без значения</option>
                            <?php echo $siteData->globalDatas['view::_shop/transport/driver/list/list']; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row record-input record-list">
                    <div class="col-md-3 record-title">
                        <label>
                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                            Дата выезда
                        </label>
                    </div>
                    <div class="col-md-3">
                        <input name="from_at" type="datetime"  date-type="datetime"  class="form-control" value="<?php echo date('d.m.Y H:i:d'); ?>" required>
                    </div>
                    <div class="col-md-3 record-title">
                        <label>
                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                            Спидометр при выезде
                        </label>
                    </div>
                    <div class="col-md-3">
                        <input name="milage_from" type="phone" class="form-control" placeholder="Спидометр при выезде" readonly>
                    </div>
                </div>
                <div class="row record-input record-list">
                    <div class="col-md-3 record-title">
                        <label>
                            Дата заезда
                        </label>
                    </div>
                    <div class="col-md-3">
                        <input name="to_at" type="datetime"  date-type="datetime"  class="form-control">
                    </div>
                    <div class="col-md-3 record-title">
                        <label>
                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                            Спидометр при заезде
                        </label>
                    </div>
                    <div class="col-md-3">
                        <input name="milage_to" type="phone" class="form-control" placeholder="Спидометр при заезде">
                    </div>
                </div>
                <div class="row record-input record-list">
                    <div class="col-md-3 record-title"><label></label></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3 record-title">
                        <label>
                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                            Пробег
                        </label>
                    </div>
                    <div class="col-md-3">
                        <input data-type="money" data-fractional-length="2" name="milage" type="phone" class="form-control" placeholder="Пробег">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h4>Прицепы и механизмы</h4>
                <?php echo $siteData->globalDatas['view::_shop/transport/waybill/trailer/list/index'];?>
            </div>
            <div class="col-md-6">
                <h4>Сопровождающие лица</h4>
                <?php echo $siteData->globalDatas['view::_shop/transport/waybill/escort/list/index'];?>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="tab-fuels" style="padding-top: 10px;">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="row record-input record-list">
                    <div class="col-md-3 record-title"><label></label></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3 record-title">
                        <label>
                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                            Остаток топлива при выезде
                        </label>
                    </div>
                    <div class="col-md-3">
                        <input name="fuel_quantity_from" type="phone" class="form-control" placeholder="Остаток топлива" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h4>Выдача ГСМ</h4>
                <?php echo $siteData->globalDatas['view::_shop/transport/waybill/fuel/issue/list/index'];?>
            </div>
            <div class="col-md-6">
                <h4>Расход ГСМ</h4>
                <?php echo $siteData->globalDatas['view::_shop/transport/waybill/fuel/expense/list/index'];?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="row record-input record-list">
                    <div class="col-md-3 record-title"><label></label></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3 record-title">
                        <label>
                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                            Остаток топлива при возвращении
                        </label>
                    </div>
                    <div class="col-md-3">
                        <input name="fuel_quantity_to" type="phone" class="form-control" placeholder="Остаток топлива" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="tab-cars" style="padding-top: 10px;">
        <div class="row">
            <div class="col-md-12">
                <h4 class="pull-left">Выполненные перевозки с грузом</h4>
                <button type="button" class="btn bg-purple btn-flat pull-right" disabled>Заполнить</button>
            </div>
        </div>
        <?php echo $siteData->globalDatas['view::_shop/transport/waybill/car/list/index'];?>
    </div>
    <div class="tab-pane" id="tab-works" style="padding-top: 10px;">
        <div class="row">
            <div class="col-md-6">
                <h4>Транспортные средства</h4>
                <?php echo $siteData->globalDatas['view::_shop/transport/waybill/work/car/list/index'];?>
            </div>
            <div class="col-md-6">
                <h4>Водители</h4>
                <?php echo $siteData->globalDatas['view::_shop/transport/waybill/work/driver/list/index'];?>
            </div>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Комментарий
        </label>
    </div>
    <div class="col-md-9">
        <textarea name="text" rows="1" class="form-control" placeholder="Комментарий"></textarea>
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
<script>
    function getPreviousWaybill(transport) {
        jQuery.ajax({
            url: '/<?php echo $siteData->actionURLName; ?>/shoptransportwaybill/json?_fields[]=number',
            data: ({
                'shop_transport_id': (transport),
                'fuel_quantity_expenses_empty': (1),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if(obj.length > 0){
                    $('#previous-waybill').css('display', 'block');

                    obj = obj[0];
                    var a = $('#previous-waybill').find('a');
                    a.text('№' + obj.number).attr('href', '/<?php echo $siteData->actionURLName; ?>/shoptransportwaybill/edit?id=' + obj.id);
                }else{
                    $('#previous-waybill').css('display', 'none');
                }

            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    function getCarIndicators(transport) {
        var trailers = [];
        $('#trailers [data-id="shop_transport_id"]').each(function () {
            trailers.push($(this).val());
        });

        jQuery.ajax({
            url: '/<?php echo $siteData->actionURLName; ?>/shoptransportwaybill/car_works',
            data: ({
                'shop_transport_id': (transport),
                'trailers': (trailers),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                $('#car-indicators').html(obj.cars);
                $('#works').html(obj.work_drivers);

                var milage = $('[name="milage"]').valNumber();
                $('[data-indicator="<?php echo Model_Ab1_Indicator_Type::INDICATOR_TYPE_MILAGE ?>"]').valNumber(milage.toFixed(2));
                $('[data-indicator="<?php echo Model_Ab1_Indicator_Type::INDICATOR_TYPE_MILAGE_GARGO ?>"]').valNumber((milage / 2).toFixed(2));

            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    function getAddFuel(transport) {
        jQuery.ajax({
            url: '/<?php echo $siteData->actionURLName; ?>/shoptransport/fuels',
            data: ({
                'id': (transport),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));

                if(obj.length > 0) {
                    obj = obj[0];

                    $('#add-fuel-issue').html(
                        '<button type="button" class="btn btn-primary pull-right" onclick="addFuelIssueValue(\'' + obj.fuel_id + '\', \'' + obj.fuel_issue_id + '\', \'new-fuel-issue\', \'fuel-issues\', true);">Добавить ' + obj.fuel_name + '</button>'
                    );
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    // пробег
    $('[name="milage_from"], [name="milage_to"]').change(function () {
        var milageFrom = $('[name="milage_from"]').valNumber();
        var milageTo = $('[name="milage_to"]').valNumber();

        var milage = milageTo - milageFrom;

        if(!(milage > 0)){
            milage = 0.00;
        }

        $('[name="milage"]').valNumber(milage.toFixed(2));
        $('[data-indicator="<?php echo Model_Ab1_Indicator_Type::INDICATOR_TYPE_MILAGE ?>"]').valNumber(milage.toFixed(2));
        $('[data-indicator="<?php echo Model_Ab1_Indicator_Type::INDICATOR_TYPE_MILAGE_GARGO ?>"]').valNumber((milage / 2).toFixed(2));
    });
    $('[name="milage"]').change(function () {
        var milageFrom = $('[name="milage_from"]').valNumber();
        var milage = $('[name="milage"]').valNumber();

        var milageTo = milage + milageFrom;

        if(milageTo > 0){
            $('[name="milage_to"]').valNumber(milageTo.toFixed(2));
        }else{
            $('[name="milage_to"]').valNumber(0.00);
        }

        if(milage > 0){
            $('[data-indicator="<?php echo Model_Ab1_Indicator_Type::INDICATOR_TYPE_MILAGE ?>"]').valNumber(milage.toFixed(2));
            $('[data-indicator="<?php echo Model_Ab1_Indicator_Type::INDICATOR_TYPE_MILAGE_GARGO ?>"]').valNumber((milage / 2).toFixed(2));
        }else{
            $('[data-indicator="<?php echo Model_Ab1_Indicator_Type::INDICATOR_TYPE_MILAGE ?>"]').valNumber(0.00);
            $('[data-indicator="<?php echo Model_Ab1_Indicator_Type::INDICATOR_TYPE_MILAGE_GARGO ?>"]').valNumber(0.00);
        }
    });

    // топливо
    $('[name="fuel_quantity_from"]').change(function () {
        var total = $('[name="fuel_quantity_from"]').valNumber();
        $('#fuel-issues [data-id="quantity"]').each(function (i) {
            total = total + $(this).valNumber();
        });
        $('#fuel-expenses [data-id="quantity"]').each(function (i) {
            total = total - $(this).valNumber();
        });

        if(total > 0){
            $('[name="fuel_quantity_to"]').valNumber(total.toFixed(3));
        }else{
            $('[name="fuel_quantity_to"]').valNumber(0.00);
        }
    });

    // дата
    $('[name="date"]').change(function () {
        var date = $(this).val();

        var element = $('[name="from_at"]');
        var s = element.val();
        if(s != '') {
            element.val(date + s.substring(10, 16));
        }

        var element = $('[name="to_at"]');
        var s = element.val();
        if(s != '') {
            element.val(date + s.substring(10, 16));
        }
    });

    $('[name="shop_transport_id"], [name="from_at"]').change(function () {
        var transport = $(this).val();

        if(transport > 0){
            jQuery.ajax({
                url: '/<?php echo $siteData->actionURLName; ?>/shoptransport/get_milage_fuel',
                data: ({
                    'id': (transport),
                    'date': ($('[name="from_at"]').val()),
                }),
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    $('[name="milage_from"]').valNumber(obj.milage.toFixed(2));
                    $('[name="milage"]').trigger('change');
                    if ($('[name="milage"]').val() == '') {
                        $('[name="milage_to"]').trigger('change');
                    }

                    $('[name="fuel_quantity_from"]').valNumber(obj.fuel_quantity.toFixed(3)).trigger('change');
                    $('[name="shop_transport_driver_id"]').val(obj.shop_transport_driver_id).trigger('change');
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });

            getCarIndicators(transport);
            getAddFuel(transport);
            getPreviousWaybill(transport);
        }

        $('[name="milage"]').trigger('change');
    });

    var transport = $('[name="shop_transport_id"]').val();
    if(transport > 0){
        $('[name="shop_transport_id"]').trigger('change');
    }

    $('input').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            $(this).trigger('change');
        }
    });

    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $('[name="from_at"], [name="to_at"]').on('change', function(e) {
        jQuery.ajax({
            url: '/ab1/func/diff_hours',
            data: ({
                'date_from': ($('[name="from_at"]').val()),
                'date_to': ($('[name="to_at"]').val()),
            }),
            type: "GET",
            success: function (data) {
                if(data < 1){
                    $('[name="from_at"], [name="to_at"]').parent().addClass('has-error');
                }else{
                    $('[name="from_at"], [name="to_at"]').parent().removeClass('has-error');
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });
</script>