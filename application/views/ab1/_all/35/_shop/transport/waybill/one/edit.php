<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && (!$siteData->operation->getIsAdmin() || Request_RequestParams::getParamBoolean('is_show_admin')); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Номер
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="text" class="form-control" placeholder="Номер" value="<?php echo htmlspecialchars($data->values['number'], ENT_QUOTES); ?>" <?php if($isShow){?>readonly<?php }?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дата
        </label>
    </div>
    <div class="col-md-3">
        <input name="date" type="datetime"  date-type="date"  class="form-control" placeholder="Дата" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>" required <?php if($isShow){?>disabled<?php }?>>
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
        <select id="shop_transport_id" name="shop_transport_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
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
        <select id="shop_subdivision_id" name="shop_subdivision_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/subdivision/list/list']; ?>
        </select>
    </div>
</div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Вид транспорта
            </label>
        </div>
        <div class="col-md-3">
            <select id="transport_view_id" name="transport_view_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::transport/view/list/list']; ?>
            </select>
        </div>
        <div class="col-md-3 record-title">
            <label>
                Вид работ
            </label>
        </div>
        <div class="col-md-3">
            <select id="transport_work_id" name="transport_work_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::transport/work/list/list']; ?>
            </select>
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Оплата
            </label>
        </div>
        <div class="col-md-3">
            <select id="transport_wage_id" name="transport_wage_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::transport/wage/list/list']; ?>
            </select>
        </div>
        <div class="col-md-3 record-title">
            <label>
                Вид оплаты
            </label>
        </div>
        <div class="col-md-3">
            <select id="transport_form_payment_id" name="transport_form_payment_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::transport/form-payment/list/list']; ?>
            </select>
        </div>
    </div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Комментарий
        </label>
    </div>
    <div class="col-md-9">
        <textarea name="text" class="form-control" placeholder="Комментарий" <?php if($isShow){?>disabled<?php }?>><?php echo htmlspecialchars(Arr::path($data->values, 'text', ''), ENT_QUOTES);?></textarea>
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
    <?php if(!$isShow) { ?>
        <li class="pull-right">
            <button type="button" class="btn bg-blue btn-flat pull-right" onclick="getMilageFuel()">Пересчитать</button>
        </li>
    <?php } ?>
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
                        <select id="shop_transport_driver_id" name="shop_transport_driver_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
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
                        <input name="from_at" type="datetime"  date-type="datetime"  class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['from_at']); ?>" required <?php if($isShow){?>readonly<?php }?>>
                    </div>
                    <div class="col-md-3 record-title">
                        <label>
                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                            Спидометр при выезде
                        </label>
                    </div>
                    <div class="col-md-3">
                        <input name="milage_from" type="phone" class="form-control" placeholder="Спидометр при выезде" value="<?php echo $data->values['milage_from']; ?>" readonly>
                    </div>
                </div>
                <div class="row record-input record-list">
                    <div class="col-md-3 record-title">
                        <label>
                            Дата заезда
                        </label>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input name="to_at" type="datetime"  date-type="datetime"  class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['to_at']); ?>" <?php if($isShow){?>readonly<?php }?>>
                            <a href="#" data-action="get-finish-date" class="input-group-addon" style="padding: 5px 5px;"><i class="fa fa-fw fa-hourglass-2" style="font-size: 16px;"></i></a>
                        </div>
                    </div>
                    <div class="col-md-3 record-title">
                        <label>
                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                            Спидометр при заезде
                        </label>
                    </div>
                    <div class="col-md-3">
                        <input name="milage_to" type="phone" class="form-control" placeholder="Спидометр при заезде" value="<?php echo $data->values['milage_to']; ?>" <?php if($isShow){?>readonly<?php }?>>
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
                        <input data-type="money" data-fractional-length="2" name="milage" type="phone" class="form-control" placeholder="Пробег" value="<?php if($data->values['milage'] != 0){echo Func::getNumberStr($data->values['milage'], true);} ?>" <?php if($isShow){?>readonly<?php }?>>
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
                        <input name="fuel_quantity_from" type="phone" class="form-control" placeholder="Остаток топлива" value="<?php echo $data->values['fuel_quantity_from']; ?>" readonly>
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
                        <input name="fuel_quantity_to" type="phone" class="form-control" placeholder="Остаток топлива" value="<?php echo $data->values['fuel_quantity_to']; ?>" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="tab-cars" style="padding-top: 10px;">
        <h4>Выполненные перевозки с грузом</h4>
        <?php echo $siteData->globalDatas['view::_shop/transport/waybill/car/list/index'];?>
    </div>
    <div class="tab-pane" id="tab-works" style="padding-top: 10px;">
        <div class="row">
            <div class="col-md-6">
                <h4>Транспортные средства</h4>
                <?php echo $siteData->globalDatas['view::_shop/transport/waybill/work/car/list/index'];?>
            </div>
            <div class="col-md-6">
                <h4 class="pull-left">Водители</h4>
                <?php if(!$isShow){?>
                <button type="button" class="btn bg-purple btn-flat pull-right" onclick="getWorks()">Заполнить</button>
                <?php }?>
                <?php echo $siteData->globalDatas['view::_shop/transport/waybill/work/driver/list/index'];?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>

        <input id="is_close" name="is_close" value="1" style="display: none">
        <input id="is_duplicate " name="is_duplicate" value="0" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <div class="btn-group pull-left">
            <button type="button" class="btn bg-purple btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                Печать
                <span class="caret"></span>
                <span class="sr-only">Печать</span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/waybill_c4', array('id' => 'id')); ?>">Путевой лист 4С</a></li>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/waybill_p4', array('id' => 'id')); ?>">Путевой лист 4П</a></li>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/waybill_f3', array('id' => 'id')); ?>">Путевой лист Ф3</a></li>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/waybill_crane', array('id' => 'id')); ?>">Путевой лист Автомобильного крана</a></li>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/waybill_special', array('id' => 'id')); ?>">Путевой лист Спец.техники</a></li>
            </ul>
        </div>
        <a class="btn bg-blue pull-left margin-l-10" href="<?php echo Func::getFullURL($siteData, '/shopreport/waybill_c4', array('id' => 'id')); ?>">Путевой лист 4С</a>
        <a class="btn bg-green pull-left margin-l-10" href="<?php echo Func::getFullURL($siteData, '/shopreport/waybill_total', array('id' => 'id')); ?>">Печать итогов</a>

        <?php if(!$isShow){?>
        <button type="submit" class="btn bg-orange pull-right" data-action="form-duplicate">Сохранить и создать</button>
        <button type="submit" class="btn btn-primary pull-right" data-action="form-save">Сохранить</button>
        <button type="submit" class="btn bg-green pull-right margin-l-10" data-action="form-apply">Применить</button>
        <?php }?>
    </div>
