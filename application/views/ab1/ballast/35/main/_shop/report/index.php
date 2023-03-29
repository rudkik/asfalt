<?php
$time2 = date('d.m.Y',strtotime('+1 day')).' 06:00';
$time1 = date('d.m.Y').' 06:00';
?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/ballast/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h3>БТ01 Сводка балласта за смену</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/ballast_day'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ballast_day-date">Дата</label>
                                <input id="ballast_day-date" class="form-control" name="date" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ballast_day-shop_work_shift_id">Смена</label>
                                <select id="ballast_day-shop_work_shift_id" name="shop_work_shift_id" class="form-control select2" required style="width: 100%;">
                                    <?php echo $siteData->globalDatas['view::_shop/work/shift/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <?php if($siteData->operation->getIsAdmin()){ ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ballast_day-shop_branch_id">Филиал</label>
                                    <select id="ballast_day-shop_branch_id" name="shop_branch_id" class="form-control select2" style="width: 100%;">
                                        <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>БТ02 Учет рейсов балласта по дням</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/ballast_day_drivers'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ballast_day_drivers-created_at_from">Период от</label>
                                <input id="ballast_day_drivers-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ballast_day_drivers-created_at_to">Период до</label>
                                <input id="ballast_day_drivers-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ballast_day_drivers-shop_ballast_car_id">№ машины</label>
                                <select id="ballast_day_drivers-shop_ballast_car_id" name="shop_ballast_car_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/ballast/car/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ballast_day_drivers-shop_ballast_driver_id">Водитель</label>
                                <select id="ballast_day_drivers-shop_ballast_driver_id" name="shop_ballast_driver_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/ballast/driver/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <?php if($siteData->operation->getIsAdmin()){ ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ballast_day_drivers-shop_branch_id">Филиал</label>
                                    <select id="ballast_day_drivers-shop_branch_id" name="shop_branch_id" class="form-control select2" style="width: 100%;">
                                        <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
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
            <h3>ВС16 Справка по выпуску каменных материалов</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/ballast_issuance_month'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="ballast_issuance_month-date_from">Период от</label>
                                <input id="ballast_issuance_month-date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'))); ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="ballast_issuance_month-date_to">Период до</label>
                                <input id="ballast_issuance_month-date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo $time1; ?>">
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