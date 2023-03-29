<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-1-5">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none;">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Показать
        </label>
    </div>
    <div class="col-md-1-5">
        <label class="span-checkbox">
            <input name="is_wage" value="0" style="display: none;">
            <input name="is_wage" value="1" checked type="checkbox" class="minimal">
            Учитывает рейсы в зарплате?
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Основное средство
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_transport_mark_id" name="shop_transport_mark_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/transport/mark/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Гараж
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_branch_storage_id" name="shop_branch_storage_id" class="form-control select2" required style="width: 100%;">
            <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
        </select>
    </div>
</div>
<ul class="nav nav-tabs">
    <li class="nav-item active">
        <a class="nav-link active" data-toggle="tab" href="#tab-main">Основные</a>
    </li>
    <li id="tab-calc-li" class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab-calc">Сведения для расчета расхода ГСМ</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab-works">Параметры выработки</a>
    </li>
</ul>
<div class="tab-content" style="min-height: 500px">
    <div class="tab-pane fade active in" id="tab-main" style="padding-top: 10px;">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Гос. номер
                </label>
            </div>
            <div class="col-md-3">
                <input name="number" type="text" class="form-control" placeholder="Гос. номер" required>
            </div>
            <div class="col-md-3 record-title"></div>
            <div class="col-md-3">
                <label class="span-checkbox">
                    <input name="is_trailer" value="0" style="display: none;">
                    <input name="is_trailer" value="0" type="checkbox" class="minimal">
                    Прицеп
                </label>
            </div>
        </div>
        <div class="row record-input record-list">
            <div data-id="shop_transport_driver_id" class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Водитель
                </label>
            </div>
            <div data-id="shop_transport_driver_id" class="col-md-3">
                <select id="shop_transport_driver_id" name="shop_transport_driver_id" class="form-control select2" style="width: 100%;">
                    <option value="0" data-id="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/transport/driver/list/list']; ?>
                </select>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Дневная норма
                </label>
            </div>
            <div class="col-md-3">
                <input data-type="money" data-fractional-length="0" name="driver_norm_day" type="phone" class="form-control" placeholder="Дневная норма" required>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Склад учета ГСМ
                </label>
            </div>
            <div class="col-md-9">
                <select id="shop_transport_fuel_storage_id" name="shop_transport_fuel_storage_id" class="form-control select2" style="width: 100%;">
                    <option value="0" data-id="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/transport/fuel/storage/list/list']; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-blue">Коэффициент для расчёта зарплаты</h4>
                <?php echo $siteData->globalDatas['view::_shop/transport/driver/tariff/list/index'];?>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="tab-calc" style="padding-top: 10px;">
        <h4 class="text-blue">Виды ГСМ</h4>
        <?php echo $siteData->globalDatas['view::_shop/transport/to/fuel/list/index'];?>
        <h4 class="text-blue">Значения показателей расчета</h4>
        <?php echo $siteData->globalDatas['view::_shop/transport/to/indicator/season/list/index'];?>
    </div>
    <div class="tab-pane" id="tab-works" style="padding-top: 10px;">
        <h4 class="text-blue">Показатели транспорта</h4>
        <?php echo $siteData->globalDatas['view::_shop/transport/to/work/list/index'];?>
        <h4 class="text-blue">Показатели водителя</h4>
        <?php echo $siteData->globalDatas['view::_shop/transport/to/work/driver/list/index'];?>
    </div>
</div>
<div class="row">
    <input id="is_close" name="is_close" value="1" style="display: none">
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('input[name="is_trailer"]').on('ifChecked', function (event) {
            $('[data-id="shop_transport_driver_id"]').css('display', 'none');
            $('#shop_transport_fuel_storage_id').closest('div.row').css('display', 'none');
            $('#tab-calc-li').css('display', 'none');
        }).on('ifUnchecked', function (event) {
            $('[data-id="shop_transport_driver_id"]').css('display', '');
            $('#shop_transport_fuel_storage_id').closest('div.row').css('display', '');
            $('#tab-calc-li').css('display', '');
        });
    });
</script>