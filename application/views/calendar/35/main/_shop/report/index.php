<?php
$time2 = date('d.m.Y');
$time1 = date('d.m.Y');
?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('calendar/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h3>Остатки по ГТД</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/receive_gtd'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>Возврат продуктов</h3>
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
            <h3>Прием продуктов</h3>
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
            <h3>Отчет реализации товаров по сотруднику</h3>
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
            <h3>Отчет реализации товаров по сотрудникам</h3>
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
            <h3>Сумма реализации</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shoprealization/period_total'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период от</label>
                                <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1.' 00:00'; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период до</label>
                                <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2.' 23:59:59'; ?>">
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