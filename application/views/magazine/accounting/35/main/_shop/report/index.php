<?php
$time2 = date('d.m.Y');
$time1 = date('d.m.Y');
?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('magazine/accounting/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h3>Отчет по поступлению денежных средств по фискальному регистратору</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/cashbox_days'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="cashbox_days-created_at_from">Период от</label>
                                <input id="cashbox_days-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus($time1); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="cashbox_days-created_at_to">Период до</label>
                                <input id="cashbox_days-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus($time2); ?>">
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
            <h3>Отчет по движению денег</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/cashbox_index'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="realization_special_list-created_at_from">Период от</label>
                                <input id="realization_special_list-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="realization_special_list-created_at_to">Период до</label>
                                <input id="realization_special_list-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo $time2; ?>">
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
            <h3>Ведомость удержаний</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/realization_special_list'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="realization_special_list-created_at_from">Период от</label>
                                <input id="realization_special_list-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="realization_special_list-created_at_to">Период до</label>
                                <input id="realization_special_list-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo $time2; ?>">
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
            <h3>Отчет о перемещении продукции собственного производства</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/move_list_v2'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="move_list_v2-created_at_from">Период от</label>
                                <input id="move_list_v2-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo $time1.' 00:00'; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="move_list_v2-created_at_to">Период до</label>
                                <input id="move_list_v2-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo $time2.' 23:59:59'; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="move_list-created_at_to">Склад (откуда)</label>
                                <select data-type="select2" id="move_list-shop_branch_id" name="shop_branch_id" class="form-control select2" required style="width: 100%;">
                                    <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="move_list-branch_move_id">Склад (куда)</label>
                                <select data-type="select2" id="move_list-branch_move_id" name="branch_move_id" class="form-control select2" required style="width: 100%;">
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
            <h3>Отчет приемки по поставщикам</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/receive_supplier'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="receive_supplier-created_at_from">Период от</label>
                                <input id="receive_supplier-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="receive_supplier-created_at_to">Период до</label>
                                <input id="receive_supplier-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="receive_supplier-shop_supplier_id">Поставщик</label>
                                <select data-type="select2" id="receive_supplier-shop_supplier_id" name="shop_supplier_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Выберите поставщика</option>
                                    <?php echo $siteData->globalDatas['view::_shop/supplier/list/list']; ?>
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
            <h3>Отчет по отоваренным талонам</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/talon_list_period'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="talon_list_period-created_at_from">Период от</label>
                                <input id="talon_list_period-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="talon_list_period-created_at_to">Период до</label>
                                <input id="talon_list_period-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo $time2; ?>">
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
            <h3>Отчет по начисленным талонам</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/talon_list'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="talon_list-month">Месяц</label>
                                <select id="talon_list-month" name="month" class="form-control select2" data-type="select2" style="width: 100%" required>
                                    <option value="1" data-id="1" selected>Январь</option>
                                    <option value="2" data-id="2">Февраль</option>
                                    <option value="3" data-id="3">Март</option>
                                    <option value="4" data-id="4">Апрель</option>
                                    <option value="5" data-id="5">Май</option>
                                    <option value="6" data-id="6">Июнь</option>
                                    <option value="7" data-id="7">Июль</option>
                                    <option value="8" data-id="8">Август</option>
                                    <option value="9" data-id="9">Сентябрь</option>
                                    <option value="10" data-id="10">Октябрь</option>
                                    <option value="11" data-id="11">Ноябрь</option>
                                    <option value="12" data-id="12">Декабрь</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="talon_list-year">Год</label>
                                <input id="talon_list-year" name="year" type="text" class="form-control" placeholder="Год" value="<?php echo date('Y');?>" required>
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
            <h3>Отчет по возврату продуктов поставщику</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/return_list'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="receive_list-created_at_from">Период от</label>
                                <input id="receive_list-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo $time1.' 00:00'; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="receive_list-created_at_to">Период до</label>
                                <input id="receive_list-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo $time2.' 23:59:59'; ?>">
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
            <h3>Прайс-лист продукции</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/production_stock_price'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-12">
                            <label class="span-checkbox">
                                <input name="is_all" value="0" type="checkbox" class="minimal">
                                Показать полный список
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Прайс-лист</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>Перемещение продукции</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/move_list'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="move_list-created_at_from">Период от</label>
                                <input id="move_list-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo $time1.' 00:00'; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="move_list-created_at_to">Период до</label>
                                <input id="move_list-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo $time2.' 23:59:59'; ?>">
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
            <h3>Реализация продукции</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/realization_list'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="realization_list-created_at_from">Период от</label>
                                <input id="realization_list-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo $time1.' 00:00'; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="realization_list-created_at_to">Период до</label>
                                <input id="realization_list-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo $time2.' 23:59:59'; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="realization_list-shop_production_rubric_id">Рубрика</label>
                                <select data-type="select2" id="realization_list-shop_production_rubric_id" name="shop_production_rubric_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Выберите рубрики</option>
                                    <?php echo $siteData->globalDatas['view::_shop/production/rubric/list/list']; ?>
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
            <h3>Реализация спецпродукта</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/realization_special'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="realization_list-created_at_from">Период от</label>
                                <input id="realization_list-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo $time1.' 00:00'; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="realization_list-created_at_to">Период до</label>
                                <input id="realization_list-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo $time2.' 23:59:59'; ?>">
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
            <h3>Отчет по поступлению продуктов</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/receive_list'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="receive_list-created_at_from">Период от</label>
                                <input id="receive_list-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo $time1.' 00:00'; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="receive_list-created_at_to">Период до</label>
                                <input id="receive_list-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo $time2.' 23:59:59'; ?>">
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
            <h3>Отчет реализации продукции по сотруднику</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/realization_worker'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_worker_id">Сотрудник</label>
                                <select data-type="select2" id="shop_worker_id" name="shop_worker_id" class="form-control select2" required style="width: 100%;">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="created_at_from">Период от</label>
                                <input id="created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="created_at_to">Период до</label>
                                <input id="created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo $time2; ?>">
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
            <h3>Отчет реализации продукции по сотрудникам</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/realization_workers'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период от</label>
                                <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период до</label>
                                <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo $time2; ?>">
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
            <h3>Материальный отчёт</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/total'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="total-date_from">Период от</label>
                                <input id="total-date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo date('d.m.Y', strtotime('-1 month')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="total-date_to">Период до</label>
                                <input id="total-date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
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
            <h3>Развернутый отчет по реализации по чекам</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/tax_checks'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tax_checks-created_at_from">Период от</label>
                                <input id="tax_checks-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tax_checks-created_at_to">Период до</label>
                                <input id="tax_checks-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
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
    function loadRealizations(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shoprealization/period_total'); ?>');
    }
</script>