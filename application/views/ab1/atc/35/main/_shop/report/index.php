<?php
$time2 = date('d.m.Y',strtotime('+1 day')).' 06:00';
$time1 = date('d.m.Y').' 06:00';
$date = date('d.m.Y');
?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/atc/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h3>АТ01 Анализ работы грузоперевозок транспортных средств МАТЕРИАЛА</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/material_analysis'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата</label>
                                <input id="date" class="form-control" name="date" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_material_rubric_id">Рубрика</label>
                                <select id="shop_material_rubric_id" name="shop_material_rubric_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/material/rubric/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date">Транспорная компания</label>
                                <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/transport/company/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_branch_id">Филиал</label>
                                <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input name="is_quantity_receive" value="0" style="display: none;">
                                <input type="checkbox" name="is_quantity_receive" class="login-checkbox" id="is_quantity_receive">
                                <label for="is_quantity_receive">По количеству получателя</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p>
                                    Расчет:
                                    <br>если стоит галочка <b>По количеству получателя</b>, то суммируется вес по приезду машины
                                    <br>иначе, суммируется вес по накладной, если есть или вес отправителя
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>АТ02 Анализ работы грузоперевозок транспортных средств МАТЕРИАЛА за период</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/material_analysis_10'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата от</label>
                                <input id="date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus(Helpers_DateTime::minusDays(date('d.m.Y'), 10)); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата до</label>
                                <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_material_rubric_id">Рубрика</label>
                                <select id="shop_material_rubric_id" name="shop_material_rubric_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/material/rubric/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date">Транспорная компания</label>
                                <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/transport/company/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <input name="is_quantity_receive" value="0" style="display: none;">
                                <input type="checkbox" name="is_quantity_receive" class="login-checkbox" id="is_quantity_receive">
                                <label for="is_quantity_receive">По количеству получателя</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input name="is_vertical" value="0" style="display: none;">
                                <input type="checkbox" name="is_vertical" class="login-checkbox" id="is_vertical" value="1" checked>
                                <label for="is_vertical">Вертикальный</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p>
                                    Расчет:
                                    <br>если стоит галочка <b>По количеству получателя</b>, то суммируется вес по приезду машины
                                    <br>иначе, суммируется вес по накладной, если есть или вес отправителя
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>АТ03 Анализ работы грузоперевозок транспортных средств ПРОДУКЦИИ</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/product_analysis'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата</label>
                                <input id="date" class="form-control" name="date" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_product_rubric_id">Рубрика</label>
                                <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php if($siteData->operation->getOperationTypeID() == Model_OperationType::ATC_MECHANIC || $siteData->operation->getIsAdmin()){ ?>
            <h3>АТ04 Анализ работы грузоперевозок транспортных средств БАЛЛАСТА</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/ballast_analysis'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата</label>
                                <input id="date" class="form-control" name="date" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>АТ10 Расход топлива по автомобилям</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/transport_act_fuel'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата от</label>
                                <input id="date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus(Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'))); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата до</label>
                                <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="transport_act_fuel-transport_type_1c_id">Тип транспорта 1С</label>
                                <select id="transport_act_fuel-transport_type_1c_id" name="transport_type_1c_id" class="form-control select2" style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::transport/type1c/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php }?>
            <h3>АТ11 УЗТ Табель учета рабочего времени (транспорт)</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/waybill_work'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата от</label>
                                <input id="date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus(Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'))); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата до</label>
                                <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php if($siteData->operation->getOperationTypeID() == Model_OperationType::ATC_MECHANIC || $siteData->operation->getIsAdmin()){ ?>
                <h3>АТ15 Материальный отчет по ГСМ</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/transport_fuels'); ?>" method="get" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="date">Дата от</label>
                                    <input id="date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus(Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'))); ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="date">Дата до</label>
                                    <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>АТ16 Табель учета маршрутов водителей</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/waybill_route'); ?>" method="get" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="date">Дата от</label>
                                    <input id="date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus(Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'))); ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="date">Дата до</label>
                                    <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>

                <h3>ВС13 Прочие машины</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/move_other_list'); ?>" method="get" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="created_at_from">Период от</label>
                                    <input id="created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="created_at_to">Период до</label>
                                    <input id="created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="move_other_list_shop_material_id">Материал</label>
                                    <select id="move_other_list_shop_material_id" name="shop_material_id" class="form-control select2" style="width: 100%;">
                                        <option value="-1" data-id="-1">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="move_other_list_shop_material_id">Материал</label>
                                    <select id="move_other_list_shop_material_id" name="shop_material_id" class="form-control select2" style="width: 100%;">
                                        <option value="-1" data-id="-1">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>ВС17 Пустые машины</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/move_empty_list'); ?>" method="get" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-1-5">
                                <div class="form-group">
                                    <label for="created_at_from">Период от</label>
                                    <input id="created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-1-5">
                                <div class="form-group">
                                    <label for="created_at_to">Период до</label>
                                    <input id="created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
            <h3>ПР01 Заявка на день</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/plan_day_fixed'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата от</label>
                                <input id="date" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo date('d.m.Y', strtotime('+1 day')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата до</label>
                                <input id="date" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y', strtotime('+1 day')); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php }?>
            <h3>АТ19 Итоги по начислениям водителям</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/waybill_total_wage'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="waybill_work_days-date">Дата от</label>
                                <input id="waybill_work_days-date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus(Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'))); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="waybill_work_days-date_to">Дата до</label>
                                <input id="waybill_work_days-date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>АТ20 Количество отработанных часов</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/waybill_work_days'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="waybill_work_days-date">Дата от</label>
                                <input id="waybill_work_days-date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus(Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'))); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="waybill_work_days-date_to">Дата до</label>
                                <input id="waybill_work_days-date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="waybill_work_days-shop_transport_work_id">Параметр выработки</label>
                                <select id="waybill_work_days-shop_transport_work_id" name="shop_transport_work_id" class="form-control select2" style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/transport/work/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="waybill_work_days-shop_subdivision_id">Подразделение</label>
                                <select id="waybill_work_days-shop_subdivision_id" name="shop_subdivision_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/subdivision/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>АТ21 Ремонтная ведомость</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/transport_repair_days'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="transport_repair_days-date_from">Дата от</label>
                                <input id="transport_repair_days-date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus(Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'))); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="transport_repair_days-date_to">Дата до</label>
                                <input id="transport_repair_days-date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="transport_repair_days-shop_branch_id">Филиал</label>
                                <select id="transport_repair_days-shop_branch_id" name="shop_branch_id" class="form-control select2" style="width: 100%;">
                                    <option value="-1">Все филиалы</option>
                                    <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>

            <h3>БТ03 Реестр начисления заработной платы водителям карьера</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/ballast_salary'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ballast_salary-created_at_from">Период от</label>
                                <input id="ballast_salary-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ballast_salary-created_at_to">Период до</label>
                                <input id="ballast_salary-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ballast_salary-shop_ballast_driver_id">Водитель</label>
                                <select id="ballast_salary-shop_ballast_driver_id" name="shop_ballast_driver_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/ballast/driver/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ballast_salary-shop_branch_id">Филиал</label>
                                <select id="ballast_salary-shop_branch_id" name="shop_branch_id" class="form-control select2" style="width: 100%;">
                                    <option value="-1">Все филиалы</option>
                                    <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>
<script>
    function loadProducts(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/loadproduct'); ?>');
    }
    function loadClients(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/loadclient'); ?>');
    }
    function saveCars(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/savecars'); ?>');
    }
    function savePayments(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/savepayments'); ?>');
    }
    function saveСonsumables(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/saveconsumables'); ?>');
    }

    // выбираем новый файл
    $('input[type="file"]').change(function () {
        s = '';
        for(i = 0; i < this.files.length; i++){
            s = s + this.files[i].name + '; '
        }
        s = s.substr(0, s.length - 2);
        p = $(this).parent().attr('data-text', s);

    });
</script>