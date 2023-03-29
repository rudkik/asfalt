<?php
$time2 = date('d.m.Y',strtotime('+1 day')).' 06:00';
$time1 = date('d.m.Y').' 06:00';
?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/lab/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h3>ЛБ03 Насыпная плотность в состоянии естественной влажности</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/material_moisture'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="material_moisture-date_from">Период от</label>
                                <input id="material_moisture-date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus(Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'))); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="material_moisture-date_to">Период до</label>
                                <input id="material_moisture-date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
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
            <h3>ВС01 Сводка по реализации</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/realization_turn_type'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exit_at_from">Период от</label>
                                <input id="exit_at_from" class="form-control" name="exit_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exit_at_to">Период до</label>
                                <input id="exit_at_to" class="form-control" name="exit_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_product_rubric_id">Рубрика</label>
                                <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
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
            <h3>ВС02 Сводка по выпуску (АСУ/Место погрузки)</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/realization_asu'); ?>" method="post" enctype="multipart/form-data" >
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_product_rubric_id2">Рубрика</label>
                                <select id="shop_product_rubric_id2" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
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
            <h3>ВС08 Отчет по завозу материалов</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/material_daughter'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период от</label>
                                <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период до</label>
                                <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
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
            <h2 class="text-light-blue">Отчеты по заявкам</h2>
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
        </div>
	</div>
</div>