</div>
<?php if(!$isShow){?>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/Datejs/build/date.js"></script>
<script>

    function getMilageFuel(transport) {
        if(transport == undefined){
            transport = $('[name="shop_transport_id"]').val();
        }

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
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    function getCarIndicators(transport, isUpdateMilage) {
        var trailers = [];
        $('#trailers [data-id="shop_transport_id"]').each(function () {
            trailers.push($(this).val());
        });

        jQuery.ajax({
            url: '/<?php echo $siteData->actionURLName; ?>/shoptransportwaybill/car_works',
            data: ({
                'id': (<?php echo Request_RequestParams::getParamInt('id'); ?>),
                'shop_transport_id': (transport),
                'trailers': (trailers),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                $('#car-indicators').html(obj.cars);
                $('#works').html(obj.work_drivers);

                if(isUpdateMilage) {
                    var milage = $('[name="milage"]').valNumber();
                    if(!isNaN(milage)) {
                        $('[data-indicator="<?php echo Model_Ab1_Indicator_Type::INDICATOR_TYPE_MILAGE ?>"]').valNumber(milage.toFixed(2));
                        $('[data-indicator="<?php echo Model_Ab1_Indicator_Type::INDICATOR_TYPE_MILAGE_GARGO ?>"]').valNumber((milage / 2).toFixed(2));
                    }
                }

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

    function getWorks() {
        var transport = $('[name="shop_transport_id"]').val();

        if(transport > 0){
            jQuery.ajax({
                url: '/<?php echo $siteData->actionURLName; ?>/shoptransportwaybill/refresh_cars',
                data: ({
                    'shop_transport_waybill_id': (<?php echo $data->id; ?>),
                    'shop_transport_id': (transport),
                    'date_from': ($('[name="from_at"]').val()),
                    'date_to': ($('[name="to_at"]').val()),
                }),
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    $('#cars').html(obj.cars);
                    $('#works').html(obj.work_drivers);
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }
    }

    // пробег
    $('[name="milage_from"], [name="milage_to"]').change(function () {
        var milageFrom = $('[name="milage_from"]').valNumber();
        var milageTo = $('[name="milage_to"]').valNumber();

        var milage = milageTo - milageFrom;

        if(!(milage > 0)){
            milage = 0.00;
        }

        $('[name="milage"]').val(milage.toFixed(2));
        $('[data-indicator="<?php echo Model_Ab1_Indicator_Type::INDICATOR_TYPE_MILAGE ?>"]').Number(milage.toFixed(2));
        $('[data-indicator="<?php echo Model_Ab1_Indicator_Type::INDICATOR_TYPE_MILAGE_GARGO ?>"]').Number((milage / 2).toFixed(2));
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
            getMilageFuel(transport);
            getCarIndicators(transport, true);
            getAddFuel(transport);
        }
    });

    var transport = $('[name="shop_transport_id"]').val();
    getAddFuel(transport);
    getCarIndicators(transport, true);

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

    }).trigger('change');

    $('[data-action="get-finish-date"]').on('click', function(e) {
        e.preventDefault();
        jQuery.ajax({
            url: '/<?php echo $siteData->actionURLName; ?>/shoptransportwaybill/get_finish_date',
            data: ({
                'id': (<?php echo Request_RequestParams::getParamInt('id'); ?>),
            }),
            type: "POST",
            success: function (data) {
                $('[name="to_at"]').val(data);

            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });
</script>
<?php }?>