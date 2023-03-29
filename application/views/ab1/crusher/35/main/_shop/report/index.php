<?php
$time2 = date('d.m.Y',strtotime('+1 day')).' 06:00';
$time1 = date('d.m.Y').' 06:00';
?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/crusher/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h3>НУ01 Сводка по балласту выпуск материала</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/ballast_raw_material'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="ballast_raw_material-date_from">Период от</label>
                                <input id="ballast_raw_material-date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="ballast_raw_material-date_to">Период до</label>
                                <input id="ballast_raw_material-date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <input name="is_waybill" value="1" style="display: none">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>НУ02 Акт переработки каменных материалов</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/ballast_act_issuance'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="ballast_raw_material-date_from">Период от</label>
                                <input id="ballast_raw_material-date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'))); ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="ballast_raw_material-date_to">Период до</label>
                                <input id="ballast_raw_material-date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <input name="is_waybill" value="1" style="display: none">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>НУ03 Справка по выпуску каменных материалов</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/ballast_issuance'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="ballast_raw_material-date_from">Период от</label>
                                <input id="ballast_raw_material-date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'))); ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="ballast_raw_material-date_to">Период до</label>
                                <input id="ballast_raw_material-date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <input name="is_waybill" value="1" style="display: none">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>